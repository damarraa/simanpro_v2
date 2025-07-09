<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockMovementRequest;
use App\Http\Resources\StockMovementResource;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = StockMovement::with(['material', 'warehouse', 'user'])->latest()->get();
        return StockMovementResource::collection($movements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockMovementRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();

        $movement = StockMovement::create($validatedData);

        return new StockMovementResource($movement);
    }
}
