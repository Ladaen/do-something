<?php

namespace App\Http\Controllers;

use App\Models\SavedActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // fetching data from the api with 5 random breeds
        $NewActivities = array();
        for($x = 0; $x < 5; $x++) {
            array_push($NewActivities,Http::get('https://www.boredapi.com/api/activity/'));
        }
        $MyActivities = SavedActivity::where('user', Auth::user()->email)
                                        ->where('status', 'unfinisshed')
                                        ->latest()
                                        ->limit(10)
                                        ->get();
        $SavedActivities = array();
        foreach ($MyActivities as $MyActivity) {
            // Create an associative array
            $SavedActivity = array(
                "Activity"=>Http::get('https://www.boredapi.com/api/activity?key='. $MyActivity->activity_id), 
                "id"=>$MyActivity->id  
            );

            // Use typecast to convert
            // array into object
            $obj = (object) $SavedActivity;
            array_push($SavedActivities,$obj);
        }
                
        return view('Home',compact('NewActivities','SavedActivities'));
    }
    public function feeds()
    {
        // fetching data from the api with 5 random breeds
        $DoneActivites = SavedActivity::join('users', 'users.email', '=', 'saved_activities.user')
                        ->where('saved_activities.status', 'Done')
                        ->select('saved_activities.activity_id','users.name','saved_activities.updated_at','saved_activities.comment')
                        ->orderBy('saved_activities.updated_at','DESC')
                        ->limit(10)
                        ->get();
    
        $FeedPosts = array();
        foreach ($DoneActivites as $DoneActivity) {
            // Create an associative array
            $FeedPost = array(
                "Activity"=>Http::get('https://www.boredapi.com/api/activity?key='. $DoneActivity->activity_id), 
                "username"=>$DoneActivity->name,
                "doneby"=>date('d M Y H:i', strtotime($DoneActivity->updated_at)),
                "comment"=>$DoneActivity->comment
            );
            // Use typecast to convert
            // array into object
            $obj = (object) $FeedPost;
            array_push($FeedPosts,$obj);
        }
        $MyActivities = SavedActivity::where('user', Auth::user()->email)
                                        ->where('status', 'unfinisshed')
                                        ->latest()
                                        ->limit(10)
                                        ->get();
        $SavedActivities = array();
        foreach ($MyActivities as $MyActivity) {
            // Create an associative array
            $SavedActivity = array(
                "Activity"=>Http::get('https://www.boredapi.com/api/activity?key='. $MyActivity->activity_id), 
                "id"=>$MyActivity->id  
            );

            // Use typecast to convert
            // array into object
            $obj = (object) $SavedActivity;
            array_push($SavedActivities,$obj);
        }
        $title = '| Feeds';
        return view('feeds',compact('title','FeedPosts','SavedActivities'));
    }
}
