<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\Slider;
use App\SliderFacts;
use App\CategorySlider;
use App\Course;
use App\Meeting;
use App\BBL;
use App\BundleCourse;
use App\Testimonial;
use App\Trusted;
use App\Order;
use Auth;
use Session;
use App\Blog;
use App\Batch;
use Illuminate\Support\Facades\Schema;
use App\Setting;
use App\Advertisement;
use App\Dropdown;
use App\Googlemeet;
use App\JitsiMeeting;
use App\User;
use App\Page;
use Illuminate\Support\Facades\Cookie;
use Response;
use Config;
use App\Facts;
use DB;
use App\Institute;
use Module;
use App\Videosetting;
use Modules\Googleclassroom\Models\Googleclassroom;
use Newsletter;
use Redirect;
use App\Menu;
use App\FeatureCourse;
use App\GetStarted;
use Modules\Resume\Models\Jobsetting;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware(['auth','verified']);
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $category = Categories::where('status', '1')->orderBy('position','ASC')->with('subcategory')->get();
        $sliders = Slider::where('status', '1')->orderBy('position', 'ASC')->get();
        $facts = SliderFacts::limit(3)->get();
        $instructors = User::select('*')->where('role', 'instructor')->where('status', '1')->get();
         $instruct = FeatureCourse::get();
        $discountcourse = Course::where('type','1')->where('status',1)->where('featured',1)->whereNotNUll('discount_price')->with('user')->latest()->take(10)->get();
        $categorie_ids = CategorySlider::first();
        $factsetting = Facts::limit(4)->where('status', '1')->get();
        $videosetting = Videosetting::first();
        $bestselling = Order::whereNotNUll('course_id')->with('courses.user')->whereHas('courses',function($q){
                    $q->where('status', '=', "1");
        })->latest()->groupBy('course_id')->take(10)->get();
  
        if(isset($categorie_ids))
        {
            $categories = Categories::whereHas('courses')
                            ->whereIn('id',$categorie_ids->category_id)
                            ->where('status','1')
                            ->get();
        }
        else{
            $categories = NULL;
        }
        $meetings = Meeting::where('link_by', NULL)->whereHas('user')->with('user')->get();
        $bigblue = BBL::where('is_ended','!=',1)->where('link_by', NULL)->with('user')->get();
        $testi = Testimonial::where('status', '1')->get();
        $trusted = Trusted::where('status', '1')->get();
        $blogs = Blog::where('status', '1')->where('approved', 1)->orderBy('updated_at','DESC')->with('user')->get();
        $institute = Institute::where('status','1')->where('verified','1')->orderBy('updated_at','DESC')->get();
        if(Schema::hasTable('googlemeets')){
            $allgooglemeet = Googlemeet::orderBy('id', 'DESC')->where('link_by', NULL)->with('user')->with('user')->get();
        } else {
            $allgooglemeet = NULL;
        }
        if(Schema::hasTable('jitsimeetings')) {
            $jitsimeeting = JitsiMeeting::orderBy('id', 'DESC')->where('link_by', NULL)->with('user')->with('user')->get();
        } else{
            $jitsimeeting = NULL;
        }
        if (Schema::hasColumn('bundle_courses', 'is_subscription_enabled')) {
            $bundles = BundleCourse::where('is_subscription_enabled', 0)->where('status','1')->with('user')->latest()->take(10)->get();
            $subscriptionBundles = BundleCourse::where('is_subscription_enabled', 1)->where('status','1')->with('user')->latest()->take(10)->get();
        }  else{
            $bundles = NULL;
            $subscriptionBundles = NULL;
        }
    
        if(Schema::hasTable('batch')){
            $batches = Batch::where('status', '1')->get();
        }  else{
            $batches = NULL;
        }

        if(Schema::hasTable('advertisements')){
            $advs = Advertisement::where('status','=',1)->get();
        } else{
            $advs = NULL;
        }
        $viewed = session()->get('courses.recently_viewed');

        if (isset($viewed)) {
            $recent_course_id = array_unique($viewed); 
            $recent_coursecnt = Course::whereIn('id', $recent_course_id)->where('status','1')->get()->count();
        } else{
            $recent_course_id = NULL;
            $recent_coursecnt = 0;
        }

        if(Schema::hasTable('googleclassrooms') && Module::has('Googleclassroom') && Module::find('Googleclassroom')->isEnabled()) {
            $googleclassrooms = Googleclassroom::orderBy('id', 'DESC')->where('link_by', NULL)->where('status', '1')->get();
        } else{
            $googleclassrooms = NULL;
        }

        $counter = 0;$recent_course = NULL;
        if($recent_course_id != NULL) {
            $recent_course_id = array_splice($recent_course_id, 0);
        } else {
            $recent_course_id = NULL;
        }

        if(Auth::check())   {
            if( isset($recent_course_id) ) {
                $recent_course = Course::whereIn('id', $recent_course_id)->where('status', '1')->count();
            }
        }
        $total_count=$recent_course;
        $ipaddress = $request->getClientIp();
        $geoip = geoip()->getLocation($ipaddress);
        $usercountry = strtoupper($geoip->country);
        $cors = Course::where('status', '1')->where('featured', '1')->with('user')->latest()->take(10)->get()->map(function($c) use($usercountry) {
                    
                    if($c->country != ''){
                        if(!in_array($usercountry,$c->country)){
                            return $c;
                        }
                    }else{
                        return $c;
                    }
                
        })->filter();
        $ipaddress = $request->getClientIp();
        $geoip = geoip()->getLocation($ipaddress);
        $usercountry = strtoupper($geoip->country);

        $r_course = Course::where('status', '1')->with('user')->latest()->take(4)->get()->map(function($c) use($usercountry) {
                    if ($c->country != '') {
                        if (in_array($usercountry,$c->country)) {
                            return $c;
                        }
                     } else {
                        return $c;
                    }
                  })->filter();

        $r_course_count = Course::where('status', '1')->with('user')->latest()->where('created_at', '>', now()->subDays(15)->endOfDay())->get()->map(function($c) use($usercountry) {
                    if ($c->country != '') {
                        if (in_array($usercountry,$c->country)) {
                            return $c;
                        }
                     } else {
                        return $c;
                    }
                  })->filter();
        $get_enable = GetStarted::first();
        $menus = Menu::get();
        $pages = Page::get();
        //$jobsearch = Jobsetting::first();
        // $user = \Auth::user(); 
        // $roles = $user->getRoleNames();
        // $test_id = Role::select('id')->where('name',$roles[0])->get();
        // $dropdown = Dropdown::where('role_id', $test_id[0]['id'])->get();
        // echo "<pre>";print_r($enroll);exit();
        return view('home', compact('category', 'sliders', 'facts', 'categories', 'cors', 'bundles', 'meetings', 'bigblue', 'testi', 'trusted', 'recent_course_id', 'blogs', 'subscriptionBundles', 'batches', 'recent_course', 'total_count', 'advs', 'allgooglemeet','jitsimeeting', 'googleclassrooms', 'usercountry','instructors','factsetting','videosetting','discountcourse','bestselling','menus','pages','instruct','institute','get_enable','r_course','r_course_count','recent_coursecnt'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'subscribed_email' => 'required|email'
        ]);
        try{
            if(Newsletter::isSubscribed($request->subscribed_email))
            return Redirect::back()->withErrors(['msg' => 'Email already subscribed']);
            else{
            Newsletter::subscribe($request->subscribed_email);
            return Redirect::back()->withErrors(['msg' => 'Email subscribed']);

    }
        }
        catch (\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());

        }
    }
    public function instituteslug(Request $request, $id){
        $course = Course::where('institude_id',$id)->get();
        $institute = Institute::where('id',$id)->first();
        return view('front.institute.slug',compact('institute','course'));
    }
}
