<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class DepartmentRequest extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'department_id',
        'patient_id',
        'visiting_id',
        'created_at',
        'updated_at',
    ];

    public function visiting()
    {
        $this->belongsTo(Visiting::class);
    }
}