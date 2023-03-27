<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MedicalAnalysis extends Authenticatable implements HasMedia
{
    use HasFactory, Sortable, InteractsWithMedia;

    protected $fillable = [
        'patient_id',
        'visiting_id',
        'medical_person_id',
        'content'
    ];

    public function medicalPerson()
    {
        return $this->belongsTo(MedicalPerson::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function visiting()
    {
        return $this->belongsTo(Visiting::class);
    }
}
