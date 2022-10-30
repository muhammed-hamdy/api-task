<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\UpdateRequest;
use Validator;
use Hash;
use File;
class UserController extends Controller
{
    private $repository;

    /**
    *   define repository 
    * @param UserRepository $repository
    */

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
    * list Users
    * @return users collection
    */
    public function index()
    {
        $users = $this->repository->getAll(6);
        return UserResource::collection($users);
    }

    /**
    * get singe user
    * @param $id
    * @return user resource
    */
    public function show($id)
    {
        $user = $this->repository->getById($id);
        if($user == null)
            return response()->json([], 404);

        return new UserResource($user);
    }

    /**
    * store user
    * @param $request
    * @return user resource
    */
    public function store(CreateRequest $request)
    {
        $data = $request->validated();
        if($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $data['avatar'] = $this->repository->uploadImage($file);
        }

        $data['password'] = Hash::make($data['password']);

        $user = $this->repository->create($data);

        return response()->json(new UserResource($user), 201);
    }

    /**
    * update user
    * @param $request
    * @param $id
    * @return user resource
    */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        if($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $this->repository->deleteImage($id);
            $data['avatar'] = $this->repository->uploadImage($file);
        }
        $user = $this->repository->update($id, $data);
        if(!$user)
            return response()->json(['error' => 'not found'], 404);

        return response()->json(new UserResource($user), 200);
    }

    /**
    * delete user
    * @param $id
    * @return response code 204
    */
    public function destroy($id)
    {
        if($this->repository->delete($id))
            return response()->json([], 204);

        return response()->json(['error' => 'something wrong'], 500);
    }
}
