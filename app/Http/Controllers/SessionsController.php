<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    //
    /**
     * SessionsController constructor.
     * 只让未登录的页面访问登录页面
     */
    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 登录页面
     */
    public function create()
    {
        return view('sessions.create');
    }
    //

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * 登录逻辑
     */
    public function store(Request $request)
    {
      $credentials = $this->validate($request,[
        'email' => 'required|email|max:255',
          'password' => 'required'
      ]);
      if (Auth::attempt($credentials,$request->has('remember')))
      {
          if(Auth::user()->activated) {
              session()->flash('success', '欢迎回来');
              $fallback = redirect()->route('users.show', [Auth::user()]);
              //重定向器上的 intended 方法将用户重定向到登录之前用户想要访问的 URL，在目标 URL 无效的情况下回退 URI 将会传递给该方法。
              return redirect()->intended($fallback);
          }else{
              Auth::logout();
              session()->flash('warning','你的账号未激活，请检查邮箱中的注册邮件进行激活。');
              return redirect('/');
          }
      }else {
          session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
          return redirect()->back()->withInput();
      }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 退出登录
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出');
        return redirect('login');
    }

}
