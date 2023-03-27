<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Patient extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'firstName',
        'lastName',
        'fatherName',
        'nationaltyID',
        'gender',
        'bloodSympol',
        'phoneNumber',
    ];


    public function visitings()
    {
        return $this->hasMany(Visiting::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }


    public function medicalAnalyses()
    {
        return $this->hasMany(MedicalAnalysis::class);
    }

    public function radiographs()
    {
        return $this->hasMany(Radiograph::class);
    }

    public function currentPatient()
    {
        return $this->belongsTo(CurrentPatient::class);
    }
}