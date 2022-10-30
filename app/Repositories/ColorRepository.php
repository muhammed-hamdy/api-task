<?php 

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Repositories\CrudRepository;
use App\Models\Color;

class ColorRepository extends CrudRepository 
{

	public function __construct()
	{
		parent::__construct(Color::class);
	}

}