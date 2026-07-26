<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserPasswordRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        if ($request->ajax()) {

            $users = User::query()->with('roles');
            if ($request->filled('role')) {
                $users->role($request->role);
            }

            return DataTables::of($users)
                ->addIndexColumn()

                ->addColumn('role', function ($user) {

                    $role = $user->roles->first()?->name;

                    return match ($role) {

                        'admin' => '
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                Admin
                            </span>
                        ',

                        'doctor' => '
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Doctor
                            </span>
                        ',

                        default => '
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                -
                            </span>
                        ',
                    };

                })

                ->addColumn('action', function ($user) {

                    $buttons = '
                        <div class="flex items-center gap-2 whitespace-nowrap">
                    ';

                    $buttons .= '
                        <a
                            href="'.route('admin.users.edit', $user).'"
                            class="
                                inline-flex
                                items-center

                                rounded-lg

                                bg-blue-50
                                px-3
                                py-2

                                text-xs
                                font-semibold
                                text-blue-700

                                transition

                                hover:bg-blue-100
                            "
                        >
                            Edit
                        </a>
                    ';

                    $buttons .= '
                        <a
                            href="'.route('admin.users.change-password', $user).'"
                            class="
                                inline-flex
                                items-center

                                rounded-lg

                                bg-emerald-50
                                px-3
                                py-2

                                text-xs
                                font-semibold
                                text-emerald-700

                                transition

                                hover:bg-emerald-100
                            "
                        >
                            Password
                        </a>
                    ';

                    if (Auth::id() !== $user->id) {

                        $buttons .= '
                            <button
                                type="button"
                                data-url="'.route('admin.users.destroy', $user).'"

                                class="
                                    delete-user-btn

                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-red-50
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-red-700

                                    transition

                                    hover:bg-red-100
                                "
                            >
                                Delete
                            </button>
                        ';
                    }

                    $buttons .= '</div>';

                    return $buttons;

                })

                ->rawColumns(['role', 'action'])
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

    public function export()
    {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    public function trash(Request $request)
    {
        $this->authorize('viewAny', User::class);

        if ($request->ajax()) {
            $users = User::onlyTrashed()->with('roles')->latest();

            return DataTables::of($users)
                ->addIndexColumn()

                ->addColumn('role', function ($user) {
                    return $user->roles->first()?->name ?? 'N/A';
                })

                ->editColumn('deleted_at', function ($user) {
                    return $user->deleted_at->format('Y-m-d H:i:s');
                })

                ->addColumn('action', function ($user) {

                    $buttons = '
                        <div class="flex items-center gap-2 whitespace-nowrap">
                    ';

                    $buttons .= '
                        <button
                            type="button"
                            data-url="'.route('admin.users.restore', $user).'"

                            class="
                                restore-user-btn

                                inline-flex
                                items-center

                                rounded-lg

                                bg-emerald-50
                                px-3
                                py-2

                                text-xs
                                font-semibold
                                text-emerald-700

                                transition

                                hover:bg-emerald-100
                            "
                        >
                            Restore
                        </button>
                    ';

                    $buttons .= '
                        <button
                            type="button"
                            data-url="'.route('admin.users.force-delete', $user).'"

                            class="
                                force-delete-btn

                                inline-flex
                                items-center

                                rounded-lg

                                bg-red-50
                                px-3
                                py-2

                                text-xs
                                font-semibold
                                text-red-700

                                transition

                                hover:bg-red-100
                            "
                        >
                            Force Delete
                        </button>
                    ';

                    $buttons .= '</div>';

                    return $buttons;

                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.trash');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->event('restored')
            ->log('User has been restored.');

        return back()->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->event('force deleted')
            ->log('User has been force deleted.');

        $user->forceDelete();

        return back()->with('success', 'User force deleted successfully.');
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
