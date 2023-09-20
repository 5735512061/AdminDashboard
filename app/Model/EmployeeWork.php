<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class EmployeeWork extends Model
{
	protected $table = 'employee_works';

	protected $fillable = [
    	'employee_id', 'year', 'month', 'month_', 'absence', 'late', 'charge', 'insurance', 'deduct', 'skill', 'comment',
    ];

    protected $primaryKey = 'id';
}
