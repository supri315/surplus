<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name'          =>  $this->name,
            'enable'        =>  $this->enable, 
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
