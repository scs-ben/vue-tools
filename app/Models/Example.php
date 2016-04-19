<?php

namespace App\Models;

use App\Models\VueModel;
use Carbon\Carbon;

class Example extends VueModel
{
	protected $table = 'examples';

	protected $fillable = [
		'id',
		'project_id',
		'name',
		'field1',
		'field2',
	];

	protected $casts = [
		'id' => 'integer',
		'project_id' => 'integer',
		'name' => 'string',
		'field1' => 'string',
		'field2' => 'integer',
	];

	protected $dates = [
		'created_at',
		'updated_at'
	];

	protected $attributes = [
		'id' => 0,
		'project_id' => 0,
		'name' => '',
		'field1' => '',
		'field2' => '',
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
	    return $query->orderBy('updated_at', 'desc')->get();
	}

	public function project() 
	{
		return $this->belongsTo('App\Models\Project', 'project_id');
	}
}

