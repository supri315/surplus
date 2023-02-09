<?php
namespace App\Http\Services;

use Request;
use Illuminate\Support\Arr;
use App\Models\Category;
use App\Http\Repositories\CategoryRepository;

class CategoryService extends BaseService
{

    public function __construct()
    {
        $this->model = new Category;
        $this->repository = new CategoryRepository;
    }

    public function create($data)
    {
      
        $this->model->validate($data, [
            'name'=>'required|unique:categories',
            'enable' => 'required|boolean',                
         ]);

        $input = Arr::only($data, [
            "name",
            "enable"
        ]);

        $result = $this->model->create($input);

        return $this->repository->getSingleData($result->id);
     
    }

    public function update($id,$data)
    {
        $checkData = $this->repository->getSingleData($id);

        $this->model->validate($data, [
            'name'=>'required',\Illuminate\Validation\Rule::unique('users')->ignore($id),
            'enable' => 'required|boolean',                
         ]);

        $input = Arr::only($data, [
            "name",
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
