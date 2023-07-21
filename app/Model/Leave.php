<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
	protected $table = 'leaves';

	protected $fillable = [
    	'id', 'employee_id', 'date', 'type_leave', 'number_of_leave', 'start_date', 'end_date', 'detail'
    ];

    protected $primaryKey = 'id';
}
