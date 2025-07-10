<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::with('pic')->latest()->get();
        return VehicleResource::collection($vehicles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = $validatedData['license_plate'] . '-' . Str::random(10) . '.jpg';
            $directory = 'vehicle-docs';
            $path = $directory . '/' . $fileName;

            $processedImage = Image::read($file)
                ->scale(width: 1080)
                ->toJpeg(quality: 75);

            Storage::disk('public')->put($path, (string) $processedImage);
            $validatedData['docs_path'] = $path;
        }

        $vehicle = Vehicle::create($validatedData);

        return (new VehicleResource($vehicle->load('pic')))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return new VehicleResource($vehicle->load('pic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('document')) {
            if ($vehicle->docs_path) {
                Storage::disk('public')->delete($vehicle->docs_path);
            }

            $file = $request->file('document');
            $fileName = $validatedData['license_plate'] . '-' . Str::random(10) . '.jpg';
            $directory = 'vehicle-docs';
            $path = $directory . '/' . $fileName;

            $processedImage = Image::read($file)
                ->scale(width: 1080)
                ->toJpeg(quality: 75);

            Storage::disk('public')
                ->put($path, (string) $processedImage);
            
            $validatedData['docs_path'] = $path;
        }

        $vehicle->update($request->validated());
        return new VehicleResource($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);
        $vehicle->delete();
        return response()->noContent();
    }
}
