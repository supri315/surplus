<?php
namespace App\Http\Services;

use Request;
use Illuminate\Support\Arr;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\ProductImage;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ImageRepository;


class ProductService extends BaseService
{

    public function __construct()
    {
        $this->model = new Product;
        $this->modelCategoryProduct = new CategoryProduct;
        $this->modelProductImage = new ProductImage;
        $this->repository = new ProductRepository;
        $this->repositoryCategory = new CategoryRepository;
        $this->repositoryImage = new ImageRepository;

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

    ## product dengan category dan image ##

    public function createProducts($data)
    {
        
        $this->model->validate($data, [
            'name'=>'required|unique:products',
            'description'=>'required',
            'enable' => 'required|boolean',                
            'category_id' => 'required|array',  
            "category_id.*"  => "required",
            'image_id' => 'required|array',  
            "image_id.*"  => "required",
              
         ]);

        $input = Arr::only($data, [
            "name",
            "description",
            "enable",
        ]);

      
        $result = $this->model->create($input);

        if (!empty($data['category_id'])) {
            if(is_array($data['category_id'])) {
                foreach ($data['category_id'] as $value) {
                    $checkCategory = $this->repositoryCategory->getSingleData($value);
                    $this->modelCategoryProduct->create([
                        'product_id' => $result->id,
                        'category_id' => $value
                    ]);
                }
            }
        }    

        if (!empty($data['image_id'])) {
            if(is_array($data['image_id'])) {
                foreach ($data['image_id'] as $value) {
                    $checkImage = $this->repositoryImage->getSingleData($value);
                    $this->modelProductImage->create([
                        'product_id' => $result->id,
                        'image_id' => $value
                    ]);
                }
            }
        }    

        return $this->repository->getSingleAllData($result->id);
     
    }

    public function updateProducts($id,$data)
    {
        $checkData = $this->repository->getSingleData($id);

        $this->model->validate($data, [
            'name'=>'required',\Illuminate\Validation\Rule::unique('products')->ignore($id),
            'description'=>'required',
            'enable' => 'required|boolean',    
            'category_id' => 'required|array',  
            "category_id.*"  => "required",
            'image_id' => 'required|array',  
            "image_id.*"  => "required",            
         ]);

        $input = Arr::only($data, [
            "name",
            "description",
            "enable"
        ]);

        $result = $this->model->where("id",$checkData->id)->update($input);

        if (!empty($data['category_id'])) {
            //delete data
            $this->modelCategoryProduct->where('product_id',$checkData->id)->delete();
            if(is_array($data['category_id'])) {
                foreach ($data['category_id'] as $value) {
                    $checkCategory = $this->repositoryCategory->getSingleData($value);
           
                    //insert data
                    $this->modelCategoryProduct->create([
                        'product_id' => $checkData->id,
                        'category_id' => $value
                    ]);
                }
            }
        }    

        if (!empty($data['image_id'])) {
            //delete data
            $this->modelProductImage->where('product_id',$checkData->id)->delete();
            if(is_array($data['image_id'])) {
                foreach ($data['image_id'] as $value) {
                    $checkImage = $this->repositoryImage->getSingleData($value);
           

                    //insert data
                    $this->modelProductImage->create([
                        'product_id' => $checkData->id,
                        'image_id' => $value
                    ]);
                }
            }
        }    

        return $this->repository->getSingleAllData($checkData->id);
     
    }

    public function deleteProducts($id)
    {
        $checkData = $this->repository->getSingleData($id);

        $checkData->delete();

        $this->modelProductImage->where('product_id',$checkData->id)->delete();
        
        $this->modelCategoryProduct->where('product_id',$checkData->id)->delete();

    }


    ## interaksi semua tabel ##

    

}
