<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Message;
use Pusher\Pusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        // hitung berapa banyak pesan yang belum dibaca oleh user
        
        // $users = DB::select("SELECT users.id, users.name, users.username, users.avatar, count(is_read) as unread
        //     FROM users LEFT JOIN messages ON users.id = messages.user_id AND is_read = 0 and messages.to =" . Auth::id() . "
        //     WHERE users.id != " . Auth::id()  . "
        //     GROUP BY users.id, users.name, users.avatar, users.email
        //     ");
        // $users = collect($users);
        // $users = $users->where('user_id', Auth::id());
        $query = User::query();
        // $users = $query->where('id', '!=', Auth::id())
        $users = $query
            // ->with('message')
            ->with(['messageFrom', 'messageTo'])
            // ->join('messages', 'users.id', 'messages.from')
            // ->where('from', Auth::id())
            // ->orWhere('to', Auth::id())
            ->get();

        return response($users);

        $messages = Message::select(\DB::raw('user_id, count(`user_id`) as messages_count'))
            ->where('user_id', Auth::id())
            ->orWhere('to', Auth::id())
            ->where('is_read', 0)
            ->groupBy('user_id')
            ->get();

        // return response($messages);

        $users = $users->map(function ($user) use ($messages) {
            $userUnread = $messages->where('user_id', $user->id)->first();

            $user->unread = $userUnread ? $userUnread->messages_count : 0;

            return $user;
        });


        return response([
            'status' => 'success',
            'message' => 'Data loaded',
            'data' => $users
        ]);
    }

    public function getMessage($user_id)
    {
        $my_id = Auth::id();

        $user = User::where('id', $user_id)->first();

        // when click to see message selected message will be read, update
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->Where('to', $user_id);
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->Where('to', $my_id);
        })->get();

        return response([
            'status' => 'success',
            'message' => 'Message loaded',
            'profil' => $user,
            'data' => $messages
        ]);
    }

    public function sendMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->to;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();

        $options = [
            'cluster' => 'ap1',
            'useTLS' => true
        ];

        $pusher = new Pusher(
            '8d28dfe973d0377c124b',
            'a91a7e8d600915953718',
            '1111413',
            $options
        );

        $data = ["from" => $from, "to" => $to, "message" => $message];
        $pusher->trigger('my-channel', 'my-event', $data);

        return response([
            'status' => 'success',
            'message' => 'Message sent',
            'data' => $data
        ]);
    }
}
