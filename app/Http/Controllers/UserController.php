<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users()
    {
        return view('admin.users', ['users' => User::all()]);
    }
}
