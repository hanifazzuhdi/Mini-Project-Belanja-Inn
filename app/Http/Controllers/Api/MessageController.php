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
        $users = DB::select("SELECT users.id, users.name, users.username, users.avatar, count(is_read) as unread
            FROM users LEFT JOIN messages ON users.id = messages.from AND is_read = 0 and messages.to =" . Auth::id() . "
            WHERE users.id != " . Auth::id()  . "
            GROUP BY users.id, users.name, users.avatar, users.email
            ");

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
