<?php
namespace App\Http\Services;

use Request;
use Illuminate\Support\Arr;
use App\Models\Image;
use App\Http\Repositories\ImageRepository;

class ImageService extends BaseService
{

    public function __construct()
    {
        $this->model = new Image;
        $this->repository = new ImageRepository;
    }

    public function create($data)
    {
      
        $this->model->validate($data, [
            'name'=>'required|unique:images',
            'file'=>'required',
            'enable' => 'required|boolean',                
         ]);

        $input = Arr::only($data, [
            "name",
            "file",
            "enable"
        ]);

        $result = $this->model->create($input);

        if(!empty($input['file'])) 
        {
            $file = $input['file'];
            $folder = '/upload/image';
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $filePath = public_path() .''.$folder;
            $file->move($filePath, $filename);
            $result->update([
                "file"     =>  env('APP_URL').''.$folder.''.$filename
            ]);
            
        }

        return $this->repository->getSingleData($result->id);
     
    }

    public function update($id,$data)
    {
        $checkData = $this->repository->getSingleData($id);

        $this->model->validate($data, [
            'name'=>'required',\Illuminate\Validation\Rule::unique('images')->ignore($id),
            'file'=>'required',
            'enable' => 'required|boolean',                
         ]);

        $input = Arr::only($data, [
            "name",
            "file",
            "enable"
        ]);

        $result = $checkData->update($input);

        if(!empty($input['file'])) 
        {
            $file = $input['file'];
            $folder = '/upload/image';
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $filePath = public_path() .''.$folder;
            $file->move($filePath, $filename);
            $checkData->update([
                "file"     =>  env('APP_URL').''.$folder.''.$filename
            ]);
            
        }

        return $this->repository->getSingleData($checkData->id);
     
    }

    public function delete($id)
    {
        $checkData = $this->repository->getSingleData($id);

        $checkData->delete();

    }
}
