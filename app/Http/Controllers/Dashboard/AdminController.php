<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\AdminStoreRequest;
use App\Http\Requests\Dashboard\Admin\AdminUpdateRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.index',
            [
                'admins' => Admin::with(
                    [
                        'roles' =>
                            [
                                'translations'
                            ],
                        'media'
                    ]
                )->select(['id', 'name', 'email', 'status'])->paginate()
            ]
        );
    }

    public function create()
    {
        return view('dashboard.admin.create',
            [
                'roles' => Role::select('id')->get()
            ]
        );
    }

    public function store(AdminStoreRequest $request)
    {
//        return  $request->validated('role_id');

        try {
            DB::transaction(function () use ($request) {
                $admin = Admin::create($request->validated());
                $admin->roles()->attach($request->validated('role_id'));
            });
        } catch (\Exception $exception) {
            dd($exception);
            return to_route('dashboard.admin.index')->with('msg', __('dashboard/alerts/store.fail', ['model' => __('dashboard/models.admin')]));
        }
        return to_route('dashboard.admins.index')->with('msg', __('dashboard/alerts/store.success', ['model' => __('dashboard/models.admin')]));
    }

    public function show(Admin $admin)
    {
    }

    public function edit(Admin $admin)
    {
        $admin_roles = $admin->roles()->pluck('id')->toArray();
        return view('dashboard.admin.edit',
            [
                'admin' => $admin,
                'roles' => Role::select(['id'])->get(),
                'admin_roles' => $admin_roles
            ]
        );
    }

    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        try {
            DB::transaction(function () use ($request, $admin) {
                if ($request->post('password')) {
                    $admin->update($request->validated());
                }
                $admin->update($request->except('password'));
                if ($request->validated('role_id')) {
                    $admin->roles()->sync($request->validated('role_id'));
                }
            });
        } catch (\Exception $exception) {
            dd($exception);
            return to_route('dashboard.admins.index')->with('msg', __('dashboard/alerts/update.fail', ['model' => __('dashboard/models.admin')]));
        }
        return to_route('dashboard.admins.index')->with('msg', __('dashboard/alerts/update.success', ['model' => __('dashboard/models.admin')]));
    }

    public function destroy(Admin $admin)
    {
        try {
            $admin->delete();
        } catch (\Exception $exception) {
            return to_route('dashboard.admins.index')->with('msg', __('dashboard/alerts/delete.fail', ['model' => __('dashboard/models.admin')]));
        }
        return to_route('dashboard.admins.index')->with('msg', __('dashboard/alerts/delete.success', ['model' => __('dashboard/models.admin')]));

    }

    public function resetAdminPassword(Request $request, Admin $admin)
    {
        try {
            DB::transaction(function () use ($request, $admin) {
                $admin->update([
                    'password' => Admin::DEFAULT_PASSWORD
                ]);
            });
        } catch (\Exception $exception) {
            return to_route('dashboard.admins.index')->with('msg', __('dashboard/alerts/update.fail', ['model' => __('dashboard/models.admin')]));
        }
        return to_route('dashboard.admins.index')->with('msg', __('dashboard/alerts/update.success', ['model' => __('dashboard/models.admin')]));
    }
}
