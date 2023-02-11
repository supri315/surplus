<?php
namespace App\Http\Services;

use Request;
use Illuminate\Support\Arr;
use App\Models\ProductImage;
use App\Http\Repositories\ProductImageRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\ImageRepository;


class ProductImageService extends BaseService
{

    public function __construct()
    {
        $this->model = new ProductImage;
        $this->repository = new ProductImageRepository;
        $this->repositoryProduct = new ProductRepository;
        $this->repositoryImage = new ImageRepository;

    }

    public function create($data)
    {
        $checkProduct = $this->repositoryProduct->getSingleData($data['product_id']);
        $checkImage = $this->repositoryImage->getSingleData($data['image_id']);

      
        $this->model->validate($data, [
            'product_id'=>'required',
            'image_id' => 'required',                
         ]);

        $input = Arr::only($data, [
            "product_id",
            "image_id"
        ]);

        $result = $this->model->create($input);

        return $this->repository->getSingleData($result->id);
     
    }

    public function update($id,$data)
    {
        $checkData = $this->repository->getSingleData($id);
        $checkProduct = $this->repositoryProduct->getSingleData($data['product_id']);
        $checkImage = $this->repositoryImage->getSingleData($data['image_id']);

        $this->model->validate($data, [
            'product_id'=>'required',
            'image_id' => 'required',             
         ]);

        $input = Arr::only($data, [
            "product_id",
            "image_id"
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
