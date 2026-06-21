<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;

class ExaminationController extends Controller
{

    private function ensureDoctorOwnsQueue(Queue $queue): void
    {
        $doctor = Auth::user()->doctor;

        if (
            $queue->registration->doctor_id !== $doctor->id
        ) {
            abort(403);
        }
    }
    public function index()
    {
        $doctor = Auth::user()->doctor;

        $queues = Queue::query()
            ->with([
                'registration.patient',
            ])
            ->whereIn(
                'status',
                [
                    'called',
                    'in_progress',
                ]
            )
            ->whereHas(
                'registration',
                function ($query) use ($doctor) {

                    $query->where(
                        'doctor_id',
                        $doctor->id
                    );
                }
            )
            ->latest('queue_date')
            ->get();

        return view(
            'doctor.examinations.index',
            compact('queues')
        );
    }

    public function create(Queue $queue)
    {
        $this->ensureDoctorOwnsQueue($queue);

        return view(
            'doctor.examinations.create',
            compact('queue')
        );
    }

    public function store(StoreMedicalRecordRequest $request, Queue $queue)
    {
        $this->ensureDoctorOwnsQueue($queue);

        MedicalRecord::create([

            ...$request->validated(),

            'registration_id' =>
                $queue->registration_id,

            'examined_at' =>
                now(),
        ]);

        $queue->update([
            'status' => 'done',
        ]);

        $queue->registration->update([
            'status' => 'completed',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($queue)
            ->event('examined')
            ->log(
                'Medical record created'
            );

        return redirect()
            ->route(
                'doctor.examinations.index'
            )
            ->with(
                'success',
                'Medical record created successfully.'
            );
    }

    public function start(Queue $queue)
    {
        $this->ensureDoctorOwnsQueue($queue);

        $queue->update([
            'status' => 'in_progress',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($queue)
            ->event('started')
            ->log('Examination started');

        return back()->with(
            'success',
            'Examination started successfully.'
        );
    }
}