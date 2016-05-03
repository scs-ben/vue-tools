<?php

namespace App\Models;

use App\Models\VueModel;
use Carbon\Carbon;

class Project extends VueModel
{
	protected $table = 'projects';

	protected $fillable = [
		'id',
		'name'
	];

	protected $casts = [
		'id' => 'integer',
		'name' => 'string'
	];

	protected $dates = [
		'created_at',
		'updated_at'
	];

	protected $attributes = [
		'id' => 0,
		'name' => '',
		'created_at' => null,
		'updated_at' => null
	];


	public function setCreatedAtAttribute($value)
    {
        if(trim($value) == '') {
    		$this->attributes['created_at'] = null;
    	} else {
    		$this->attributes['created_at'] = Carbon::parse($value);	
    	}
    }

    public function setUpdatedAtAttribute($value)
    {
        if(trim($value) == '') {
    		$this->attributes['updated_at'] = null;
    	} else {
    		$this->attributes['updated_at'] = Carbon::parse($value);	
    	}
    }

    public function scopeOrdered($query)
	{
	    return $query->orderBy('name', 'asc')->get();
	}
}

