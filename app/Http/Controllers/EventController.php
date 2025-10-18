<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function addevent(Request $request)
    {
        return view('addevent', [
            'user' => $request->user(),
        ]);
    }


    public function eventlist(Request $request)
    {
        $events = Event::where('user_id', Auth::user()->id)->get();

        // return view('addevent', [
        //     'user' => $request->user(),
        // ]);

        return view('eventlist', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function eventadd(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'order_name' => 'required|string|max:255',
            'event_host' => 'required|string|max:255',
            'event_type' => 'required|string|max:255',
            'event_date' => 'required|date',
            'arrival_time' => 'required',
            'reminder_date' => 'nullable|date',
            'timezone' => 'nullable|string|max:100',
            'event_location' => 'nullable|string|max:255',
            'event_desc' => 'nullable|string',
            'guest_limit' => 'nullable|integer|min:1',
        ]);

        $validated['user_id'] = Auth::user()->id;
        $validated['slug'] = "event1";

        $event = Event::create($validated);

        return redirect()
            ->route('user.addevent')
            ->with([
                'status' => 'success',
                'message' => 'Event created successfully.',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
