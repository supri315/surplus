<?php
namespace App\Http\Services;

use Request;
use Illuminate\Support\Arr;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Image;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ImageRepository;


class ProductService extends BaseService
{

    public function __construct()
    {
        $this->model = new Product;
        $this->modelCategory = new Category;
        $this->modelImage = new Image;
        $this->modelCategoryProduct = new CategoryProduct;
        $this->modelProductImage = new ProductImage;
        $this->repository = new ProductRepository;
        $this->repositoryCategory = new CategoryRepository;
        $this->repositoryImage = new ImageRepository;

    }

    public function create($data)
    {
        \DB::beginTransaction();
 
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

        \DB::commit();

        return $this->repository->getSingleData($result->id);
     
    }

    public function update($id,$data)
    {
        \DB::beginTransaction();

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

        \DB::commit();

        return $this->repository->getSingleData($checkData->id);
     
    }

    public function delete($id)
    {
        \DB::beginTransaction();

        $checkData = $this->repository->getSingleData($id);

        $checkData->delete();

        \DB::commit();


    }

    ## product dengan category dan image ##

    public function createProducts($data)
    {
        
        \DB::beginTransaction();

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

        \DB::commit();

        return $this->repository->getSingleAllData($result->id);
     
    }

    public function updateProducts($id,$data)
    {
        \DB::beginTransaction();

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

        \DB::commit();

        return $this->repository->getSingleAllData($checkData->id);
     
    }

    public function deleteProducts($id)
    {
        \DB::beginTransaction();

        $checkData = $this->repository->getSingleData($id);

        $checkData->delete();

        $this->modelProductImage->where('product_id',$checkData->id)->delete();
        
        $this->modelCategoryProduct->where('product_id',$checkData->id)->delete();

        \DB::commit();

    }


    ## interaksi semua tabel ##
    public function createAllData($data)
    {
        \DB::beginTransaction();

        $this->model->validate($data, [
            'name'=>'required|unique:products',
            'description'=>'required',
            'enable' => 'required|boolean',                
            'category_name' => 'required|array|unique:categories',  
            "category_name.*"  => "required",
            'category_enable' => 'required|array',  
            "category_enable.*"  => "required",
            'image_name' => 'required|array|unique:images',  
            "image_name.*"  => "required",
            'image_file' => 'required|array',  
            "image_file.*"  => "required",
            'image_enable' => 'required|array',  
            "image_enable.*"  => "required",
              
         ]);

        $input = Arr::only($data, [
            "name",
            "description",
            "enable"
        ]);

      
        $result = $this->model->create($input);

        if (!empty($data['category_name']) && !empty($data['category_enable']) ) {
            if(is_array($data['category_name']) && is_array($data['category_enable'])) {

                for ($i = 0; $i < count($data['category_name']); $i++) {
                    $idCategories[] = $this->modelCategory->insertGetId([
                                        'name' => $data['category_name'][$i],
                                        'enable' => $data['category_enable'][$i],
                                        'created_at' => $this->modelCategory->freshTimestamp(),
                                        'updated_at' => $this->modelCategory->freshTimestamp()
                                    ]);                    
                }

                for ($i=0; $i < count($idCategories) ; $i++) { 
                    $this->modelCategoryProduct::create([
                        'category_id' => $idCategories[$i],
                        'product_id' => $result->id
                    ]);
                }
            }
        }    

        if (!empty($data['image_name']) && !empty($data['image_enable']) && !empty($data['image_file']) ) {
            if(is_array($data['image_name']) && is_array($data['image_enable']) && is_array($data['image_file'])) {

                for ($i = 0; $i < count($data['image_name']); $i++) {
                    
                    $file = $data['image_file'][$i];
                    $folder = '/upload/image';
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $filePath = public_path() .''.$folder;
                    $file->move($filePath, $filename);
                  
                    $idImages[] = $this->modelImage->insertGetId([
                                        'name' => $data['image_name'][$i],
                                        'enable' => $data['image_enable'][$i],
                                        'file'  => env('APP_URL').''.$folder.''.$filename,
                                        'created_at' => $this->modelCategory->freshTimestamp(),
                                        'updated_at' => $this->modelCategory->freshTimestamp()
                                    ]);                    
                }

                for ($i=0; $i < count($idImages) ; $i++) { 
                    $this->modelProductImage::create([
                        'image_id' => $idImages[$i],
                        'product_id' => $result->id
                    ]);
                }
            }
        }    


        \DB::commit();

        return $this->repository->getSingleAllData($result->id);
     
    }

    
    

}
