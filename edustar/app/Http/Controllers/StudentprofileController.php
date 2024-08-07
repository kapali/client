<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
use Auth;
use App\Course;

class StudentprofileController extends Controller
{
    public function index(){
        if (Auth::check()) {
        $users = User::where('id',Auth::user()->id)->where('status', '1')->first();
        $enroll = Order::where('refunded', '0')->where('status', '1')->where('user_id', Auth::user()->id)->get();
        $course = Course::all();
        return view('front.student.profile',compact('users','enroll','course'));
    }
    else{
        return redirect('login');
    }
}
}
