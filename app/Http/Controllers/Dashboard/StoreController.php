<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Store\StoreStoreRequest;
use App\Http\Requests\Dashboard\Store\StoreUpdateRequest;
use App\Models\Store;
use App\Traits\InteractWithFiles;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    use InteractWithFiles;

    public function index()
    {
        return view('dashboard.store.index',
            [
                'stores' => Store::with('media')->paginate(5),

            ]
        );
    }

    public function create()
    {
        return view('dashboard.store.create');
    }

    public function store(StoreStoreRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $store = Store::create($request->validated());

                if ($request->file('logo')) {
                    $this->uploadImage($store, 'logo', 'logo');
                }

            });
        } catch (\Exception $e) {
            return to_route('dashboard.stores.index')->with('msg', __('dashboard/alerts/store.fail', ['model' => __('dashboard/models.store')]));
        }
        return to_route('dashboard.stores.index')->with('msg', __('dashboard/alerts/store.success', ['model' => __('dashboard/models.store')]));
    }

//    public function show(Store $store)
//    {
//    }

    public function edit(Store $store)
    {
        return view('dashboard.store.edit',
            [
                'store' => $store,
            ]
        );
    }

    public function update(StoreUpdateRequest $request, Store $store)
    {
        try {
            DB::transaction(function () use ($request, $store) {
                $store->update($request->validated());

                if ($request->file('logo')) {
                    $this->uploadImage($store, 'logo', 'logo');
                }
            });
        } catch (\Exception $e) {
            return to_route('dashboard.stores.index')->with('msg', __('dashboard/alerts/update.fail', ['model' => __('dashboard/models.store')]));
        }
        return to_route('dashboard.stores.index')->with('msg', __('dashboard/alerts/update.success', ['model' => __('dashboard/models.store')]));
    }

    public function destroy(Store $store)
    {
        try {
            DB::transaction(function () use ($store) {
                $store->deletePreservingMedia();
            });
        } catch (\Exception $e) {
            return to_route('dashboard.stores.index')->with('msg', __('dashboard/alerts/delete.fail', ['model' => __('dashboard/models.store')]));
        }
        return to_route('dashboard.stores.index')->with('msg', __('dashboard/alerts/delete.success', ['model' => __('dashboard/models.store')]));
    }
}
