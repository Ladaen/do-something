<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HomeController;
use App\Models\SavedActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->middleware('auth');
     }
 
    public function saveActivity(Request $request){
        $request['user'] = Auth::user()->name;
        $request['status'] = 'unfinisshed';
        $request->validate([
            'user' => 'required',
            'activity_id' => 'required',
        ]);

        SavedActivity::create($request->all());
     
        return redirect()->route('activity.index')
                        ->with('success','Activity successfully saved.');
    }

    public function index()
    {
        $Activities = SavedActivity::latest()->paginate(5);
    
        return view('activity.index',compact('Activities'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'activity_id' => 'required',
        ]);
        //check wether the record's already exists
        $count = SavedActivity::where([
                                        ['user', '=', $request['user']],
                                        ['activity_id', '=', $request['activity_id']]])
                                ->latest()
                                ->limit(10)
                                ->get()
                                ->count();

        if($count > 0){
            return redirect()->action([HomeController::class,'index'])
            ->with('error','Activity already saved.');            
        } else {
            SavedActivity::create($request->all());
        }     

        return redirect()->action([HomeController::class,'index'])
                        ->with('success','Activity successfully saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $SavedActivity = SavedActivity::find($id);
        return view('activity.show',compact('SavedActivity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $SavedActivity = SavedActivity::find($id);
        return view('activity.edit',compact('SavedActivity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, Request $request, SavedActivity $SavedActivity)
    {
        $SavedActivity = SavedActivity::find($id);

        $request->validate([
            'status' => 'required',
            'comment' => 'required',
        ]);
    
        $SavedActivity->update($request->all());
    
        return redirect()->route(HomeController::class,'index')
                        ->with('success','Activity successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $SavedActivity = SavedActivity::find($id);

        $SavedActivity->delete();
    
        return redirect()->action([HomeController::class,'index'])
                        ->with('success','Activity successfully deleted.');
    }
}
