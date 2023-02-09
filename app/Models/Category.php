<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
   
    public function getKeyPrimaryTableAttribute()
    {
        return $this->getTable().'.'.$this->getKeyName();
    }

    public function scopeGetAll($query)
    {
        return $query->select([
            'categories.id',
            'categories.name',
            'categories.enable',
            'categories.created_at',
            queryFormatDate('categories.created_at', 'fcreated_at', ' "%d-%b-%Y" '),
            'categories.updated_at',
            queryFormatDate('categories.updated_at', 'fupdated_at', ' "%d-%b-%Y" '),
        ])
        ->orderBy('categories.id', 'DESC');
    }   
}
