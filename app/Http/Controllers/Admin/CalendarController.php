<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\User;
use App\Models\Hospital;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all(); // veya rolüne göre filtrele
        return view('calendar.index', compact('users'));
    }

    public function getEvents(Request $request)
    {
        $query = Calendar::query();
        
        if ($request->has('start') && $request->has('end')) {
            $query->whereBetween('start', [$request->start, $request->end]);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        } else {
            $query->where('user_id', auth()->user()->id);
        }

        $events = $query->with('user')->get();

        return response()->json($events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start,
                'end' => $event->end,
                'user_id' => $event->user_id,
                'allDay' => false
            ];
        }));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'user_id' => 'required|exists:users,id',
            'data' => 'nullable|json'
        ]);

        $event = Calendar::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => __('Event created successfully'),
            'event' => $event
        ]);
    }

    public function update(Request $request, Calendar $calendar)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'start' => 'sometimes|required|date',
            'end' => 'sometimes|required|date|after_or_equal:start',
            'user_id' => 'sometimes|required|exists:users,id',
            'data' => 'nullable|json'
        ]);

        $calendar->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => __('Event updated successfully'),
            'event' => $calendar
        ]);
    }

    public function destroy(Calendar $calendar)
    {
        $calendar->delete();

        return response()->json([
            'status' => 'success',
            'message' => __('Event deleted successfully')
        ]);
    }
} 