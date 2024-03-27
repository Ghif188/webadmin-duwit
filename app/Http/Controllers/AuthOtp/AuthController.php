<?php

namespace App\Http\Controllers\AuthOtp;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\OtpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users (admin) for the webadmin application and
    | redirecting them to your dashboard screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    public function __construct( OtpController $OtpController )
    {
        $this->OtpController = $OtpController;
    }

    /**
     * Show the application's Phone login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show the application's OTP form.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendOtp(Request $request) 
    {
        $data = $this->validatePhone($request);
        if($data['status'] == false){
            return $this->sendFailedLoginResponse('phone',$data['message']);
        }
        // kirim otp pertama kali
        $phone = $data['phone'];
        // dd($phone);
        $this->OtpController->otpSend($phone);
        return redirect()->route('login.formOtp', ['phone' => $phone]);
    }

    public function showOtpForm($phone) 
    {
        $phone = $phone;
        return view('auth.otp', compact('phone'));
    }

    /**
     * Show the application's Login OTP form.
     *
     * @return \Illuminate\Http\Response
     */
    public function validatePhone(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|max:14',
        ], [
            'phone.required' => 'Nomor telepon tidak boleh kosong',
            'phone.max' => 'Nomor telepon maksimal 14 karakter'
        ]);
        $status = true;
        $message = 'Nomor telepon ditemukan';
        $phone = '62' . substr($request->phone, strpos($request->phone, "0") + 1);
        $user = User::where('phone', $phone )->first();
        if( $user == null){
            $status = false;
            $message = 'Nomor telepon tidak ditemukan';
        }
        // dd([$phone,$message]);
        return [
            'status' => $status,
            'phone' => $phone,
            'message' => $message,
        ];
    }

    public function resendOtp(Request $request)
    {
        $this->OtpController->otpResend($request->phone);
        $phone = $request->phone;
        $status = 'Kode OTP telah dikirim ulang!';
        return redirect()->route('login.formOtp', ['phone' => $phone])->with('status', 'Kode OTP telah dikirim ulang!');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $statuslogin = $this->attemptLogin($request);

        if ($statuslogin['status']) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse('code', $statuslogin['message']);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|max:14',
            'code' => 'required|string|max:6',
        ], [
            $this->username() .'.required' => 'Nomor telepon tidak boleh kosong',
            $this->username() .'.phone.max' => 'Nomor telepon maksimal 14 karakter',
            'code.required' => 'Kode OTP tidak boleh kosong',
            'code.max' => 'Kode OTP maksimal 6 karakter',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'phone';
    }
    

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse($key,$request)
    {
        throw ValidationException::withMessages([
            $key => [$request],
        ]);
    }
    

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();

        $request->session()->regenerate();

        // $this->clearLoginAttempts($request);

        $auth = Auth::login($user);

        return $this->authenticated($request, $user)
                ?: redirect()->intended($this->redirectPath());
    }


    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->OtpController->otpVerification($request);
    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('dashboard');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


}
