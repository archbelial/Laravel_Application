<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_code',
        'name',
        'gender',
        'position',
        'level',
        'isoneday',
        'remark',
        'paid_leave_start',
        'paid_leave_end',
    ];
}
