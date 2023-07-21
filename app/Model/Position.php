<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	protected $table = 'positions';

	protected $fillable = [
    	'branch_group_id', 'position', 'status',
    ];

    protected $primaryKey = 'id';
}
