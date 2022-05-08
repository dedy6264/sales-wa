<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use DB;

class UserController extends Controller
{
    public function all(Request $request)
    {
        abort_if(!$request->header('X-XSRF-TOKEN'), 404);
        return User::get();
    }

    public function index()
    {
        return view('contents.user.index');
    }
    
    public function store(UserRequest $request)
    {
        User::create($request->validated());
        return true;
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return true;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return true;
    }
}
