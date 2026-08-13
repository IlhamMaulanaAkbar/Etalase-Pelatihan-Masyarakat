<?php

namespace App\Http\Controllers\Internal\Schedules;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\AssistanceAttendance;
use App\Models\AssistanceSchedule;
use App\Models\AssistanceUser;
use App\Services\Supports\Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssistanceSchedulesController extends Controller
{
    public function index(Assistance $assistance)
    {
        $schedules = AssistanceSchedule::where('assistance_id', $assistance->id)
            ->orderBy('meeting_number')
            ->orderBy('date')
            ->get();

        return view('internal.schedules.assistance.index', compact('schedules', 'assistance'));
    }

    public function show(Assistance $assistance, AssistanceSchedule $schedule)
    {
        abort_if($schedule->assistance_id !== $assistance->id, 404);

        $this->markMissingAttendancesAsAbsent($assistance, $schedule);

        $participants = AssistanceUser::with('user')
            ->where('assistance_id', $assistance->id)
            ->where('status', 'LULUS')
            ->get();

        $attendances = AssistanceAttendance::where('assistance_id', $assistance->id)
            ->where('assistance_schedule_id', $schedule->id)
            ->get()
            ->keyBy('participant_name');

        $attendedParticipants = $participants->filter(function ($participant) use ($attendances) {
            return $attendances->has($participant->user?->name);
        });

        $notAttendedParticipants = $participants->reject(function ($participant) use ($attendances) {
            return $attendances->has($participant->user?->name);
        });

        return view('internal.schedules.assistance.show', compact(
            'assistance',
            'schedule',
            'attendances',
            'attendedParticipants',
            'notAttendedParticipants'
        ));
    }

    public function create(Assistance $assistance)
    {
        return view('internal.schedules.assistance.create', compact('assistance'));
    }

    public function store(Request $request, Assistance $assistance)
    {
        $request->validate([
            'meeting_number' => 'required|integer|min:1',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'material_title' => 'required|string|max:255',
            'material_description' => 'nullable|string',
            'speaker_name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xlsx|max:10240',
            'duration' => 'nullable|string|max:50',
        ]);

        $filePath = $request->hasFile('file')
            ? $request->file('file')->store('assistance-schedules', 'public')
            : null;

        AssistanceSchedule::create([
            'assistance_id' => $assistance->id,
            'meeting_number' => $request->meeting_number,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'material_title' => $request->material_title,
            'material_description' => $request->material_description,
            'speaker_name' => $request->speaker_name,
            'file' => $filePath,
            'duration' => $request->duration,
        ]);

        return redirect()->route('internal.schedules.assistance.index', ['assistance' => $assistance->id])
            ->with(Alert::success('Jadwal Pendampingan berhasil disimpan.'));
    }

    public function edit(Assistance $assistance, AssistanceSchedule $schedule)
    {
        abort_if($schedule->assistance_id !== $assistance->id, 404);

        return view('internal.schedules.assistance.edit', compact('schedule', 'assistance'));
    }

    public function update(Request $request, Assistance $assistance, AssistanceSchedule $schedule)
    {
        abort_if($schedule->assistance_id !== $assistance->id, 404);

        $request->validate([
            'meeting_number' => 'required|integer|min:1',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'material_title' => 'required|string|max:255',
            'material_description' => 'nullable|string',
            'speaker_name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xlsx|max:10240',
            'duration' => 'nullable|string|max:50',
        ]);

        $schedule->update([
            'meeting_number' => $request->meeting_number,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'material_title' => $request->material_title,
            'material_description' => $request->material_description,
            'speaker_name' => $request->speaker_name,
            'duration' => $request->duration,
        ]);

        if ($request->hasFile('file')) {
            if ($schedule->file && Storage::disk('public')->exists($schedule->file)) {
                Storage::disk('public')->delete($schedule->file);
            }

            $schedule->file = $request->file('file')->store('assistance-schedules', 'public');
        }

        $schedule->save();

        return redirect()->route('internal.schedules.assistance.index', ['assistance' => $assistance->id])
            ->with(Alert::success('Jadwal Pendampingan berhasil diperbarui.'));
    }

    public function destroy(Assistance $assistance, AssistanceSchedule $schedule)
    {
        abort_if($schedule->assistance_id !== $assistance->id, 404);

        if ($schedule->file && Storage::disk('public')->exists($schedule->file)) {
            Storage::disk('public')->delete($schedule->file);
        }

        $schedule->delete();

        return redirect()->route('internal.schedules.assistance.index', ['assistance' => $assistance->id])
            ->with(Alert::success('Jadwal Pendampingan berhasil dihapus.'));
    }

    private function attendanceWindow(AssistanceSchedule $schedule): array
    {
        $startsAt = Carbon::parse($schedule->date->format('Y-m-d') . ' ' . $schedule->start_time);
        $endsAt = Carbon::parse($schedule->date->format('Y-m-d') . ' ' . $schedule->end_time);
        $now = now();

        return [
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'is_open' => $now->betweenIncluded($startsAt, $endsAt),
            'has_started' => $now->gte($startsAt),
            'has_ended' => $now->gt($endsAt),
        ];
    }

    private function markMissingAttendancesAsAbsent(Assistance $assistance, AssistanceSchedule $schedule): void
    {
        if (!$this->attendanceWindow($schedule)['has_ended']) {
            return;
        }

        $participants = AssistanceUser::with('user')
            ->where('assistance_id', $assistance->id)
            ->where('status', 'LULUS')
            ->get();

        foreach ($participants as $participant) {
            if (!$participant->user) {
                continue;
            }

            AssistanceAttendance::firstOrCreate(
                [
                    'assistance_id' => $assistance->id,
                    'assistance_schedule_id' => $schedule->id,
                    'participant_name' => $participant->user->name,
                ],
                [
                    'status' => 'Tidak Hadir',
                    'attendance_time' => null,
                    'note' => 'Otomatis tidak hadir karena tidak melakukan absensi sampai jam pendampingan berakhir.',
                ]
            );
        }
    }
}
