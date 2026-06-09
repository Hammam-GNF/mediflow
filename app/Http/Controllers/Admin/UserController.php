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
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        if ($request->ajax()) {

            $users = User::query()->with('roles');

            return DataTables::of($users)
                ->addIndexColumn()

                ->addColumn('role', function ($user) {
                    return $user->getRoleNames()->first() ?? 'N/A';
                })

                ->addColumn('action', function ($user) {
                    $buttons = '';

                    $buttons = $buttons . '<a href="' . route('admin.users.edit', $user) . '" class="inline-flex items-center px-3 py-1 bg-blue-600 rounded-md text-xs text-white">Edit</a> ';

                    $buttons = $buttons . '<a href="' . route('admin.users.change-password', $user) . '" class="inline-flex items-center px-3 py-1 bg-green-600 rounded-md text-xs text-white ms-1">Change Password</a> ';

                    if ($user->id !== Auth::id() && !($user->hasRole('admin') && User::whereHas('roles', function ($query) {
                        $query->where('name', 'admin');
                    })->count() === 1)) {
                        $buttons = $buttons . '<form action="' . route('admin.users.destroy', $user) . '" method="POST" class="inline-block ms-1" onsubmit="return confirm(\'Are you sure you want to delete this user?\');">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 rounded-md text-xs text-white">Delete</button>
                        </form>';
                    }

                    return $buttons;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.index');
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

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->event('created')
            ->withProperties(['name' => $user->name, 'email' => $user->email])
            ->log('User has been created.');

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

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->event('updated')
            ->withProperties(['name' => $user->name, 'email' => $user->email])
            ->log('User has been updated.');

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function changePassword(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.users.change-password', compact('user'));
    }

    public function updatePassword(UpdateUserPasswordRequest $request, User $user)
    {
        $this->authorize('update', $user);
        
        $user->update([
            'password' => Hash::make($request->validated()['password']),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->event('updated')
            ->withProperties(['name' => $user->name, 'email' => $user->email])
            ->log('Password has been updated.');

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

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->event('deleted')
            ->withProperties(['name' => $user->name, 'email' => $user->email])
            ->log('User has been deleted.');

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
