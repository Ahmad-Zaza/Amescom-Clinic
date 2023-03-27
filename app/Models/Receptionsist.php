<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Receptionsist extends Authenticatable
{
    use HasFactory;

    protected $guard = 'reception';

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
        'isContracted'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function visitings()
    {
        return $this->hasMany(Visiting::class);
    }
}