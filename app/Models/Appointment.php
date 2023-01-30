<?php

namespace App\Models;

use App\Models\Patient;
use App\Models\Invoice;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory , Notifiable;
    protected $dates = ['next_examination_date'];


    protected $fillable = [
        'patient_id',
        'diagnostic',
        'medical_treatment',
        'next_examination_date',
        'note',
        'rate',
       
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    // public function scopeIsSession($query)
    // {
    //     return $query->where('type', 'session');
    // }
    public function scopeStartOfMonth($query) {
        return $query->where('created_at', '>=', Carbon::now()->startOfMonth());
    }
    // public function scopePaid($query, $status) {
    //     $query->where('is_paid', $status);
    // }
  

}
