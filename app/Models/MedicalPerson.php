<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class MedicalPerson extends Authenticatable
{
    use HasFactory, Sortable;

    protected $guard = 'medical_person';

    protected $fillable = [
        'department_id',
        'admin_id',
        'firstName',
        'fatherName',
        'lastName',
        'phoneNumber',
        'image',
        'aboutYou',
        'userName',
        'password',
        'isContracted',
        'type',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function prescriptions()
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

    public function currentPatients()
    {
        return $this->hasMany(CurrentPatient::class);
    }
}