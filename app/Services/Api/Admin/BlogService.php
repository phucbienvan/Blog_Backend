<?php

namespace App\Services\Api\Admin;

use App\Models\Blog;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BlogService extends BaseService
{
    public function __construct(Blog $model)
    {
        $this->model = $model;
    }

    public function getBlogs($params)
    {
        try {
            return [
                'code' => Response::HTTP_OK,
                'blogs' => $this->model->whereNull('deleted_at')->orderBy('created_at', 'DESC'),
            ];
        } catch (\Exception $e) {
            Log::error($e);

            return [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => __('messages.get_error')
            ];
        }
    }

    public function getBlogDetail($blog)
    {
        try {            
            $blog->update([
                'view' => ++ $blog->view
            ]);

            return [
                'code' => 403,
                'blog' => $this->model->where('id', $blog->id)->first(),
            ];
        } catch (\Exception $e) {
            Log::error($e);

            return [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => __('messages.get_error')
            ];
        }
    }

    public function createBlog($params)
    {
        try {
            if (isset($params['image'])) {
                $params['image'] = $this->createImage(null, $params['image'], 'blog');
            }

            $params['user_id'] = 1;
            $blog = $this->model::create($params);
    
            return [
                'code' => Response::HTTP_OK,
                'blog' => $blog
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
    
            return [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => __('messages.create_fail')
            ];
        }
    }

    public function updateBlog($params, $blog)
    {
        try {
            if (isset($params['image'])) {
                $params['image'] = $this->createImage(null, $params['image'], 'blog');
            }

            $blog = $blog->update($params);
    
            return [
                'code' => Response::HTTP_OK,
                'blog' => $blog
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
    
            return [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => __('messages.create_fail')
            ];
        }
    }

    public function deleteBlog($blog)
    {
        try {
            
            $blog = $blog->update(['deleted_at' => Carbon::now()]);
    
            return [
                'code' => Response::HTTP_OK,
                'blog' => $blog
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
    
            return [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => __('messages.create_fail')
            ];
        }
    }

    public function getBlogByCategory($categoryId)
    {
        try {
            return [
                'code' => Response::HTTP_OK,
                'blogs' => $this->model
                    ->whereNull('deleted_at')
                    ->where('category_id', $categoryId)
                    ->orderBy('created_at', 'DESC'),
            ];
        } catch (\Exception $e) {
            Log::error($e);

            return [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => __('messages.get_error')
            ];
        }
    }

    public function getBLogsByUser($userId)
    {
        try {
            return [
                'code' => Response::HTTP_OK,
                'blogs' => $this->model
                    ->whereNull('deleted_at')
                    ->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC'),
            ];
        } catch (\Exception $e) {
            Log::error($e);

            return [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => __('messages.get_error')
            ];
        }
    }

    public function getBlogsByOutstanding($params)
    {
        try {
            return [
                'code' => Response::HTTP_OK,
                'blogs' => $this->model->whereNull('deleted_at')->orderBy('view', 'DESC'),
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
