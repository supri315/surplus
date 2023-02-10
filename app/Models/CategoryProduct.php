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
            queryFormatDate('category_products.created_at', 'fcreated_at', ' "%d-%b-%Y" '),
            'category_products.updated_at',
            queryFormatDate('category_products.updated_at', 'fupdated_at', ' "%d-%b-%Y" '),
        ])
        ->Leftjoin('categories', 'category_products.category_id','categories.id')
        ->Leftjoin('products', 'category_products.product_id','products.id')
        ->orderBy('category_products.id', 'DESC');
    }   
}
