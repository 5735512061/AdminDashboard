<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Employee extends Authenticatable
{
	use Notifiable;
	
    protected $table = 'employees';

    protected $guard = 'staff';

    protected $fillable = [
    	'idcard', 'name', 'surname', 'nickname', 'bday', 'tel', 'branch_id', 'position_id', 'startdate', 'address', 'district', 'amphoe', 'province', 'zipcode', 'employee_name', 'password', 'password_name', 'image', 'status'
    ];

    protected $primaryKey = 'id';

    protected $hidden = [
        'password', 'remember_token',
    ];
}