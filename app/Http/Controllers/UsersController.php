<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    //
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success',"欢迎，您将在此开启一段新的旅程");
        return redirect()->route('users.show',[$user]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request)
    {
        $this->validate($request,[
            'name' => Rule::unique('users')->ignore($user->id),
            'password' => 'required|confirmed|min:6'
        ]);
        $user->update([
            'name'      =>  $request->name,
            'password'  =>  bcrypt($request->password)
        ]);
        session()->flash('success',"更新成功");
        return redirect()->route('users.show',$user->id);
    }


}
