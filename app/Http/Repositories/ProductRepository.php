<?php
namespace App\Http\Repositories;

use Request;
use App\Models\Product;
use App\Exceptions\DataEmptyException;


class ProductRepository extends BaseRepository
{

    static $module = 'product';

    public function __construct()
    {
        $this->model = new Product;
    }

    public function getIndexData(array $sortableAndSearchableColumn)
    {
        $this->model::validate(Request::all(), [
            'per_page'  =>  ['numeric'],
        ]);

        $data = $this->model
            ->getAll()
            ->setSortableAndSearchableColumn($sortableAndSearchableColumn)
            ->search()
            ->sort()
            ->paginate(Request::get('per_page'));

        $data->sortableAndSearchableColumn = $sortableAndSearchableColumn;

        if($data->total() == 0) throw new DataEmptyException(trans('validation.attributes.dataNotExist',['attr' => self::$module]));

        return $data;
    }

    public function getIndexDataAll(array $sortableAndSearchableColumn)
    {
        $this->model::validate(Request::all(), [
            'per_page'  =>  ['numeric'],
        ]);

        $data = $this->model
            ->getDataAll()
            ->setSortableAndSearchableColumn($sortableAndSearchableColumn)
            ->search()
            ->sort()
            ->paginate(Request::get('per_page'));

        $data->sortableAndSearchableColumn = $sortableAndSearchableColumn;

        if($data->total() == 0) throw new DataEmptyException(trans('validation.attributes.dataNotExist',['attr' => self::$module]));

        return $data;
    }

    public function getSingleData($id)
    {
        $return = $this->model
                ->getAll()
                ->where($this->model->KeyPrimaryTable,$id)
                ->first();

        if($return === null) throw new DataEmptyException(trans('validation.attributes.dataNotExist',['attr' => self::$module]));

        return $return;
    }

    public function getSingleAllData($id)
    {
        $return = $this->model
                ->getDataAll()
                ->where($this->model->KeyPrimaryTable,$id)
                ->first();

        if($return === null) throw new DataEmptyException(trans('validation.attributes.dataNotExist',['attr' => self::$module]));

        return $return;
    }


}
