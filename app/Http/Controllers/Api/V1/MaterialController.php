<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::with('supplier')->get();
        return MaterialResource::collection($materials);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage. v1
     */
    // public function store(StoreMaterialRequest $request)
    // {
    //     $material = Material::create($request->validate());

    //     return (new MaterialResource($material->load('supplier')))
    //         ->response()
    //         ->setStatusCode(Response::HTTP_CREATED);
    // }

    /**
     * Store a newly created resource in storage with Intervention. v2
     */
    public function store(StoreMaterialRequest $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = $validatedData['sku'] . '-' . Str::random(10) . '.jpg';
            $directory = 'material-pictures';
            $path = $directory . '/' . $fileName;

            $processedImage = Image::read($file)
                ->scale(width: 1080)
                ->toJpeg(quality: 75);

            Storage::disk('public')->put($path, $processedImage);
            $validatedData['picture_path'] = $path;
        }

        $material = Material::create($validatedData);

        return (new MaterialResource($material->load('supplier')))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        return new MaterialResource($material->load('supplier'));
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
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $material->update($request->validated());

        return new MaterialResource($material->load('supplier'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $this->authorize('delete', $material);

        $material->delete();

        return response()->noContent();
    }
}
