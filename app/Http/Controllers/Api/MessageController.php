<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Pusher\Pusher;

class MessageController extends Controller
{
    public function index()
    {
        // Pilih user yang sudah pernah chat
        $user = User::where('id', '!=', Auth::id())->whereHas('message', function ($query) {
            $query->where('from', Auth::id());
        })->get();

        return $user;

        die;

        // pilih semua user yang sedang di chat

        $users = User::where('id', '!=', Auth::id())->get();

        // hitung berapa banyak pesan yang belum dibaca oleh user
        $users = DB::select("SELECT users.id, users.name, users.avatar, users.email, count(is_read) as unread
            FROM users LEFT JOIN messages ON users.id = messages.from AND is_read = 0 and messages.to =" . Auth::id() . "
            WHERE users.id != " . Auth::id()  . "
            GROUP BY users.id, users.name, users.avatar, users.email
            ");

        return view('home', compact('users'));
    }

    // public function getMessage($user_id)
    // {
    //     $my_id = Auth::id();

    //     // when click to see message selected message will be read, update
    //     Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

    //     $messages = Message::where(function ($query) use ($user_id, $my_id) {
    //         $query->where('from', $my_id)->Where('to', $user_id);
    //     })->orWhere(function ($query) use ($user_id, $my_id) {
    //         $query->where('from', $user_id)->Where('to', $my_id);
    //     })->get();

    //     return view('messages.index', compact('messages'));
    // }

    // public function sendMessage(Request $request)
    // {
    //     $from = Auth::id();
    //     $to = $request->receiver_id;
    //     $message = $request->message;

    //     $data = new Message();
    //     $data->from = $from;
    //     $data->to = $to;
    //     $data->message = $request->message;
    //     $data->is_read = 0;
    //     $data->save();

    //     $options = [
    //         'cluster' => 'ap1',
    //         'useTLS' => true
    //     ];

    //     $pusher = new Pusher(
    //         '8d28dfe973d0377c124b',
    //         'a91a7e8d600915953718',
    //         '1111413',
    //         $options
    //     );

    //     $data = ["from" => $from, "to" => $to];
    //     $pusher->trigger('my-channel', 'my-event', $data);
    // }
}
