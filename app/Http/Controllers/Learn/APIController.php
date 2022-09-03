<?php

namespace App\Http\Controllers\Learn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class APIController extends Controller
{
    public function users()
    {
        // $users = Http::get('https://jsonplaceholder.typicode.com/users')->json();

        // dd($users);

        // return view('learnapi.users', compact('users'));
        return view('learnapi.users');
    }
}
