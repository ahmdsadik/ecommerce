<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Role\RoleStoreRequest;
use App\Http\Requests\Dashboard\Role\RoleUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role_create')->only(['create', 'store']);
        $this->middleware('permission:role_update')->only(['edit', 'update']);
        $this->middleware('permission:role_delete')->only('destroy');
    }

    public function index()
    {
        return view('dashboard.role.index',
            [
                'roles' => Role::with('translations')->select('id')->paginate()
            ]
        );
    }

    public function create()
    {
        return view('dashboard.role.create',
            [
                'permissions' => Permission::with('translations')->select('id')->get()
            ]
        );
    }

    public function store(RoleStoreRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $role = Role::create($request->validated());
                if ($request->has('permissions')) {
                    $role->permissions()->sync($request->validated('permissions'));
                }
            });
        } catch (\Exception $exception) {
            return to_route('dashboard.roles.index')->with('msg', __('dashboard/alerts/store.fail', ['model' => __('dashboard/models.role')]));
        }

        return to_route('dashboard.roles.index')->with('msg', __('dashboard/alerts/store.success', ['model' => __('dashboard/models.role')]));
    }

    public function edit(Role $role)
    {
        $role_permissions = $role->permissions->pluck('id')->toArray();

        return view('dashboard.role.edit',
            [
                'role' => $role,
                'permissions' => Permission::with('translations')->select('id')->get(),
                'role_permissions' => $role_permissions
            ]
        );
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        try {
            DB::transaction(function () use ($request, $role) {
                $role->update($request->validated());
                if ($request->has('permissions')) {
                    $role->syncPermissions($request->validated('permissions'));
                }
            });
        } catch (\Exception $exception) {
            return to_route('dashboard.roles.index')->with('msg', __('dashboard/alerts/update.fail', ['model' => __('dashboard/models.role')]));
        }

        return to_route('dashboard.roles.index')->with('msg', __('dashboard/alerts/update.success', ['model' => __('dashboard/models.role')]));
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();
        } catch (\Exception $exception) {
            return to_route('dashboard.roles.index')->with('msg', __('dashboard/alerts/delete.fail', ['model' => __('dashboard/models.role')]));
        }

        return to_route('dashboard.roles.index')->with('msg', __('dashboard/alerts/delete.success', ['model' => __('dashboard/models.role')]));
    }
}
