<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
	protected $table = 'benefits';

	protected $fillable = [
    	'id', 'benefit', 'store', 'expire', 'code', 'status'
    ];

    protected $primaryKey = 'id';
}
