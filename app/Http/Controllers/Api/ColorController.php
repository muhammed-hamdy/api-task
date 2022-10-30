<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ColorRepository;
use App\Http\Resources\ColorResource;
use App\Http\Requests\Colors\CreateRequest;
use App\Http\Requests\Colors\UpdateRequest;
use Validator;

class ColorController extends Controller
{
    private $repository;

    /**
    *   define repository 
    * @param ColorRepository $repository
    */

    public function __construct(ColorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
    * list colors
    * @return colors collection
    */
    public function index()
    {
        $colors = $this->repository->getAll(6);
        return ColorResource::collection($colors);
    }

    /**
    * get singe color
    * @param $id
    * @return color resource
    */
    public function show($id)
    {
        $color = $this->repository->getById($id);
        if($color == null)
            return response()->json([], 404);

        return new ColorResource($color);
    }

    /**
    * store color
    * @param $request
    * @return color resource
    */
    public function store(CreateRequest $request)
    {
        $data = $request->validated();
        $color = $this->repository->create($data);

        return response()->json(new ColorResource($color), 201);
    }

    /**
    * update color
    * @param $request
    * @param $id
    * @return color resource
    */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();

        $color = $this->repository->update($id, $data);

        if(!$color)
            return response()->json(['error' => 'not found'], 404);

        return response()->json(new ColorResource($color), 200);
    }

    /**
    * delete color
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
