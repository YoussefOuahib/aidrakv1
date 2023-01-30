<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentCollection;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\NextDateCollection;
use App\Models\Appointment;
use App\Models\Condition;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $appointments = Appointment::all();

        return new AppointmentCollection($appointments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'medical_treatment' => $request->medical_treatment,
            'rate' => $request->rate,
            'next_examination_date' => $request->next_examination_date == null ? $request->next_examination_date : Carbon::parse($request->next_examination_date),
            'note' => $request->note,
            'diagnostic' => $request->diagnostic,           
        ]);

      
        return new AppointmentResource($appointment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::find($id);
        // $upcoming = UpcomingAppointment::where('appointment_id', $appointment->id)->get();
        return new AppointmentResource($appointment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update([
            'medical_treatment' => $request->medical_treatment,
            'diagnostic' => $request->diagnostic,
            'next_examination_date' => Carbon::parse($request->next_examination_date),
            'rate' => $request->rate,
            'note' => $request->note,

        ]);
        
        return new AppointmentResource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
       
     
        
        $appointment->delete();

        return response()->noContent();
    }

    public function search()
    {

        $searching = request('searching');
        $appointments = Appointment::whereHas('patient', function (Builder $query) use ($searching) {
            $query->where('full_name', 'LIKE', '%' . $searching . '%');
        })->get();
        return new AppointmentCollection($appointments);

    }
    public function calendar()
    {

        $appointments = Appointment::whereNotNull('next_examination_date')->get();

        return new NextDateCollection($appointments);

    }
    public function deleteDate(Appointment $appointment)
    {
        $appointment->update([
            'next_examination_date' => null,
        ]);
        return response()->json(['status' => 201]);
    }
  
}
