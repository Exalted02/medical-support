<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee_manage_tickets extends Model
{
    use HasFactory;
	protected $table = 'employee_manage_tickets';
	protected $fillable = [
        'emp_id',
        'department_id',
        'ticket_id',
    ];
	
	public function get_tickets()
    {
        return $this->hasMany(Ticket::class, 'id', 'ticket_id');
    }
}
