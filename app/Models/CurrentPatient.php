<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class CurrentPatient extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'id',
        'doctor_id',
        'patient_id',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(MedicalPerson::class);
    }
}