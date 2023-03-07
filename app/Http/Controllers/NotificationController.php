<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notification\CreateContactUsRequest;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function contactUs(CreateContactUsRequest $request){
        return $request->all();
    }
}
