<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class BranchGroup extends Model
{
	protected $table = 'branch_groups';

	protected $fillable = [
    	'branch', 'status',
    ];

    protected $primaryKey = 'id';
}
