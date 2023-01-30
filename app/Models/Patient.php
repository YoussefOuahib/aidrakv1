<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Condition;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;
    protected $dates = ['birth_date'];


    protected $fillable = [
        'full_name',
        'phone',
        'birth_date',
        'cin',
        'gender',
        'insurance'
    ];
    public function scopeStartOfMonth($query) {
        return $query->where('created_at', '>=', Carbon::now()->startOfMonth());
    }
    public function condition() {
        return $this->belongsToMany(Condition::class, 'patient_condition');
    }
    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
    public function invoice() {
        return $this->hasOne(Invoice::class);
    }
}
