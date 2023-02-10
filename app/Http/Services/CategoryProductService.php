<?php
namespace App\Http\Services;

use Request;
use Illuminate\Support\Arr;
use App\Models\CategoryProduct;
use App\Http\Repositories\CategoryProductRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\CategoryRepository;

class CategoryProductService extends BaseService
{

    public function __construct()
    {
        $this->model = new CategoryProduct;
        $this->repository = new CategoryProductRepository;
        $this->repositoryCategory = new CategoryRepository;
        $this->repositoryProduct = new ProductRepository;
    }

    public function create($data)
    {
        $checkProduct = $this->repositoryProduct->getSingleData($data['product_id']);
        $checkCategory = $this->repositoryCategory->getSingleData($data['category_id']);
      
        $this->model->validate($data, [
            'category_id'=>'required',
            'product_id' => 'required',                
         ]);

        $input = Arr::only($data, [
            "category_id",
            "product_id"
        ]);

        $result = $this->model->create($input);

        return $this->repository->getSingleData($result->id);
     
    }

    public function update($id,$data)
    {
        $checkData = $this->repository->getSingleData($id);
        $checkProduct = $this->repositoryProduct->getSingleData($data['product_id']);
        $checkCategory = $this->repositoryCategory->getSingleData($data['category_id']);

        $this->model->validate($data, [
            'category_id'=>'required',
            'product_id' => 'required',               
         ]);

         $input = Arr::only($data, [
            "category_id",
            "product_id"
        ]);


        $result = $this->model->where("id",$checkData->id)->update($input);

        return $this->repository->getSingleData($checkData->id);
     
    }

    public function delete($id)
    {
        $checkData = $this->repository->getSingleData($id);

        $checkData->delete();

    }
}
