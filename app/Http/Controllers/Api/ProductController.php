<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\ProductService;


class ProductController extends Controller
{

    public function __construct()
    {
        $this->service = new ProductService;
    }

    public function index()
    {
        $data = $this->service->getIndexData([
                'id'            =>  'id',
                'name'          =>  'name',
                'description'   =>  'description',
                'enable'        =>  'enable',
            ]);

        return (\App\Http\Resources\ProductResource::collection($data))
                ->additional([
                    'sortableAndSearchableColumn' =>    $data->sortableAndSearchableColumn
                ]);
    }

    public function show($locale,$id)
    {
        $data = $this->service->getSingleData($id);
        return new  \App\Http\Resources\ProductResource($data);
    }

    public function create($locale)
    {
        $data = $this->service->create(\Request::all());
        return new \App\Http\Resources\ProductResource($data);
    }

    public function update($locale,$id)
    {
        $data = $this->service->update($id,\Request::all());
      
        return new \App\Http\Resources\ProductResource($data);
    }

    public function delete($locale,$id)
    {
        $data = $this->service->delete($id);
      
        return new \App\Http\Resources\DeleteResource($data);
    }


    ## function produk dengan categori dan gambar

    public function allProducts()
    {
        $data = $this->service->getIndexDataAll([
                'id'            =>  'id',
                'name'          =>  'name',
                'description'   =>  'description',
                'enable'        =>  'enable',
            ]);

        return (\App\Http\Resources\ProductAllResource::collection($data))
                ->additional([
                    'sortableAndSearchableColumn' =>    $data->sortableAndSearchableColumn
                ]);
    }

    public function showAllProducts($locale,$id)
    {
        $data = $this->service->getSingleAllData($id);
        return new  \App\Http\Resources\ProductAllResource($data);
    }
    
    public function createAllProducts($locale)
    {
        $data = $this->service->createProducts(\Request::all());
        return new \App\Http\Resources\ProductAllResource($data);
    }

    public function updateAllProducts($locale,$id)
    {
        $data = $this->service->updateProducts($id,\Request::all());
      
        return new \App\Http\Resources\ProductAllResource($data);
    }

    public function deleteAllProducts($locale,$id)
    {
        $data = $this->service->deleteProducts($id);
      
        return new \App\Http\Resources\DeleteResource($data);
    }


    ## function interaksi semua tabel
    
    public function createAllData($locale)
    {
        $data = $this->service->createAllData(\Request::all());
        return new \App\Http\Resources\ProductAllResource($data);
    }


}
