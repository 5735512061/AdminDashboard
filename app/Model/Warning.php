<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
	protected $table = 'warnings';

	protected $fillable = [
    	'id', 'employee_id', 'date', 'warning'
    ];

    protected $primaryKey = 'id';
}
