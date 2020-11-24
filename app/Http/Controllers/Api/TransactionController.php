<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConfirmationResource;
use App\Http\Resources\HistoryResource;
use App\Http\Resources\ShopConfirmationResource;
use App\Http\Resources\SoldHistoryResource;

class TransactionController extends Controller
{
    public function waitConfirm()
    {
        $datas = Cart::where('status', 1)->whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        if (count($datas) == 0) {
            return $this->SendResponse('success', 'Data Order not found', NULL, 404);
        }

        $res = ConfirmationResource::collection($datas);

        return response([
            'status' => 'success',
            'message' => 'Data order loaded',
            'coba' => $res
        ]);
    }

    public function confirmation()
    {
        $datas = Cart::where('shop_id', Auth::id())->where('status', 1)->get();

        if (count($datas) == 0) {
            return $this->SendResponse('success', 'Data Order not found', NULL, 404);
        }

        $res = ShopConfirmationResource::collection($datas);

        return response([
            'status' => 'success',
            'message' => 'Data order loaded',
            'coba' => $res
        ]);
    }

    public function setConfirmation()
    {
        $carts = Cart::where('shop_id', Auth::id())->where('status', 1)->get();

        if (count($carts) == 0) {
            return $this->SendResponse('success', 'Data Order not found', NULL, 404);
        }

        foreach ($carts as $cart) {
            $cart->status = 2;
            $cart->update();
        }

        return "sukses";
    }

    public function history()
    {
        $orders = Cart::where('status', 2)->whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        if (count($orders) == 0) {
            return $this->SendResponse('Success', 'Data order not found', NULL, 404);
        }

        return response([
            'status' => 'success',
            'message' => 'History order user',
            'data' => $orders
        ], 200);
    }

    public function getHistory($id)
    {
        $orders = Cart::where('order_id', $id)->whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())->where('status', 1);
        })->get()->all();

        if (!$orders) {
            return $this->SendResponse('failed', "Data order id $id not found", null, 404);
        }

        $hasil = HistoryResource::collection($orders);

        return response([
            'status' => 'success',
            'message' => "Data order id $id",
            'data' => $hasil
        ], 200);
    }

    public function soldHistory()
    {
        $res = Cart::where('shop_id', Auth::id())->whereHas('order', function ($query) {
            $query->where('status', 1);
        })->get()->all();

        if (!$res) {
            return $this->SendResponse('failed', 'Data not found', null, 404);
        }

        $hasil = SoldHistoryResource::collection($res);

        return response([
            'status' => 'success',
            'message' => 'Hisory order',
            'data' => $hasil
        ]);
    }
}
