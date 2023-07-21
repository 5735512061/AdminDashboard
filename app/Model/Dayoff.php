<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Dayoff extends Model
{
	protected $table = 'dayoffs';

	protected $fillable = [
    	'employee_id', 'year', 'month', 'dayoff', 'status'
    ];

    protected $primaryKey = 'id';
}
