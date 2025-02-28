<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
      $data[] = '';
      return view('chat.index', $data);
    }
}
