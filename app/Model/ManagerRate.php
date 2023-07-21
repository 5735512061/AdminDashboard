<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ManagerRate extends Model
{
	protected $table = 'manager_rates';

	protected $fillable = [
    	'manager_id', 'evaluation_id', 'rate', 'date'
    ];

    protected $primaryKey = 'id';
}
