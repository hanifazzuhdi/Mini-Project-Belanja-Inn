<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $active = DB::select("SELECT COUNT(id) as active FROM users WHERE role_id != 3");
        $shop = DB::select("SELECT COUNT(id) as shop FROM users WHERE role_id = 2 ");

        return view('pages.dashboard', compact('active', 'shop'));
    }

    public function getUser()
    {
        $datas = User::where('role_id', '!=', 3)->orderBy('id')->get()->toArray();

        return view('pages.daftarUser', compact('datas'));
    }
}
