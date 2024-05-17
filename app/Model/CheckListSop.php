<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class CheckListSop extends Model
{
	protected $table = 'checklist_sops';

	protected $fillable = [
    	'employee_id', 'branch_id', 'date', 'status', 'set', 'period'
    ];

    protected $primaryKey = 'id';
}
