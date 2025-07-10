<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreToolRequest;
use App\Http\Requests\UpdateToolRequest;
use App\Http\Resources\ToolResource;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tools = Tool::all();
        return ToolResource::collection($tools);
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
    public function store(StoreToolRequest $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = $validatedData['tool_code'] . '-' . Str::random(10) . '.jpg';
            $directory = 'tool-pictures';
            $path = $directory . '/' . $fileName;

            $processedImage = Image::read($file)
                ->scale(width: 1080)
                ->toJpeg(quality: 75);

            Storage::disk('public')->put($path, $processedImage);
            $validatedData['picture_path'] = $path;
        }

        $tool = Tool::create($validatedData);

        return (new ToolResource($tool))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tool $tool)
    {
        return new ToolResource($tool);
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
    public function update(UpdateToolRequest $request, Tool $tool)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('picture')) {
            if ($tool->picture_path) {
                Storage::disk('public')->delete($tool->picture_path);
            }

            $file = $request->file('picture');
            $fileName = $validatedData['tool_code'] . '-' . Str::random(10) . '.jpg';
            $directory = 'tool-pictures';
            $path = $directory . '/' . $fileName;

            $processedImage = Image::read($file)
                ->scale(width: 1080)
                ->toJpeg(quality: 75);

            Storage::disk('public')
                ->put($path, (string) $processedImage);

            $validatedData['picture_path'] = $path;
        }

        $tool->update($validatedData);
        return new ToolResource($tool);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tool $tool)
    {
        $this->authorize('delete', $tool);
        $tool->delete();
        return response()->noContent();
    }
}
