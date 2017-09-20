<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * RoomController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function create()
    {
        return view('add');
    }

    public function add(Request $request)
    {
        dd($request);
    }

    public function lists()
    {
        return view('lists');
    }
}
