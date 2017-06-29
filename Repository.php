<?php

namespace AP\Support;

use Illuminate\Support\Arr;

abstract class Repository
{
	public function hasKey($key, $items = null)
	{
		if(!$items && !property_exists($this, 'config')){
			return null;
		}
		
		return Arr::has($items?:$this->config, $key);
	}
	
	public function getKey($key, $items = null)
	{
		if(!$items && !property_exists($this, 'config')){
			return null;
		}
		
		return Arr::get($items?:$this->config, $key);
	}
	
	public function setKey($key, $value, $items = null)
	{
		if(!$items && !property_exists($this, 'config')){
			return null;
		}
		
		return Arr::set($items?:$this->config, $key, $value);
	}
}