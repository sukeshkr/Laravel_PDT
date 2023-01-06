<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Password as ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }
    public function postLogin(Request $request)
    {
        $validator = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        if(Auth::attempt($validator,$request->remember)){

            $request->session()->regenerate();
            Auth::user();
            return redirect()->intended('select-branch');
        }
        else{
            return redirect()->back()->with('error','The provided credentials do not match our records.');
        }
    }

    public function register()
    {
        return view('user.register');
    }

    public function postRegister(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => ['required','confirmed',Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()],
            'terms'=>'required',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        if($user) {
            Auth::login($user);
            event(new Registered($user));
            return redirect()->route('verification.notice')->with('message','Verification link sent!');
        }
        else{
            redirect()->route('post.register')->with('error','Something went wrong on your Registration');
        }
    }
    public function verificationNotification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message','Verification link sent!');
    }
    public function forgot()
    {
        return view('user.forgot');
    }
    public function postForgot(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=> 'required|email'
        ]);
        if($validator->fails()) {
            return redirect('forgot')->withErrors($validator, 'forgot');
        }
        //$validated = $validator->validated();

        $status = ResetPassword::sendResetLink(
            $request->only('email')
        );

        return $status == ResetPassword::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);

    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = ResetPassword::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return $status === ResetPassword::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);

    }


}
