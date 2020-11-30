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
        $to = DB::table('users')
            ->where('users.id', '!=', Auth::id())
            ->where('users.role_id', '!=', 3)
            ->where('messages.to', Auth::id())
            ->join('messages', 'messages.from', '=', 'users.id')
            // ->join('messages', 'messages.from', '=', 'users.id')
            ->select('users.id', 'users.username', 'users.avatar')
            ->distinct()->get()->toArray();

        $from = DB::table('users')
            ->where('users.id', '!=', Auth::id())
            ->where('users.role_id', '!=', 3)
            ->where('messages.to', '!=', Auth::id())
            ->where('messages.from', Auth::id())
            ->join('messages', 'messages.to', '=', 'users.id')
            ->select('users.id', 'users.username', 'users.avatar')
            ->distinct()->get()->toArray();

        $data = array_merge($to, $from);

        return response([
            'status' => 'success',
            'message' => 'Data loaded',
            'data' => $data
        ]);
    }

    public function getMessage($user_id)
    {
        $my_id = Auth::id();

        $user = DB::table('users')
            ->where('id', $user_id)
            ->select('users.id', 'users.username', 'users.avatar')
            ->get();

        // when click to see message selected message will be read, update
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->Where('to', $user_id);
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->Where('to', $my_id);
        })->orderBy('created_at', 'asc')->get();

        return response([
            'status' => 'success',
            'message' => 'Message loaded',
            'profil' => $user,
            'data' => $messages
        ]);
    }

    public function sendMessage(Request $request)
    {
        // Tidak boleh kirim pesan ke diri sendiri
        if ($request->to == Auth::id()) {
            return $this->SendResponse('failed', 'Tidak boleh kirim pesan ke diri sendiri', null, 404);
        }

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
