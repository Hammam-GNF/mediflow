<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserPasswordRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $search = $request->search;
        $role = $request->role;

        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, function ($query) use ($role) {
                $query->role($role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'role'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        
        $data = $request->safe()->except('role');

        $user = User::create($data);

        $user->assignRole($request->role);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->safe()->except('role');

        $user->update($data);

        $user->syncRoles($request->role);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function changePassword(User $user)
    {
        return view('admin.users.change-password', compact('user'));
    }

    public function updatePassword(UpdateUserPasswordRequest $request, User $user)
    {
        $user->update([
            'password' => Hash::make($request->validated()['password']),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Password updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->hasRole('admin') && User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->count() === 1) {
            return back()->with('error', 'You cannot delete the last admin account.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
