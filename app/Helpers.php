<?php


	function queryFormatDate($column, $asColumn = null, $format = '"%d %b %Y"')
	{
		if( empty($asColumn) ) {
			return \DB::raw('DATE_FORMAT('.$column.', '.$format.')');
		}
		return \DB::raw('DATE_FORMAT('.$column.', '.$format.') as '.$asColumn);
	}

	function queryFormatTime($column, $asColumn = null, $format = '"%H:%i"')
	{
		if( empty($asColumn) ) {
			return \DB::raw('DATE_FORMAT('.$column.', '.$format.')');
		}
		return \DB::raw('DATE_FORMAT('.$column.', '.$format.') as '.$asColumn);
	}

	function getDateParse($date,$parse){
		return Carbon\Carbon::createFromFormat('Y-m-d', $date)->modify($parse)->format('Y-m-d');
	}

	function getDateDiff($date_1,$date_2){
		$date_1 = Carbon\Carbon::createFromFormat('Y-m-d', $date_1);
	    $date_2 = Carbon\Carbon::createFromFormat('Y-m-d', $date_2);

	    $diff = $date_1->diffInDays($date_2);
	    return $diff;
	}



	/**
	 * [paginateWithoutQuery description]
	 * @param  [type]  $data [description]
	 * @param  integer $page [description]
	 * @return [type]        [description]
	 */
   	function paginateWithoutQuery($data = [], $searchable = null, $page = 15)
   	{
   		if(!empty(\Request::get('per_page'))){
   			$page = \Request::get('per_page');
   		}

   		if(count($data) == 0) throw new \App\Exceptions\DataEmptyException();

    	 // Get current page form url e.x. &page=1
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();

		$validatorSort = \Validator::make(\Request::all(), [
            'sort_column' => [
                'required_with:sort_type',
                new \App\Rules\SortableAndSearchable($searchable),
            ],
            'sort_type'   => [
            	'required_with:sort_column',
            	new \App\Rules\SortType(),
            ],
        ]);

		if($validatorSort->fails()) throw new \App\Exceptions\ValidationException($validatorSort->errors());

        // Create a new Laravel collection from the array data
        if(!empty(\Request::get('sort_column')) && !empty(\Request::get('sort_type'))){
			$column = \Request::get('sort_column');
			$type   = \Request::get('sort_type');
			if( is_array($column))
			{
				$itemCollection = collect($data);
				foreach ($column as $key_sort_column => $value_sort_column) {
		        	if($type == 'asc'){
		        		$itemCollection = $itemCollection->sortBy($searchable[$value_sort_column]);
		        	}

		        	if($type == 'desc'){
		        		$itemCollection = $itemCollection->sortByDesc($searchable[$value_sort_column]);
		        	}

				}

			}else{
	        	if($type == 'asc'){
	        		$itemCollection = collect($data)->sortBy(\Request::get('sort_column'));
	        	}

	        	if($type == 'desc'){
	        		$itemCollection = collect($data)->sortByDesc(\Request::get('sort_column'));
	        	}
			}
   		}else{
        	$itemCollection = collect($data);
   		}


        // Define how many items we want to be visible in each page
        $perPage = $page;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems = new \Illuminate\Pagination\LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath(Request::url());

        $response = [
			'data'  => array_values($paginatedItems->items()),
			'links' => [
						'first' => $paginatedItems->url(1),
						'last'  => $paginatedItems->url($paginatedItems->lastPage()),
						'prev'  => $paginatedItems->previousPageUrl(),
						'next'  => $paginatedItems->nextPageUrl(),
					],
 		];
        // return $searchable;
 		if(!empty($searchable)){
 			$response = $response +  array('sortableAndSearchableColumn' => $searchable);
 		}

		 return $response;
    }

