<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Models\Admin\Event;
use App\Models\Admin\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        $teams = Team::join('events', 'events.id', 'teams.event_id')
            ->select('teams.*', 'events.event_name')
            ->where('teams.event_id', $events->first()->id)
            ->orderBy('teams.created_at', 'desc')
            ->get();


        return view('admin.teams.team_list', compact('teams', 'events'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $events = Event::all();
        $teams = Team::join('events', 'events.id', 'teams.event_id')
            ->select('teams.*', 'events.event_name')
            ->where('teams.event_id', $request->event_id)
            ->orderBy('teams.created_at', 'desc')
            ->get();


        return view('admin.teams.team_list', compact('teams', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = Event::latest()->pluck('event_name', 'id');
        return view('admin.teams.add_team', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        if ($request->hasFile('team_img')) {
            //getting the image name
            $image_full_name = $request->team_img->getClientOriginalName();
            $image_name_arr = explode('.', $image_full_name);
            $image_name = $image_name_arr[0] . time() . '.' . $image_name_arr[1];

            //storing image at public/storage/products/$image_name
            $request->team_img->storeAs('teams', $image_name, 'public');
        } else {
            $image_name = 'placeholder.jpg';
        }

        $team = Team::create([
            'team_name' => $request->team_name,
            'event_id' => $request->event_id,
            'team_img' => $image_name
        ]);

        //setting up success message
        if ($team) {
            $notification = array(
                'message' => 'Team added successfully!',
                'alert-type' => 'success'
            );
        }
        //setting up error message
        else {
            $notification = array(
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            );
        }

        return redirect()->route('teams.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::find($id);
        $events = Event::latest()->pluck('event_name', 'id');
        return view('admin.teams.edit_team', compact('events', 'team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, $id)
    {
        $team = Team::find($id);
        // dd($request->all());
        if ($request->hasFile('team_img')) {

            //deleting the previous Image
            Storage::disk('public')->delete('teams/' . $team->team_img);
            //getting the image name
            $image_full_name = $request->team_img->getClientOriginalName();
            $image_name_arr = explode('.', $image_full_name);
            $image_name = $image_name_arr[0] . time() . '.' . $image_name_arr[1];

            //storing image at public/storage/products/$image_name
            $request->team_img->storeAs('teams', $image_name, 'public');
        } else {
            $image_name = $team->team_img;
        }


        $team->update([
            'team_name' => $request->team_name,
            'event_id' => $request->event_id,
            'team_img' => $image_name
        ]);

        //setting up success message
        if ($team) {
            $notification = array(
                'message' => 'Team updated successfully!',
                'alert-type' => 'success'
            );
        }
        //setting up error message
        else {
            $notification = array(
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            );
        }

        return redirect()->route('teams.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::find($id);

        //deleting the image from the storage
        Storage::disk('public')->delete('teams/' . $team->team_img);

        if ($team->delete()) {
            //setting up success message
            $notification = array(
                'message' => 'Team Deleted',
                'alert-type' => 'success'
            );
        } else {
            //setting up error message
            $notification = array(
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            );
        }

        //redirecting to the page with notification message
        return redirect()->route('teams.index')->with($notification);
    }

    public function get_driver(Request $request)
    {
        $driver = DB::table('teams')->where('team_name', $request->driver_name)->orderBy('team_name', 'asc')->pluck('team_name')->first();

        return $driver;
    }
}
