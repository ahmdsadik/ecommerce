<?php

namespace App\Http\Controllers\API;

use App\Enums\TagStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Tag\TagStoreRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $tags = Tag::filter($request->query())->paginate(5);
        } catch (\Exception) {
            return $this->errorResponse(__('dashboard/alerts/index.fail'));
        }
        return $this->successResponse(TagResource::collection($tags));
    }

    public function store(TagStoreRequest $request)
    {
        $validator = Validator::make($request->all(), [
            app()->getLocale() . '.name' => ['required', 'string', 'unique:product_translations,name'],
            'slug' => ['required','unique:products,slug'],
        ], attributes: Tag::attributesNames()
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        try {
            DB::beginTransaction();
            $tag = Tag::create($validator->validated());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('dashboard/alerts/store.fail', ['model' => __('dashboard/models.tag')]));
        }
        return new TagResource($tag);
    }

    public function show(Request $request, $id)
    {
        try {
            $tag = Tag::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(__('dashboard/alerts/show.not_found_fail', ['model' => __('dashboard/models.tag')]));
        } catch (\Exception $e) {
            return $this->errorResponse(__('dashboard/alerts/show.fail', ['model' => __('dashboard/models.tag')]));
        }
        return $this->successResponse(TagResource::make($tag));
    }

    public function update(Request $request, $id)
    {
        try {
            $tag = Tag::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(__('dashboard/alerts/show.not_found_fail', ['model' => __('dashboard/models.tag')]));
        } catch (\Exception $e) {
            return $this->errorResponse(__('dashboard/alerts/show.fail', ['model' => __('dashboard/models.tag')]));
        }

        $validator = Validator::make($request->all(), [
            app()->getLocale() . '.name' => ['required', 'string', Rule::unique('tag_translations', 'name')->ignore($tag->id, 'tag_id')],
            'slug' => ['unique:products,slug,' . $tag->id],
        ], attributes: Tag::attributesNames()
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        try {
            DB::beginTransaction();
            $tag->update($validator->validated());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('dashboard/alerts/update.fail', ['model' => __('dashboard/models.tag')]));
        }
        return TagResource::make($tag);
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $tag = Tag::findOrFail($id);
                $tag->delete();
            });
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(__('dashboard/alerts/show.not_found_fail', ['model' => __('dashboard/models.tag')]));
        } catch (\Exception $e) {
            return $this->errorResponse(__('dashboard/alerts/delete.fail', ['model' => __('dashboard/models.tag')]));
        }
        return $this->successResponse(__('dashboard/alerts/delete.success', ['model' => __('dashboard/models.tag')]));
    }
}
