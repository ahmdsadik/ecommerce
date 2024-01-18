<?php

namespace App\Http\Controllers\API;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $products = Product::filter($request->query())->with(['media', 'store:id', 'category:id', 'tags:id'])->paginate(5);
        } catch (\Exception) {
            return $this->errorResponse(__('dashboard/alerts/index.fail'));
        }
        return $this->successResponse(ProductResource::collection($products));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            app()->getLocale() . '.name' => ['required', 'string', 'unique:product_translations,name'],
            'slug' => ['unique:products,slug'],
            'category_id' => ['required', 'exists:categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'tag_id' => ['nullable', 'array'],
            'tag_id.*' => ['exists:tags,id'],
            'status' => ['required', Rule::in(ProductStatus::cases())],
            'price' => ['required', 'numeric'],
            'compare_price' => ['nullable', 'numeric', 'gt:price'],
            'logo' => ['nullable', 'image'],
        ], attributes: Product::attributesNames()
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        try {
            DB::beginTransaction();
            $product = Product::create($validator->validated());

            if ($request->has('tag_id')) {
                $product->tags()->attach($request->post('tag_id'));
                $product->load('tags');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('dashboard/alerts/store.fail', ['model' => __('dashboard/models.product')]));
        }
        return new ProductResource($product);
    }

    public function show(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(__('dashboard/alerts/show.not_found_fail', ['model' => __('dashboard/models.product')]));
        } catch (\Exception $e) {
            return $this->errorResponse(__('dashboard/alerts/show.fail', ['model' => __('dashboard/models.product')]));
        }
        return $this->successResponse(new ProductResource($product->load('tags')));
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(__('dashboard/alerts/show.not_found_fail', ['model' => __('dashboard/models.product')]));
        } catch (\Exception $e) {
            return $this->errorResponse(__('dashboard/alerts/show.fail', ['model' => __('dashboard/models.product')]));
        }

        $validator = Validator::make($request->all(), [
            app()->getLocale() . '.name' => ['required', 'string', Rule::unique('product_translations', 'name')->ignore($product->id, 'product_id')],
            'slug' => ['unique:products,slug,' . $product->id],
            'category_id' => ['required', 'exists:categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'tag_id' => ['nullable', 'array'],
            'tag_id.*' => ['exists:tags,id'],
            'status' => ['required', Rule::in(ProductStatus::cases())],
            'price' => ['required', 'numeric'],
            'compare_price' => ['nullable', 'numeric', 'gt:price'],
            'logo' => ['nullable', 'image'],
        ], attributes: Product::attributesNames()
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        try {
            DB::beginTransaction();
            $product->update($validator->validated());

            if ($request->has('tag_id')) {
                $product->tags()->sync($request->post('tag_id'));
                $product->load('tags');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('dashboard/alerts/update.fail', ['model' => __('dashboard/models.product')]));
        }
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $product = Product::findOrFail($id);
                $product->deleteQuietly();
            });
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(__('dashboard/alerts/show.not_found_fail', ['model' => __('dashboard/models.product')]));
        } catch (\Exception $e) {
            return $this->errorResponse(__('dashboard/alerts/delete.fail', ['model' => __('dashboard/models.product')]));
        }
        return $this->successResponse(__('dashboard/alerts/delete.success', ['model' => __('dashboard/models.product')]));
    }
}
