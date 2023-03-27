<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class Department extends Model
{
    use HasFactory, Notifiable, Sortable;

    protected $fillable = [
        'admin_id',
        'type',
        'name'
    ];

    public function admin()
    {
        $this->belongsTo(Admin::class);
    }

    public function receptionists()
    {
        return $this->hasMany(Receptionsist::class);
    }

    public function visitings()
    {
        return $this->hasMany(Visiting::class);
    }

    public function medicalPersons()
    {
        return $this->hasMany(MedicalPerson::class);
    }
}