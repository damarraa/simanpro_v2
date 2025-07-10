<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return UserResource::collection($users);
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
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = 'profile-' . Str::random(10) . '.jpg';
            $path = 'user-profiles/' . $fileName;

            $processedImage = Image::read($file)
                ->scale(width: 500)
                ->toJpeg(quality: 75);

            Storage::disk('public')->put($path, (string) $processedImage);
            $validatedData['profile_picture'] = $path;
        }

        if ($request->filled('signature')) {
            $base64_image = $request->input('signature');
            $fileName = 'signature-' . Str::random(10) . '.png';
            $path = 'user-signatures/' . $fileName;

            $processedImage = Image::read($base64_image)
                ->toPng();

            Storage::disk('public')->put($path, (string) $processedImage);
            $validatedData['signature'] = $path;
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        $user->syncRoles($validatedData['roles']);

        return (new UserResource($user->load('roles')))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user->load('roles'));
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
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_pictures);
            }

            $file = $request->file('profile_picture');
            $fileName = 'profile-' . Str::random(10) . '.jpg';
            $path = 'user-profiles/' . $fileName;

            $processedImage = Image::read($file)
                ->scale(width: 500)
                ->toJpeg(quality: 75);

            Storage::disk('public')->put($path, (string) $processedImage);

            $validatedData['profile_picture'] = $path;
        }

        if ($request->filled('signature')) {
            if (Str::startsWith($request->input('signature'), 'data:image')) {
                if ($user->signature) {
                    Storage::disk('public')->delete($user->signature);
                }

                $base64_image = $request->input('signature');
                $fileName = 'signature-' . Str::random(10) . '.png';
                $path = 'user-signatures/' . $fileName;

                $processedImage = Image::read($base64_image)
                    ->toPng();

                Storage::disk('public')->put($path, (string) $processedImage);
                $validatedData['signature'] = $path;
            }
        }

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        $user->update($validatedData);
        if (isset($validatedData['roles'])) {
            $user->syncRoles($validatedData['roles']);
        }

        return new UserResource($user->load('roles'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->noContent();
    }
}
