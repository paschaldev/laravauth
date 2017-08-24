<?php 

namespace PaschalDev\Laravauth\Facades;

use Illuminate\Support\Facades\Facade;

class Laravauth extends Facade
{	
	protected static function getFacadeAccessor()
	{
		return 'laravauth';
	}
}
