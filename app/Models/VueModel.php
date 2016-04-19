<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueModel extends Model {
    protected $vue_created;
    protected $vue_updated;
    protected $vue_deleted;

	protected $appends = [
        'vue_created',
		'vue_updated',
		'vue_deleted'
	];
    
    public function deleteRecord() 
    {
        $this->destroy($this->id);
    }

    public function getVueCreatedAttribute()
    {
        return $this->vue_created or false;
    }

    public function setVueCreatedAttribute($value)
    {
        $this->vue_created = $value;
    }

	public function getVueUpdatedAttribute()
    {
        return $this->vue_updated or false;
    }

    public function setVueUpdatedAttribute($value)
    {
        $this->vue_updated = $value;
    }

    public function getVueDeletedAttribute()
    {
        return $this->vue_deleted or false;
    }

    public function setVueDeletedAttribute($value)
    {
        $this->vue_deleted = $value;
    }
}