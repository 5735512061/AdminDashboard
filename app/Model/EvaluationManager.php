<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class EvaluationManager extends Model
{
	protected $table = 'evaluation_managers';

	protected $fillable = [
    	'branch_id', 'set', 'number', 'list', 'score', 'status'
    ];

    protected $primaryKey = 'id';
}
