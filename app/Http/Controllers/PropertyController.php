<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Services\PropertyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PropertyController extends Controller
{
    protected PropertyService $service;

    /**
     * @param PropertyService $service
     */
    public function __construct(PropertyService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $properties = $this->service->getAll();

        return PropertyResource::collection($properties);
    }
}
