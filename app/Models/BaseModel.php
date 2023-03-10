<?php

namespace App\Models;

use Request;
use Validator;
use Auth;
use App\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	protected $guarded	= 	[];

	protected $soft_delete 	=	false;

	protected static $rules = [];

	public $sortableAndSearchableColumn = [];

	public $relationColumn = [];

	public $timestamps = true;

	const CREATED_AT = 'created_at';

	const UPDATED_AT = 'updated_at';

	public function scopeSetSortableAndSearchableColumn($query, $value=[])
	{
		$this->sortableAndSearchableColumn = $value;
	}

	/**
	 * set relationColumn function
	 *
	 * @param [type] $query
	 * @param array $value
	 * @return void
	 */
	public function scopeSetRelationColumn($query, $value=[])
	{
		$this->relationColumn = $value;

	}

	/**
	 * [FunctionName description]
	 * @param string $value [description]
	 */
	public function scopeSearch($query)
	{
		$request = Request::all();

		$search        = $this->sortableAndSearchableColumn;
		$search_column = $this->sortableAndSearchableColumn;

		if(array_key_exists('search', $this->sortableAndSearchableColumn)){
			$search = $this->sortableAndSearchableColumn['search'];
		}

		if(array_key_exists('search_column', $this->sortableAndSearchableColumn)){
			$search_column = $this->sortableAndSearchableColumn['search_column'];
		}

		$this->validate($request, [
            'search_column' => [
                'required_with:search_text',
                new \App\Rules\SortableAndSearchable($search_column)
            ],
            'search_text'   => ['required_with:search_column'],
        ]);

		$queryOld = $this->getSql($query);
		$thisClass = get_class($this);
		$model = new $thisClass;
		$model->sortableAndSearchableColumn = $this->sortableAndSearchableColumn;
		$query = $model->setTable(\DB::raw('('.$queryOld.') as myTable'))->whereRaw("1=1");

		if( !empty($request['search_column']) && !empty($request['search_text']) )
		{
			if( is_array($request['search_column']) )
			{
				foreach ($request['search_column'] as $arr_search_column => $value_search_column) {
					$query = $this->searchOperator($query, $request['search_column'][$arr_search_column], $request['search_text'][$arr_search_column], \Arr::get($request,'search_operator.'.$arr_search_column,'like'));
				}
			}
			else
			{
				$query = $this->searchOperator($query, $request['search_column'], $request['search_text'], \Arr::get($request,'search_operator','like'));
			}
		}

		if( !empty($request['search']) )
		{
			$query->where(function ($query) use ($search,$request) {
				foreach ($search as $key => $value) {
                	if($value)$query->orWhere(\DB::raw($value), 'like', '%'.$request['search'].'%');
				}
            });
		}

        return $query;

	}

	/**
	 * [searchOperator description]
	 * @param  [type] $query    [description]
	 * @param  [type] $column   [description]
	 * @param  [type] $text     [description]
	 * @param  string $operator [description]
	 * @return [type]           [description]
	 */
	public function searchOperator($query, $column, $text, $operator = 'like')
	{
		if( $operator == 'like' )
			$query->where(\DB::raw($this->sortableAndSearchableColumn[$column]),'like','%'.$text.'%');

		if( $operator == '=' )
			$query->where(\DB::raw($this->sortableAndSearchableColumn[$column]),'=',$text);

		if( $operator == '>=' )
			$query->where(\DB::raw($this->sortableAndSearchableColumn[$column]),'>=',$text);

		if( $operator == '<=' )
			$query->where(\DB::raw($this->sortableAndSearchableColumn[$column]),'<=',$text);

		if( $operator == '>' )
			$query->where(\DB::raw($this->sortableAndSearchableColumn[$column]),'>',$text);

		if( $operator == '<' )
			$query->where(\DB::raw($this->sortableAndSearchableColumn[$column]),'<',$text);

		return $query;
	}

	/**
	 * [getSql description]
	 * @param  [type] $model [description]
	 * @return [type]        [description]
	 */
	public function getSql($model)
	{
	    $replace = function ($sql, $bindings)
	    {
	        $needle = '?';
	        foreach ($bindings as $replace){
	            $pos = strpos($sql, $needle);
	            if ($pos !== false) {
	                if (gettype($replace) === "string") {
	                     $replace = ' "'.addslashes($replace).'" ';
	                }
	                $sql = substr_replace($sql, $replace, $pos, strlen($needle));
	            }
	        }
	        return $sql;
	    };
	    $sql = $replace($model->toSql(), $model->getBindings());

	    return $sql;
	}

	/**
	 * distinct function
	 *
	 * @param [type] $query
	 * @return void
	 */
	public function scopeDistinct($query,$data=null)
	{
		$request = Request::all();

		$this->validate($request, [
            'distinct_column' => [
                'filled',
                new \App\Rules\SortableAndSearchable($this->sortableAndSearchableColumn+$this->relationColumn),
            ],
		]);

		if(!empty($data)) {
			$request['distinct_column'] = $data;
		}

		if( !empty($request['distinct_column']) )
		{
			if( is_array($request['distinct_column']) )
			{
				$colsDistinct = implode(',',$request['distinct_column']);
				$query->select(\DB::raw('distinct '.$colsDistinct));
			}
			else
			{
				$query->select(\DB::raw('distinct '.$request['distinct_column']));
			}
		}
	}

	/**
	 * [FunctionName description]
	 * @param string $value [description]
	 */
	public function scopeSort($query)
	{
		$request = Request::all();

		$this->validate($request, [
            'sort_column' => [
                'required_with:sort_type',
                new \App\Rules\SortableAndSearchable($this->sortableAndSearchableColumn),
            ],
            'sort_type'   => [
            	'required_with:sort_column',
            	new \App\Rules\SortType(),
            ],
    	]);

		if( !empty($request['sort_column']) && !empty($request['sort_type']) )
		{
			if( is_array($request['sort_column']) )
			{
				foreach ($request['sort_column'] as $key_sort_column => $value_sort_column) {
					$query->orderBy($this->sortableAndSearchableColumn[$value_sort_column],$request['sort_type'][$key_sort_column]);
				}
			}
			else
			{
				$query->orderBy($this->sortableAndSearchableColumn[$request['sort_column']],$request['sort_type']);
			}
		}

	}

	/**
	 * [scopeUseIndex description]
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public function scopeIndex($query, $index_name, $type = FORCE)
	{
		$thisClass = get_class($this);
		$model = new $thisClass;
		return $query->from(\DB::raw(''.$model->getTable().' '.$type.' INDEX ('.$index_name.')'));
	}

	/**
	 * [validate description]
	 * @param  [type] $data     [description]
	 * @param  array  $rules    [description]
	 * @param  array  $messages [description]
	 * @return [type]           [description]
	 */
	public static function validate($data, $rules = [], $messages = [])
	{
		$rules = empty($rules) ? self::$rules : $rules;
		if(empty($rules)) return true;
		$validator = Validator::make($data, $rules, $messages);
		if($validator->fails()) throw new ValidationException($validator->errors());
		return true;
	}

	/**
	 * [scopeActive description]
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public function scopeActive($query)
	{
		return $query->whereNull($this->table.'.deleted_at');
	}

	/**
     * [scopeGetAll description]
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeGetAll($query)
    {
        return $query;
    }

	/**
     * [delete description]
     * @return [type] [description]
     */
    public function delete()
    {
		if (is_null($this->getKeyName())) {
            throw new Exception('No primary key defined on model.');
        }

        // If the model doesn't exist, there is nothing to delete so we'll just return
        // immediately and not do anything else. Otherwise, we will continue with a
        // deletion process on the model, firing the proper events, and so forth.
        if (! $this->exists) {
            return;
        }

        if ($this->fireModelEvent('deleting') === false) {
            return false;
        }

        // Here, we'll touch the owning models, verifying these timestamps get updated
        // for the models. This will allow any caching to get broken on the parents
        // by the timestamp. Then we will go ahead and delete the model instance.
        $this->touchOwners();

        if( $this->soft_delete )
        {
        	$actionBase = [
					static::DELETED_AT =>	date('Y-m-d H:i:s'),
					'deleted_by'       => 	Auth::user()->id,
					'deleted_from'     =>	$_SERVER['REMOTE_ADDR'],
        		];

	          if (\Illuminate\Support\Facades\Schema::hasColumn($this->table, 'status')) {
        		data_set($actionBase, 'status', 'X');
			  }

			  if (\Illuminate\Support\Facades\Schema::hasColumn($this->table, 'is_deleted_by_admin')) {
        		data_set($actionBase, 'is_deleted_by_admin', 1);
	          }

	          if (\Illuminate\Support\Facades\Schema::hasColumn($this->table, 'last_modified_sync')) {
        		data_set($actionBase, 'last_modified_sync', date('Y-m-d H:i:s'));
	          }

        	\DB::table($this->table)
        		->where($this->primaryKey, $this->id)
        		->update($actionBase);
        }
        else
        {
        	$this->performDeleteOnModel();
        }

        // Once the model has been deleted, we will fire off the deleted event so that
        // the developers may hook into post-delete operations. We will then return
        // a boolean true as the delete is presumably successful on the database.
        $this->fireModelEvent('deleted', false);

        return true;
    }

    /**
     * [getModifiedTimeAttribute description]
     * @param  [type] $date [description]
     * @return [type]       [description]
     */
    public function getModifiedTimeAttribute($date)
	{
	    return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', (is_null($date) ? '00-00-00 00:00:00' : $date) )->format('Y-m-d H:i:s');
	}

	/**
	 * check attribute function
	 *
	 * @param [type] $attr
	 * @return boolean
	 */
	public function hasAttribute($attr)
	{
		return array_key_exists($attr, $this->attributes);
	}
}
