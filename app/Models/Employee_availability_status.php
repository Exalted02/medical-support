<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee_availability_status extends Model
{
    use HasFactory;
	protected $table = 'employee_availability_statuses';
	protected $fillable = [
        'emp_id',
        'is_available',
        'availability_date',
    ];
}
