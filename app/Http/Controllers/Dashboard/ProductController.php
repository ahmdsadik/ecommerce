<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Product\ProductStoreRequest;
use App\Http\Requests\Dashboard\Product\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use App\Traits\InteractWithFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductController extends Controller
{
    use InteractWithFiles;

    public function __construct()
    {
        $this->middleware('permission:product_create')->only(['create', 'store']);
        $this->middleware('permission:product_update')->only(['edit', 'update']);
        $this->middleware('permission:product_delete')->only('destroy');
    }

    public function index()
    {
        return view('dashboard.product.index',
            [
                'products' => Product::withTrashed()->with(['media', 'category:id', 'store:id'])->paginate(5),
            ]
        );
    }

    public function create()
    {
        return view('dashboard.product.create',
            [
                'categories' => Category::active()->select('id')->get(),
                'stores' => Store::active()->select('id')->get(),
                'tags' => Tag::active()->select('id')->get(),
            ]
        );
    }

    public function store(ProductStoreRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $product = Product::create($request->validated());

                if ($request->validated('tag_id')) {
                    $product->tags()->attach($request->validated('tag_id'));
                }

                if ($request->file('logo')) {
                    $this->uploadImage($product, 'logo', 'logo');
                }
            });
        } catch (\Exception $e) {
            return to_route('dashboard.products.index')->with('msg', __('dashboard/alerts/store.fail', ['model' => __('dashboard/models.product')]));
        }
        return to_route('dashboard.products.index')->with('msg', __('dashboard/alerts/store.success', ['model' => __('dashboard/models.product')]));
    }

//    public function show(Product $product)
//    {
//    }

    public function edit(Product $product)
    {
        return view('dashboard.product.edit',
            [
                'tags' => Tag::select('id')->get(),
                'stores' => Store::select('id')->get(),
                'categories' => Category::select('id')->get(),
                'product' => $product->load(
                    [
                        'tags' => fn($query) => $query->select('id')->without('translations'),
                    ]
                ),
            ]
        );
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        try {
            DB::transaction(function () use ($request, $product) {

                $product->update($request->validated());

                $product->tags()->sync($request->validated('tag_id'));

                if ($request->file('logo')) {
                    $this->uploadImage($product, 'logo', 'logo');
                }
            });
        } catch (\Exception $e) {
            return to_route('dashboard.products.index')
                ->with('msg', __('dashboard/alerts/update.fail', ['model' => __('dashboard/models.product')]));
        }
        return to_route('dashboard.products.index')
            ->with('msg', __('dashboard/alerts/update.success', ['model' => __('dashboard/models.product')]));
    }

    public function destroy(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {
                $product->deletePreservingMedia();
            });
        } catch (\Exception $e) {
            return to_route('dashboard.products.index')->with('msg', __('dashboard/alerts/delete.fail', ['model' => __('dashboard/models.product')]));
        }
        return to_route('dashboard.products.index')->with('msg', __('dashboard/alerts/delete.success', ['model' => __('dashboard/models.product')]));
    }
}
