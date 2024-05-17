<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ListSop extends Model
{
	protected $table = 'list_sops';

	protected $fillable = [
    	'set', 'period', 'title_id', 'number', 'list', 'position', 'status'
    ];

    protected $primaryKey = 'id';
}
