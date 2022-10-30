<?php 

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Repositories\CrudRepository;
use App\Models\User;
use File;

class UserRepository extends CrudRepository 
{

	public function __construct()
	{
		parent::__construct(User::class);
	}

	public function uploadImage($file)
	{
		$destinationPath = 'uploads';
        $file_name = time() . '_' . str_replace(' ', '',$file->getClientOriginalName());
        $file->move($destinationPath, $file_name);
        return $file_name;
	}

	public function deleteImage($user_id)
	{
		$user = $this->getById($user_id);
		if($user != null && $user->avatar != null) {
			if(File::exists(public_path() . '/uploads/' . $user->avatar))
				File::delete(public_path() . '/uploads/' . $user->avatar);
		}
	}
}