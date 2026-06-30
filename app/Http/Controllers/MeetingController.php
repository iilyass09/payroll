<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingRequest;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function jadwal(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;
        $view = $request->view ?? 'month';

        $meetings = Meeting::with('creator')
            ->where(function ($q) use ($month, $year) {
                $q->whereMonth('date', $month)->whereYear('date', $year);
            })
            ->orWhereNotNull('recurring_type')
            ->orderBy('start_time')
            ->get();

        $recurring = $meetings->whereNotNull('recurring_type');
        $nonRecurring = $meetings->whereNull('recurring_type');

        return view('meeting.jadwal', compact(
            'meetings', 'recurring', 'nonRecurring', 'month', 'year', 'view'
        ));
    }

    public function permintaan(Request $request)
    {
        $user = auth()->user();
        $employee = $user->employee;

        if ($user->isKaryawan()) {
            $requests = MeetingRequest::with('employee')
                ->where('employee_id', $employee?->id)
                ->latest()
                ->paginate(10);
        } else {
            $requests = MeetingRequest::with(['employee', 'approver'])
                ->when($request->status, function ($q, $status) {
                    $q->where('status', $status);
                })
                ->latest()
                ->paginate(10);
        }

        return view('meeting.permintaan', compact('requests'));
    }

    public function storePermintaan(Request $request)
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

        $employee = auth()->user()->employee;

        if (!$employee) {
            return back()->with('error', 'Akun Anda tidak terhubung ke data karyawan.');
        }

        MeetingRequest::create(array_merge($validated, [
            'employee_id' => $employee->id,
        ]));

        return redirect()->route('meeting.permintaan')->with('success', 'Permintaan meeting berhasil dikirim.');
    }

    public function setujui(MeetingRequest $meetingRequest)
    {
        $meetingRequest->update([
            'status' => 'disetujui',
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Permintaan meeting disetujui.');
    }

    public function tolak(Request $request, MeetingRequest $meetingRequest)
    {
        $meetingRequest->update([
            'status' => 'ditolak',
            'approved_by' => auth()->id(),
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Permintaan meeting ditolak.');
    }
}
