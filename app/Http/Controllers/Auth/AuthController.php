<?php

namespace App\Http\Controllers\Auth;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
// use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Session;

class AuthController extends Controller
{


    // use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'getLogout']);
      
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
   


//login

       protected function getLogin()
    {
        return view("auth.login");
    }


       

    public function postLogin(Request $request)
   {
        $this->validate($request, [
            'usuario' => 'required',
            'password' => 'required',
        ]);



        $credentials = $request->only('usuario', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember')))
        {
            // Session::save();
            return redirect()->route('main');
        }

        return view("auth.login")->with("login","credenciales incorrectas");

    }


//login

 //registro   


    protected function getRegister()
    {
        return view("auth.registro");
    }


        

    protected function postRegister(Request $request)

   {
        $this->validate($request, [
            'usuario' => 'required',
            'password' => 'required',
        ]);


    $data = $request;


    $user=new User;
    $user->usuario=$data['usuario'];
    $user->password=bcrypt($data['password']);


    if($user->save()){

        return view("auth.login");
               
    }
   

}

//registro

protected function getLogout()
{
    $this->auth->logout();

    Session::flush();

    return redirect('login');
}






}
