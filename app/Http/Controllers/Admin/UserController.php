<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        //lazy loading
        $users=User::all();
        return view('user.index',compact('users'));
    }


    public function create()
    {
        return view('user.create');

    }


    public function store(UserStoreRequest $request)
    {
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'password'=>Hash::make($request->password),
        ]);
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        //
    }


    public function edit(User $user)
    {
        return view('user.edit',compact('user'));
    }


    public function update(UserUpdateRequest $request, User $user)
    {
        $request=$request->except('password','password_confirmation','_token');
        if(!empty($request->password))
        {
            $request->merge(['password'=>Hash::make($request->password)]);
        }
        $user->update($request);
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');

    }
}
