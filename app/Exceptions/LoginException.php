<?php 
namespace App\Exceptions;

/**
* 
*/
class LoginException extends \Exception
{	
	public function responseJson()
	{
		return \Response::json(
	        [
	            'error' => [
	                'message' => 'Not Authorized.', 
	                'status_code' => 401,
	                'error' => (!empty($this->message)) ? $this->message : trans('auth.failed')
	            ]
	        ], 
	    401);
	}
}