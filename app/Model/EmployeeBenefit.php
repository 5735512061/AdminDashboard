<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class EmployeeBenefit extends Model
{
	protected $table = 'employee_benefits';

	protected $fillable = [
    	'id', 'employee_id', 'benefit_id', 'status'
    ];

    protected $primaryKey = 'id';
}
