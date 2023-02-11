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

    public function scopeGetDataAll($query)
    {
        \DB::statement('SET GLOBAL group_concat_max_len = 100000000');

        return $query->select([
            'products.id',
            'products.name',
            'products.description',
            'products.enable',
            \DB::raw("((
                select concat('[',IFNULL(group_concat(JSON_OBJECT(
                            'id', categories.id,
                            'name', categories.name
                        ) order by categories.id asc), ''), ']')
                from category_products
                join categories on category_products.category_id = categories.id
                where category_products.product_id = products.id
                and categories.enable = 1
            )) as 'product_category' "),
            \DB::raw("((
                select concat('[',IFNULL(group_concat(JSON_OBJECT(
                            'id', images.id,
                            'name', images.name,
                            'file', images.file
                        ) order by images.id asc), ''), ']')
                from product_images
                join images on product_images.image_id = images.id
                where product_images.product_id = products.id
                and images.enable = 1
            )) as 'product_image' "),
            'products.created_at',
            queryFormatDate('products.created_at', 'fcreated_at', ' "%d-%b-%Y" '),
            'products.updated_at',
            queryFormatDate('products.updated_at', 'fupdated_at', ' "%d-%b-%Y" '),
        ])
        ->where('products.enable',1)
        ->orderBy('products.id', 'DESC');
    } 

 

}
