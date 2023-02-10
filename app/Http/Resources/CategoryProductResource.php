<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            =>  $this->id,
            'category_id'   =>  $this->category_id,
            'category_name' =>  $this->category_name, 
            'product_id'    =>  $this->product_id,
            'product_name'  =>  $this->product_name, 
            'created_at'    =>  $this->created_at, 
            'fcreated_at'   =>  $this->fcreated_at, 
            'updated_at'    =>  $this->updated_at, 
            'fupdated_at'   =>  $this->fupdated_at, 
        ];    
    }

    public function with($request)
    {
        return [
            'status'    => 200,
            'error'     => 0
        ];
    }
}
