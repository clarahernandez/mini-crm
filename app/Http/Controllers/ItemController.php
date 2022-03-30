<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    protected ItemService $service;

    public function __construct(ItemService $service)
    {
        $this->service = $service;
    }

    public function show(Item $item)
    {
        return new ItemResource($item->load('properties'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $items = $this->service->getAll();

        return ItemResource::collection($items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return ItemResource
     */
    public function store(Request $request)
    {
        $item = $this->service->create($request->get('name'), $request->get('properties'));

        return new ItemResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Item $item
     * @return ItemResource
     */
    public function update(ItemRequest $request, Item $item)
    {
        $name = $request->input('name');
        $properties = $request->input('properties');

        $item = $this->service->update($item, $name, $properties);

        return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return response(["success" => true])->header('Content-Type', 'application/json');
    }
}
