<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\PatientResource;
use App\Http\Resources\UpcomingAppResource;


class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->patient->full_name,
            'medical_treatment' => $this->medical_treatment,
            'condition' => $this->diagnostic,
            'note' => $this->note,
            'patient_id' => $this->patient->id,
            'patient_name' => $this->patient->full_name,
            'patient_cin' => $this->patient->cin,
            'patient_gender' => $this->patient->gender,
            'patient' =>$this->patient,
            'next_examination_date' => $this->next_examination_date ? $this->next_examination_date->format('Y-m-d') : null,
            'rate' => $this->rate,
            'date' => $this->created_at->format('Y-m-d'),
            'backgroundColor' => '#68B984',
  

            // 'date' => $this->created_at->format('d M Y'),
            

        ];
    }
}
