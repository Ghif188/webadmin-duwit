<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Otp;
use Carbon\Carbon;

class OtpController extends Controller
{
     var $LENGPHONE = 13; 
     
     public function otpSend($phone)
     {
          $message = "OTP berhasil dikirim";
          $validatePhone = $this->validateOtp($phone);
          
          if($validatePhone['status'] == false){
               $message = $validatePhone['message'];
          }
          $this->otpDeleted($phone);

          $otp = $this->otpCreated($phone);
          
          $phone = $otp->phone;

          Log::info('Kode = '.$otp->code);
          // dd($otp->code);
          $this->sendProvider($phone, $otp->code); 
     
          return [
               'status' => $validatePhone['status'],
               'message' => $message
          ];
          
          // return redirect(route('otp.page', $phone))->with(['success' => 'OTP telah dikirim']);
     }

     public function validateOtp($phone){
          $status = true;
          $message = '';
          if($phone == null){
               $status = false;
               $message = 'Nomor tidak boleh kosong';
               if( $phone.length > $LENGPHONE){
                    $message = 'Nomor tidak boleh lebih dari '+$LENGPHONE+' Karakter';
               }
          }
          return [
               'status' => true,
               'message' => $message
          ];
     }

     public function sendProvider( $target, $code ){
          $curl = curl_init();
          $data = [
               'target' => strval($target),
               'message' => 'Halo, Berikut adalah OTP Anda untuk mengakses layanan kami: '.$code. '. Kode OTP ini akan berlaku selama 10 menit. Jangan berikan OTP ini kepada siapapun, termasuk pihak layanan pelanggan kami. Kami tidak akan pernah meminta Anda untuk memberikan OTP ini. Terima kasih, DUWIT (CINURAWA) '
          ];
          curl_setopt(
               $curl,
               CURLOPT_HTTPHEADER,
               array(
                    "Authorization:".env("FONNTE_TOKEN","token"),
               )
          );
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
          curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
          $result = curl_exec($curl);
          curl_close($curl);
     }

     public function otpResend($phone )
     {
          $otp = Otp::where( 'phone', $phone )->first();

          $phone = $otp->phone;

          $generateOTP = $this->otpCodeGenerate();

          $otp->update([          
               'code' => $generateOTP['code'],
               'expired_at' => $generateOTP['expired_at'],
          ]);
          
          $this->sendProvider($phone, $otp->code); 
          
          return $otp;

          // return redirect(route('otp.page', $phone))->with(['success' => 'OTP telah dikirim ulang']);
     }

     protected function otpCreated($phone)
     {
          $generateOTP = $this->otpCodeGenerate();

          $otp = Otp::create([          
               'phone' => $phone,
               'code' => $generateOTP['code'],
               'expired_at' => $generateOTP['expired_at'],
          ]);
          
          Log::info('Otp telah dibuat.');
          
          return $otp;
     }

     protected function otpCodeGenerate()
     {
          $expiredDateTime = Carbon::now()->addMinutes(10)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
          // dd($expiredDateTime);
          // Generate code
          $code = rand(000000,999999);
          
          return [
               'expired_at' => $expiredDateTime,
               'code' => $code
          ];
     }

     public function otpVerification( Request $request )
     {
          $status = true;
          $message = "";
          $currentTime = Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
          
          $otp = Otp::where( 'phone', $request->phone )->first();
          $expired_at = $otp->expired_at;
          
          // dd($request->code, $otp->code); 
          if($currentTime > $expired_at){
               $status = false;
               $message = 'Kode OTP sudah kadaluarsa, silahkan kirim ulang';
               // return redirect()->back()->withInput(['error' => 'Code OTP sudah kadaluarsa, silahkan kirim ulang']);
          } elseif ($otp->code == $request->code){
               $message ='Verifikasi sukses';
               $this->otpDeleted($otp->phone);
               // return redirect()->back()->withInput(['error' => 'Code OTP tidak sesuai']);
          } else {
               $status = false;
               $message = 'Kode OTP tidak sesuai';
          }  
          // dd($message);
     
          return [
               'status' => $status,
               'message' => $message
          ];
     }

     protected function otpDeleted( $phone )
     {
          $otp = Otp::where( 'phone', $phone )->delete();

          Log::info('Otp telah dihapus.');
          
          return true;
     }

}
