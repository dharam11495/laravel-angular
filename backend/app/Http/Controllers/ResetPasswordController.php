<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ResetPasswordController extends Controller
{
    public function sendEmail(Request $request)
    {
       if(!$this->validateEmail($request->email)){
        return $this->failedResponse();
       }

       $this->send($request->email);
       return $this->successResponse();
    }


    public function send($email)
    {
        Mail::to($email)->send(new ResetPasswordMail);
    }

    public function validateEmail($email)
    {
        return !!User::where('email', $email)->first();
    }

    public function failedResponse()
    {
        return response()->json([
            'error' => 'Email dont Found on Our database'
        ], Response::HTTP_NOT_FOUND);
    }

    public function successResponse()
    {
        return response()->json([
            'error' => 'rESET EMAIL SEND'
        ], Response::HTTP_OK);
    }
}
