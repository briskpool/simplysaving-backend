<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Models\Admin\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.events.event_list', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.events.add_event');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventStoreRequest $request)
    {

        if ($request->hasFile('event_img')) {
            //getting the image name
            $image_full_name = $request->event_img->getClientOriginalName();
            $image_name_arr = explode('.', $image_full_name);
            $image_name = $image_name_arr[0] . time() . '.' . $image_name_arr[1];

            //storing image at public/storage/products/$image_name
            $request->event_img->storeAs('events', $image_name, 'public');
        } else {
            $image_name = 'placeholder.jpg';
        }

        $event = Event::create([
            'event_name' => $request->event_name,
            'event_img' => $image_name
        ]);

        //setting up success message
        if ($event) {
            $notification = array(
                'message' => 'Event added successfully!',
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

        return redirect()->route('events.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event_teams = Event::join('teams', 'teams.event_id', 'events.id')
            ->where('events.id', $id)
            ->orderBy('teams.id', 'desc')
            ->select('events.event_name', 'teams.*')
            ->get();

        return view('admin.events.event_teams', compact('event_teams'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        return view('admin.events.edit_event', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventStoreRequest $request, $id)
    {
        $event = Event::find($id);
        if ($request->hasFile('event_img')) {

            //deleting the previous Image
            Storage::disk('public')->delete('events/' . $event->event_img);
            //getting the image name
            $image_full_name = $request->event_img->getClientOriginalName();
            $image_name_arr = explode('.', $image_full_name);
            $image_name = $image_name_arr[0] . time() . '.' . $image_name_arr[1];

            //storing image at public/storage/products/$image_name
            $request->event_img->storeAs('events', $image_name, 'public');
        } else {
            $image_name = $event->event_img;
        }
        // dd($event->event_img);


        $event->update([
            'event_name' => $request->event_name,
            'event_img' => $image_name
        ]);

        //setting up success message
        if ($event) {
            $notification = array(
                'message' => 'Event updated successfully!',
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

        return redirect()->route('events.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        //deleting the image from the storage
        Storage::disk('public')->delete('events/' . $event->event_img);

        if ($event->delete()) {
            //setting up success message
            $notification = array(
                'message' => 'Event Deleted',
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
        return redirect()->route('events.index')->with($notification);
    }
}
