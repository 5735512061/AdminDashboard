<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
	protected $table = 'evaluations';

	protected $fillable = [
    	'branch_id', 'set', 'number', 'list', 'score', 'status'
    ];

    protected $primaryKey = 'id';
}
