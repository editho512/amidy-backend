<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Notification\CreateContactUsRequest;

class NotificationController extends Controller
{

    public function contactUs(CreateContactUsRequest $request){


        Mail::to(env('MAIL_USERNAME'))->send(new SendMail($request->object, "contact_us.contact_us", (array) $request->all()));

        // thanks mail
        Mail::to('editho.alex512@gmail.com')->send(new SendMail($request->object, "contact_us.thanks", ["name" => $request->name]));

        return (array) $request->all();
    }
}
