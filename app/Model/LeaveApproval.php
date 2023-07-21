<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class LeaveApproval extends Model
{
	protected $table = 'leave_approvals';

	protected $fillable = [
    	'id', 'leave_id', 'status'
    ];

    protected $primaryKey = 'id';
}
