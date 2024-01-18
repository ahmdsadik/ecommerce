<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\CategoryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\CategoryStoreRequest;
use App\Http\Requests\Dashboard\Category\CategoryUpdateRequest;
use App\Http\Requests\Dashboard\Store\StoreStoreRequest;
use App\Models\Category;
use App\Traits\InteractWithFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
//    use InteractWithFiles;

    public function index()
    {
        return view('dashboard.category.index',
            [
                'categories' => Category::with(['media', 'parent'])->paginate(5)
            ]
        );
    }

    public function create()
    {
        return view('dashboard.category.create',
            [
                'categories' => Category::select('id')->get()
            ]
        );
    }

    public function store(StoreStoreRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $category = Category::create($request->validated());

                if ($request->file('logo')) {
                    $category->uploadImage('logo', 'logo');
                }
            });
        } catch (\Exception $e) {
            return to_route('dashboard.categories.index')
                ->with('msg', __('dashboard/alerts/store.fail', ['model' => __('dashboard/models.category')]));
        }
        return to_route('dashboard.categories.index')
            ->with('msg', __('dashboard/alerts/store.success', ['model' => __('dashboard/models.category')]));
    }

    public function show(Category $category)
    {
    }

    public function edit(Category $category)
    {
        return view('dashboard.category.edit',
            [
                'category' => $category,
                'categories' => Category::whereNot('id', $category->id)->select('id')->get(),
            ]
        );
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        try {
            DB::transaction(function () use ($request, $category) {
                $category->update($request->validated());

                if ($request->file('logo')) {
                    $category->uploadImage('logo', 'logo');
                }
            });
        } catch (\Exception $e) {
            return to_route('dashboard.categories.index')
                ->with('msg', __('dashboard/alerts/update.fail', ['model' => __('dashboard/models.category')]));
        }
        return to_route('dashboard.categories.index')
            ->with('msg', __('dashboard/alerts/update.success', ['model' => __('dashboard/models.category')]));
    }

    public function destroy(Category $category)
    {
        try {
            DB::transaction(function () use ($category) {
                $category->delete();
            });
        } catch (\Exception $e) {
            return to_route('dashboard.categories.index')
                ->with('msg', __('dashboard/alerts/delete.fail', ['model' => __('dashboard/models.category')]));
        }
        return to_route('dashboard.categories.index')
            ->with('msg', __('dashboard/alerts/delete.success', ['model' => __('dashboard/models.category')]));
    }
}
