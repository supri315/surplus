<?php
namespace App\Exceptions;

/**
*
*/
class ValidationException extends \Exception
{
	public function responseJson()
	{
		return \Response::json(
	        [
	            'error' => [
	                'message' => (json_decode($this->message,true)) ? array_values(json_decode($this->message,true))[0][0] : 'Error Found.',
					'status_code' => 406,
					'error_code' => $this->code,
	                'error' => json_decode($this->message,true)
	            ]
	        ],
	    406);
	}
}
