<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Admin extends Authenticatable implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'fristName',
        'fatherName',
        'lastName',
        'password',
        '',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }


    public function receptionists()
    {
        return $this->hasMany(Receptionsist::class);
    }

    public function medcialPersons()
    {
        return $this->hasMany(MedicalPerson::class);
    }
}