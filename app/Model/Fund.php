<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $table = 'funds';

	protected $fillable = [
    	'employee_id', 'year', 'month', 'fund',
    ];

    protected $primaryKey = 'id';
}
