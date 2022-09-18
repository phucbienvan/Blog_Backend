<?php

namespace App\Services\Api\Admin;

use App\Services\BaseService;
use Illuminate\Http\Response;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryService extends BaseService
{
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getCategories($params)
    {
        try {
            return [
                'code' => Response::HTTP_OK,
                'categories' => $this->model->orderBy('created_at', 'DESC'),
            ];
        } catch (\Exception $e) {
            Log::error($e);

            return [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => __('messages.get_error')
            ];
        }
    }
}
