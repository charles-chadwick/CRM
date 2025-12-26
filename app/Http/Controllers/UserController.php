<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('created_by')
            ->orderBy('created_at', 'desc')
            ->paginate()
            ->withQueryString();

        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return Inertia::render('Users/Form', [
            'roles' => array_map(fn($role) => $role->value, UserRole::cases()),
        ]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()
            ->route('users.edit', $user->id)
            ->with('message', 'User created successfully.')
            ->with('type', 'success');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/Form', [
            'user'  => $user,
            'roles' => array_map(fn($role) => $role->value, UserRole::cases()),
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function show(User $user)
    {
        $user->load(['created_by']);
        return Inertia::render('Users/Show', ["user" => $user]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('message', 'User updated successfully.')
            ->with('type', 'success');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent users from deleting themselves
        if ($user->id === auth()->id()) {
            return back()
                ->with('message', 'You cannot delete your own account.')
                ->with('type', 'error');

        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('message', 'User deleted successfully.')
            ->with('type', 'success');
    }
}
