<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends BaseModel
{
    public function getKeyPrimaryTableAttribute()
    {
        return $this->getTable().'.'.$this->getKeyName();
    }

    public function scopeGetAll($query)
    {
        return $query->select([
            'category_products.id',
            'category_products.product_id',
            'products.name as product_name',
            'category_products.category_id',
            'categories.name as category_name',
            'category_products.created_at',
            queryFormatDate('category_products.created_at', 'fcreated_at', ' "%d-%b-%Y" '),
            'category_products.updated_at',
            queryFormatDate('category_products.updated_at', 'fupdated_at', ' "%d-%b-%Y" '),
        ])
        ->leftjoin('categories', 'category_products.category_id','categories.id')
        ->leftjoin('products', 'category_products.product_id','products.id')
        ->where('categories.enable',1)
        ->where('products.enable',1)
        ->orderBy('category_products.id', 'DESC');
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
