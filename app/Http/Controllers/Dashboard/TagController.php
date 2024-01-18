<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Tag\TagStoreRequest;
use App\Http\Requests\Dashboard\Tag\TagUpdateRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('RemoveEmptyOrNull')->only('store', 'update');
    }

    public function index()
    {
        return view('dashboard.tag.index',
            [
                'tags' => Tag::paginate(10)
            ]
        );
    }

    public function create()
    {
        return view('dashboard.tag.create');
    }

    public function store(TagStoreRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Tag::create($request->validated());
            });
        } catch (\Exception $e) {
            return to_route('dashboard.tags.index')->with('msg', __('dashboard/alerts/store.fail', ['model' => __('dashboard/models.tag')]));
        }
        return to_route('dashboard.tags.index')->with('msg', __('dashboard/alerts/store.success', ['model' => __('dashboard/models.tag')]));
    }

//    public function show(Tag $tag)
//    {
//    }

    public function edit(Tag $tag)
    {
        return view('dashboard.tag.edit', compact('tag'));
    }

    public function update(TagUpdateRequest $request, Tag $tag)
    {
        try {
            DB::transaction(function () use ($request, $tag) {
                $tag->update($request->validated());
            });
        } catch (\Exception $e) {
            return to_route('dashboard.tags.index')->with('msg', __('dashboard/alerts/update.fail', ['model' => __('dashboard/models.tag')]));
        }
        return to_route('dashboard.tags.index')->with('msg', __('dashboard/alerts/update.success', ['model' => __('dashboard/models.tag')]));
    }

    public function destroy(Tag $tag)
    {
        try {
            DB::transaction(function () use ($tag) {
                $tag->delete();
            });
        } catch (\Exception $e) {
            return to_route('dashboard.tags.index')->with('msg', __('dashboard/alerts/delete.fail', ['model' => __('dashboard/models.tag')]));
        }
        return to_route('dashboard.tags.index')->with('msg', __('dashboard/alerts/delete.success', ['model' => __('dashboard/models.tag')]));
    }
}
