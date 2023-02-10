<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends BaseModel
{
    public function getKeyPrimaryTableAttribute()
    {
        return $this->getTable().'.'.$this->getKeyName();
    }

    public function scopeGetAll($query)
    {
        return $query->select([
            'images.id',
            'images.name',
            'images.file',
            'images.enable',
            'images.created_at',
            queryFormatDate('images.created_at', 'fcreated_at', ' "%d-%b-%Y" '),
            'images.updated_at',
            queryFormatDate('images.updated_at', 'fupdated_at', ' "%d-%b-%Y" '),
        ])
        ->orderBy('images.id', 'DESC');
    }   
}
