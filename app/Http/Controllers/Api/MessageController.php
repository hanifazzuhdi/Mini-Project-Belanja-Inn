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
        $my_id = Auth::id();

        $to   = DB::select("SELECT users.id, users.username, users.avatar FROM users
                            JOIN messages ON users.id = messages.from
                            WHERE users.id != $my_id AND users.role_id != 3 AND messages.to = $my_id
                            ");

        $from = DB::select("SELECT DISTINCT users.id, users.username, users.avatar FROM users
                            JOIN messages ON users.id = messages.to
                            WHERE users.id != $my_id AND users.role_id != 3 AND messages.from = $my_id
                            ");

        $data = array_merge($to, $from);

        $_data = array();

        foreach ($data as $v) {
            if (isset($_data[$v->id])) {
                // found duplicate
                continue;
            }
            // remember unique item
            $_data[$v->id] = $v;
        }
        // if you need a zero-based array, otheriwse work with $_data
        $res = array_values($_data);

        return response([
            'status' => 'success',
            'message' => 'Data loaded',
            'data' => $res
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
