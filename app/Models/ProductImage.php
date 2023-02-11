<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends BaseModel
{
    public function getKeyPrimaryTableAttribute()
    {
        return $this->getTable().'.'.$this->getKeyName();
    }

    public function scopeGetAll($query)
    {
        return $query->select([
            'product_images.id',
            'product_images.product_id',
            'products.name as product_name',
            'product_images.image_id',
            'images.name as image_name',
            'product_images.created_at',
            queryFormatDate('product_images.created_at', 'fcreated_at', ' "%d-%b-%Y" '),
            'product_images.updated_at',
            queryFormatDate('product_images.updated_at', 'fupdated_at', ' "%d-%b-%Y" '),
        ])
        ->leftjoin('images', 'product_images.image_id','images.id')
        ->leftjoin('products', 'product_images.product_id','products.id')
        ->orderBy('product_images.id', 'DESC');
    }   
}
