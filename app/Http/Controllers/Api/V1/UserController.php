<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('user-profiles', 'public');
        }

        if ($request->hasFile('signature')) {
            $validatedData['signature'] = $request->file('signature')->store('user-signatures', 'public');
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

        // Handle file uploads for update
        if ($request->hasFile('profile_picture')) {
            // Hapus file lama jika ada
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('user-profiles', 'public');
        }
        if ($request->hasFile('signature')) {
            if ($user->signature) {
                Storage::disk('public')->delete($user->signature);
            }
            $validatedData['signature'] = $request->file('signature')->store('user-signatures', 'public');
        }

        // Update password hanya jika diisi
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        // Update roles jika ada dalam request
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
