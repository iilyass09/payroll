<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingRequest;
use Illuminate\Http\Request;

class MeetingApiController extends Controller
{
    public function meetings(Request $request)
    {
        $query = Meeting::with('creator');

        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->month && $request->year) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }

        $recurring = Meeting::whereNotNull('recurring_type')->get();
        $nonRecurring = $query->get();

        return response()->json([
            'recurring' => $recurring,
            'meetings' => $nonRecurring,
        ]);
    }

    public function meetingRequests(Request $request)
    {
        $query = MeetingRequest::with(['employee', 'approver']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        $requests = $query->latest()->get();

        return response()->json($requests);
    }

    public function storeMeetingRequest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'room' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'why' => 'nullable|string',
            'what' => 'nullable|string',
            'how' => 'nullable|string',
        ]);

        $validated['employee_id'] = auth()->id();
        $meetingRequest = MeetingRequest::create($validated);

        return response()->json($meetingRequest->load('employee'), 201);
    }

    public function updateMeetingRequest(Request $request, MeetingRequest $meetingRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak',
            'notes' => 'nullable|string',
        ]);

        $validated['approved_by'] = auth()->id();
        $meetingRequest->update($validated);

        return response()->json($meetingRequest->load(['employee', 'approver']));
    }
}
