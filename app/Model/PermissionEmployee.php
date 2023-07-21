<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class PermissionEmployee extends Model
{
	protected $table = 'permission_employees';

	protected $fillable = [
    	'employee_id', 'role', 'status'
    ];

    protected $primaryKey = 'id';
}
