<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Condition;
use App\Models\Appointment;
/* Resources & Collections */
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientCollection;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;

use Carbon\Carbon;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $patients = Patient::paginate(10);

        return new PatientCollection($patients);
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
     * @param  \App\Http\Requests\StorePatientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatientRequest $request)
    {
        $patient = Patient::create([
            'full_name' => $request->full_name,
            'cin' => $request->cin,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'insurance' => $request->insurance,
            'birth_date' => Carbon::parse($request->birth_date),
        ]);

        return new PatientResource($patient);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);
        return new PatientResource($patient);
    }

    public function getPatientsByCondition($id) {
        $patients = Patient::whereHas('condition', function($q) use($id) {
            $q->where('condition_id', $id);
        })->get();

        return new PatientCollection($patients);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePatientRequest  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $patient->update([
            'full_name' => $request->full_name,
            'cin' => $request->cin,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'insurance' => $request->insurance,
            'birth_date' => Carbon::parse($request->birth_date),
        ]);
        return new PatientResource($patient);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        $patient->condition()->detach();
        Appointment::where('patient_id', $patient->id)->delete();
        return response()->noContent();
    }
    public function detach(Patient $patient, $condition_id) {
        $condition = Condition::find($condition_id);
        $patient->condition()->detach($condition_id);
        return response()->noContent();

    }
    public function search() {

            $searching = request('searching');
            $patients = Patient::where('full_name', 'LIKE', '%' . $searching . '%')
            ->orWhere('cin', 'LIKE', '%' . $searching . '%')
            ->get();  
            return new PatientCollection($patients);          
        
    }
}
