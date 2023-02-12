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
        ->where('categories.enable',1)
        ->orderBy('categories.id', 'DESC');
    }   


    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
            $model->updated_at = $model->freshTimestamp();
        });

        static::updating(function ($model) {
            $model->updated_at = $model->freshTimestamp();
        });
    }
}
