<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class EmployeeRate extends Model
{
	protected $table = 'employee_rates';

	protected $fillable = [
    	'employee_id', 'evaluation_id', 'rate', 'date'
    ];

    protected $primaryKey = 'id';
}
