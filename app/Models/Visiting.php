<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Visiting extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'patient_id',
        'department_id',
        'receptionist_id',
        'status',
        'created_at',
        'updated_at'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function receptionsist()
    {
        return $this->belongsTo(Receptionsist::class);
    }

    public function prescription()
    {
        return $this->hasMany(Prescription::class);
    }


    public function medicalAnalysises()
    {
        return $this->hasMany(MedicalAnalysis::class);
    }

    public function radiographs()
    {
        return $this->hasMany(Radiograph::class);
    }

    public function request()
    {
        $this->hasOne(DepartmentRequest::class);
    }
}