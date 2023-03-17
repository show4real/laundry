<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class SendMailController extends Controller
{
    public function send(Request $request){
        $subject= 'Hello world';
        $email= "show4ril@gmail.com";
        $name= "Hamzeal Digital";

         Mail::send('mail.recover', ['name' => $name, 'recovery_code' => 'xyzerytu'],
          function($mail) use ($email, $name, $subject){
              $mail->from('ade@hayzeeonline.com', $name);
              $mail->to($email, $name);
              $mail->subject($subject);
          });

    }
    
}
