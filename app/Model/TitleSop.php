<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class TitleSop extends Model
{
	protected $table = 'title_sops';

	protected $fillable = [
    	'title', 'status'
    ];

    protected $primaryKey = 'id';
}
