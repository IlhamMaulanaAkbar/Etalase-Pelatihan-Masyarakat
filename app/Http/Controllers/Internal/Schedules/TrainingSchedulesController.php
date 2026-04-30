<?php

namespace App\Http\Controllers\Internal\Schedules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\TrainingAttendance;
use App\Models\TrainingSchedule;
use App\Models\TrainingUser;
use Illuminate\Support\Facades\Storage;
use App\Services\Supports\Alert;
use Carbon\Carbon;

class TrainingSchedulesController extends Controller
{
    public function index(Training $training)
    {
        $schedules = TrainingSchedule::where('training_id', $training->id)
            ->orderBy('meeting_number')
            ->orderBy('date')
            ->get();

        return view('internal.schedules.training.index', compact('schedules', 'training'));
    }

    public function show(Training $training, TrainingSchedule $schedule)
    {
        abort_if($schedule->training_id !== $training->id, 404);

        $this->markMissingAttendancesAsAbsent($training, $schedule);

        $participants = TrainingUser::with('user')
            ->where('training_id', $training->id)
            ->where('status', 'LULUS')
            ->get();

        $attendances = TrainingAttendance::where('training_id', $training->id)
            ->where('training_schedule_id', $schedule->id)
            ->get()
            ->keyBy('participant_name');

        $attendedParticipants = $participants->filter(function ($participant) use ($attendances) {
            return $attendances->has($participant->user?->name);
        });

        $notAttendedParticipants = $participants->reject(function ($participant) use ($attendances) {
            return $attendances->has($participant->user?->name);
        });

        return view('internal.schedules.training.show', compact(
            'training',
            'schedule',
            'attendances',
            'attendedParticipants',
            'notAttendedParticipants'
        ));
    }

    private function attendanceWindow(TrainingSchedule $schedule): array
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

    private function markMissingAttendancesAsAbsent(Training $training, TrainingSchedule $schedule): void
    {
        if (!$this->attendanceWindow($schedule)['has_ended']) {
            return;
        }

        $participants = TrainingUser::with('user')
            ->where('training_id', $training->id)
            ->where('status', 'LULUS')
            ->get();

        foreach ($participants as $participant) {
            if (!$participant->user) {
                continue;
            }

            TrainingAttendance::firstOrCreate(
                [
                    'training_id' => $training->id,
                    'training_schedule_id' => $schedule->id,
                    'participant_name' => $participant->user->name,
                ],
                [
                    'status' => 'Tidak Hadir',
                    'attendance_time' => null,
                    'note' => 'Otomatis tidak hadir karena tidak melakukan absensi sampai jam pelajaran berakhir.',
                ]
            );
        }
    }

    public function create(Training $training)
    {
        return view('internal.schedules.training.create', compact('training'));
    }

    public function store(Request $request, Training $training)
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
            ? $request->file('file')->store('training-schedules', 'public')
            : null;

        TrainingSchedule::create([
            'training_id' => $training->id,
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

        return redirect()->route('internal.schedules.training.index', ['training' => $training->id])
            ->with(Alert::success('Jadwal Pelatihan berhasil disimpan.'));
    }

    public function edit(Training $training, TrainingSchedule $schedule)
    {
        abort_if($schedule->training_id !== $training->id, 404);

        return view('internal.schedules.training.edit', compact('schedule', 'training'));
    }

    public function update(Request $request, Training $training, TrainingSchedule $schedule)
    {
        abort_if($schedule->training_id !== $training->id, 404);

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
            $schedule->file = $request->file('file')->store('training-schedules', 'public');
        }

        $schedule->save();

        return redirect()->route('internal.schedules.training.index', ['training' => $training->id])
            ->with(Alert::success('Jadwal Pelatihan berhasil diperbarui.'));
    }

    public function destroy(Training $training, TrainingSchedule $schedule)
    {
        abort_if($schedule->training_id !== $training->id, 404);

        if ($schedule->file && Storage::disk('public')->exists($schedule->file)) {
            Storage::disk('public')->delete($schedule->file);
        }

        $schedule->delete();

        return redirect()->route('internal.schedules.training.index', ['training' => $training->id])
            ->with(Alert::success('Jadwal Pelatihan berhasil dihapus.'));
    }
}
