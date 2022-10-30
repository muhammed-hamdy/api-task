<?php 

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;

class CrudRepository implements CrudRepositoryInterface 
{

	private $builder;

	public function __construct($builder)
	{
		$this->builder = $builder;
	}

	/**
	* @return created record 
	* @param $data array 
	*/
	public function create(array $data) {
		return $this->builder::create($data);
	}
	
	/**
	* @return record instance 
	* @param $id 
	*/
	public function getById($id) {
		return $this->builder::find($id);
	}

	/**
	* @return all records 
	* @param $pagination 
	*/
	public function getAll($pagination = null) 
	{
		return isset($pagination) ? $this->builder::paginate($pagination) : $this->builder::all();
	}

	/**
	* @return updated record 
	* @param $data array, $id 
	*/
	public function update($id, array $data)
	{
		$object =  $this->builder::find($id);
		if($object != null) {
			$object->update($data);
			return $object;
		}
		return false;
	}

	/**
	* delete record
	* @return boolean 
	* @param $id 
	*/
	public function delete($id)
	{
		try {
			$this->builder::destroy($id);
			return true;
		}
		catch (\Exception $e) {
			return false;
		}
	}

}