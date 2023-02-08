<?php
namespace App\Exceptions;

/**
*
*/
class AuthenticationException extends \Exception
{
	public function responseJson()
	{
		return \Response::json(
	        [
	            'error' => [
	                'message' => (!empty($this->message)) ? $this->message : trans('auth.failed'),
					'status_code' => 401,
					'error_code' => $this->code,
	                'error' => [
	                	[
	                		(!empty($this->message)) ? $this->message : trans('auth.failed')
	                	]
	                ]
	            ]
	        ],
	    401);
	}
}
