<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CobaController extends Controller
{
    public function index()
    {
        return "oke berhasil masuk Login sebagai user id : " . Auth::id();
    }
}
