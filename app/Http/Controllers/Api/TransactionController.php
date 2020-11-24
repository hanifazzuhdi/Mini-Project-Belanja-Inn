<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConfirmationResource;
use App\Http\Resources\HistoryResource;
use App\Http\Resources\ShopConfirmationResource;
use App\Http\Resources\SoldHistoryResource;

class TransactionController extends Controller
{
    // wait confirm for buyer
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
            'message' => 'Wait for sending',
            'data' => $res
        ]);
    }

    // confirmation seller
    public function confirmation()
    {
        $datas = Cart::where('shop_id', Auth::id())->where('status', 1)->get();

        if (count($datas) == 0) {
            return $this->SendResponse('success', 'Data Order not found', NULL, 404);
        }

        $res = ShopConfirmationResource::collection($datas);

        return response([
            'status' => 'success',
            'message' => 'Confirmation order',
            'data' => $res
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

        return $this->SendResponse('success', 'Order confirmed', $carts, 202);
    }

    // Status sending
    public function sending()
    {
        $orders = Cart::where('status', 2)->whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        if (count($orders) == 0) {
            return $this->SendResponse('Success', 'Data order not found', NULL, 404);               // <== Buyer
        }

        $res = HistoryResource::collection($orders);

        return response([
            'status' => 'success',
            'message' => 'Data orders sent',
            'data' => $res
        ], 200);
    }

    public function shopSending()
    {
        $res = Cart::where('status', 2)->where('shop_id', Auth::id())->get();

        if (count($res) == 0) {
            return $this->SendResponse('success', 'Data order not found', null, 404);           // <== Seller
        }

        $hasil = SoldHistoryResource::collection($res);

        return response([
            'status' => 'success',
            'message' => 'Data orders sent',
            'data' => $hasil
        ]);
    }

    public function confirmSent()
    {
        $datas = Cart::where('status', 2)->whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        foreach ($datas as $data) {
            $data->status = 3;
            $data->update();
        }

        return $this->SendResponse('success', 'order success', $datas, 200);
    }

    // history buyer
    public function history()
    {
        $orders = Cart::where('status', 3)->whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        if (count($orders) == 0) {
            return $this->SendResponse('Success', 'Data order not found', NULL, 404);
        }

        $res = HistoryResource::collection($orders);

        return response([
            'status' => 'success',
            'message' => 'History order user',
            'data' => $res
        ], 200);
    }

    // history seller
    public function soldHistory()
    {
        $res = Cart::where('status', 3)->where('shop_id', Auth::id())->get();

        if (count($res) == 0) {
            return $this->SendResponse('success', 'Data order not found', null, 404);
        }

        $hasil = SoldHistoryResource::collection($res);

        return response([
            'status' => 'success',
            'message' => 'Hisory order',
            'data' => $hasil
        ]);
    }
}
