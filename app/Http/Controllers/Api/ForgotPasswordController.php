<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use Validator;
use Illuminate\Validation\Rule;
use JWTFactory;
use JWTAuth;
use Response;
use Mail;
use Str;
use Arr;

class ForgotPasswordController extends Controller
{
  public function sendrecovery(Request $request)
    {
      $user = User::where('email', $request->get('email'))->first();

      if(!is_null($user)){
        $name = $user->firstname;
        $email = $user->email;
        $recovery_code = Str::random(32);
        $user->recovery_code = $recovery_code;
        $user->recovery_expiry = now()->addMinutes(15);
        $user->save();

        $subject = "Password Recovery";

        Mail::send('mail.recover', ['name' => $name, 'recovery_code' => $user->recovery_code],
          function($mail) use ($email, $name, $subject,$company){
              $mail->from($company->email, $company->name);
              $mail->to($email, $name);
              $mail->subject($subject);
          });

        return Response::json(compact('user'));
      } else {
       return response()->json(['error' => 'User not found'], 401);
      }
    }

    public function recover($recovery_code){
      $user = User::where('recovery_code', $recovery_code)->first();
      if($user &&  $user->recovery_expiry->isFuture()){
       return Response::json(compact('user'));
      } else {
        $user= 'expired';
        return Response::json(compact('user'),401);
      }
      
    }


    public function changepassword(Request $request){
      $user = User::where('recovery_code', $request->recovery_code)->first();
      if($user){
        $user->password = bcrypt($request->password);
        $user->recovery_code = null;
        $user->recovery_expiry = null;
        $user->save();
        return Response::json(compact('user'),200);
        
      } else {
        $user= 'Invalid Recovery code';
        return Response::json(compact('user'),401);
      }
      
      
    }


}