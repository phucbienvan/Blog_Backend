<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Services\Api\Admin\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends BaseController
{
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $responseCategories = $this->categoryService->getCategories($request->all());

        if ($responseCategories['code'] === Response::HTTP_OK) {
            return response()->json([
                'data' => CategoryResource::apiPaginate($responseCategories['categories'], $request),
                'code' => Response::HTTP_OK
            ]);
        }

        return $this->responseErrors($responseCategories['message']);
    }

    public function store(CategoryRequest $request)
    {
        $responseCategory = $this->categoryService->createCategory($request->all());

        if ($responseCategory['code'] === Response::HTTP_OK) {
            return response()->json([
                'data' => new CategoryResource($responseCategory['category']),
                'code' => Response::HTTP_OK
            ]);
        }

        return $this->responseErrors($responseCategory['message']);
    }
}
