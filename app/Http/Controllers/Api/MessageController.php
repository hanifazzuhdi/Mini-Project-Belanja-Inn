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
    // public function index()
    // {
    //     // $data = DB::table('users')
    //     //     ->join('messages', function ($join) {
    //     //         $join->on('users.id', '=', 'messages.from')->orOn('users.id', '=', 'messages.to')
    //     //             ->where('messages.from', Auth::id());
    //     //     })
    //     //     ->where('users.id', '!=', Auth::id())
    //     //     ->where('users.role_id', '!=', 3)
    //     //     ->whereExists(function ($query) {
    //     //         $query->select(DB::raw(1))
    //     //             ->from('messages')
    //     //             ->where('from', Auth::id())
    //     //             ->Where('to', Auth::id());
    //     //     })
    //     //     ->select('users.id', 'users.username', 'users.avatar')
    //     //     ->distinct()->get();

    //     // $data = DB::table('users')
    //     //     ->where('users.id', '!=', Auth::id())
    //     //     ->join('messages', function ($join) {
    //     //         $join->on('users.id', '=', 'messages.from')->orOn('users.id', '=', 'messages.to')
    //     //             ->where('messages.from', Auth::id());
    //     //     })
    //     //     ->select('users.username', 'messages.to', 'messages.message')
    //     //     ->distinct()->get()->toArray();

    //     // AMBIL USER YANG PERNAH CHAT DENGAN KITA ATAU KITA CHAT KE DIA
    //     // $datas = Message::whereHas('user', function ($query) {
    //     //     $query->where('messages.from', Auth::id())->orWhere('to', Auth::id());
    //     // })->get();

    //     // foreach ($datas as $data) {
    //     //     # code...
    //     //     $users[] = User::where('id', '!=', $data->from)->orWhere('id', '!=', $data->to)->get();
    //     // }

    //     // select * from users where id != from and to != from
    //     $datas = User::where('id', '!=', Auth::id())->where('role_id', '!=', 3)->get();

    //     if ($datas == null) {
    //         return response([
    //             'status' => "gagal"
    //         ]);
    //     }

    //     return response([
    //         'users' => $datas
    //     ]);
    // }

    public function index()
    {
        // hitung berapa banyak pesan yang belum dibaca oleh user
        $users = DB::select("SELECT users.id, users.name, users.avatar, users.username, count(is_read) as unread
            FROM users LEFT JOIN messages ON users.id = messages.from AND is_read = 0 and messages.to = " . Auth::id() . "
            WHERE users.id != " . Auth::id()  . " and users.role_id != 3
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

        $user = User::find($user_id);

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
