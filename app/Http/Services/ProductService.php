<?php
namespace App\Http\Services;

use Request;
use Illuminate\Support\Arr;
use App\Models\Product;
use App\Http\Repositories\ProductRepository;

class ProductService extends BaseService
{

    public function __construct()
    {
        $this->model = new Product;
        $this->repository = new ProductRepository;
    }

    public function create($data)
    {
      
        $this->model->validate($data, [
            'name'=>'required|unique:products',
            'description'=>'required',
            'enable' => 'required|boolean',                
         ]);

        $input = Arr::only($data, [
            "name",
            "description",
            "enable"
        ]);

        $result = $this->model->create($input);

        return $this->repository->getSingleData($result->id);
     
    }

    public function update($id,$data)
    {
        $checkData = $this->repository->getSingleData($id);

        $this->model->validate($data, [
            'name'=>'required',\Illuminate\Validation\Rule::unique('products')->ignore($id),
            'description'=>'required',
            'enable' => 'required|boolean',                
         ]);

        $input = Arr::only($data, [
            "name",
            "description",
            "enable"
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
