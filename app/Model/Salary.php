<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
	protected $table = 'salarys';

	protected $fillable = [
    	'employee_id', 'year', 'month', 'month_', 'salary', 'status'
    ];

    protected $primaryKey = 'id';
}
