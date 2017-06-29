<?php

namespace Anand\Support;

abstract class ApiController extends Controller
{
	public function success($data, $code){
		return response()->json(['data' => $data], $code);
	}
	
	public function error($message, $code){
		return response()->json(['message' => $message], $code);
	}
}