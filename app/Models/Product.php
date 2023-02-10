<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    public function getKeyPrimaryTableAttribute()
    {
        return $this->getTable().'.'.$this->getKeyName();
    }

    public function scopeGetAll($query)
    {
        return $query->select([
            'products.id',
            'products.name',
            'products.description',
            'products.enable',
            'products.created_at',
            queryFormatDate('products.created_at', 'fcreated_at', ' "%d-%b-%Y" '),
            'products.updated_at',
            queryFormatDate('products.updated_at', 'fupdated_at', ' "%d-%b-%Y" '),
        ])
        ->orderBy('products.id', 'DESC');
    }   
}
