<?php

namespace Anutiger\Support;

use Illuminate\Support\ServiceProvider as Base;

abstract class ServiceProvider extends Base
{
	protected $defer = false;
}