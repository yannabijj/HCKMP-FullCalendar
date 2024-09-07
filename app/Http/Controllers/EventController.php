<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $eventsArray = [];

        foreach ($events as $event) {
            $eventsArray[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'color' => $event->color,
                'status' => $event->status,
                'remarks' => $event->remarks,
            ];
        }

        return response()->json($eventsArray);
    }

    public function store(Request $request)
    {
        $event = Event::create($request->all());

        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->all());

        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['status' => 'Event deleted']);
    }
}
