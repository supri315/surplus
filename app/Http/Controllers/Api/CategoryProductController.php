<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\CategoryProductService;


class CategoryProductController extends Controller
{

    public function __construct()
    {
        $this->service = new CategoryProductService;
    }

    public function index()
    {
        $data = $this->service->getIndexData([
                'id'            =>  'id',
                'category_id'   =>  'category_id',
                'product_id'    =>  'product_id',
            ]);

        return (\App\Http\Resources\CategoryProductResource::collection($data))
                ->additional([
                    'sortableAndSearchableColumn' =>    $data->sortableAndSearchableColumn
                ]);
    }

    public function show($locale,$id)
    {
        $data = $this->service->getSingleData($id);
        return new  \App\Http\Resources\CategoryProductResource($data);
    }

    public function create($locale)
    {
        $data = $this->service->create(\Request::all());
        return new \App\Http\Resources\CategoryProductResource($data);
    }

    public function update($locale,$id)
    {
        $data = $this->service->update($id,\Request::all());
      
        return new \App\Http\Resources\CategoryProductResource($data);
    }

    public function delete($locale,$id)
    {
        $data = $this->service->delete($id);
      
        return new \App\Http\Resources\DeleteResource($data);
    }
}
