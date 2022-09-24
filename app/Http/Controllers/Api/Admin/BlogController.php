<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BlogResource;
use App\Models\Blog;
use App\Services\Api\Admin\BlogService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogController extends Controller
{
    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }
    public function index(Request $request)
    {
        $responseBlogs = $this->blogService->getBlogs($request->all());

        if ($responseBlogs['code'] == Response::HTTP_OK) {
            return response()->json([
                'data' => BlogResource::apiPaginate($responseBlogs['blogs'], $request),
                'code' => Response::HTTP_OK
            ]);
        }

        return $this->responseErrors($responseBlogs['message']);
    }

    public function store(Request $request)
    {
        $responseBlog = $this->blogService->createBlog($request->all());

        if ($responseBlog['code'] === Response::HTTP_OK) {
            return response()->json([
                'data' => new BlogResource($responseBlog['blog']),
                'code' => Response::HTTP_OK
            ]);
        }

        return $this->responseErrors($responseBlog['message']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function update(Request $request, Blog $blog)
    {
        $responseBlog = $this->blogService->updateBlog($request->all(), $blog);

        if ($responseBlog['code'] === Response::HTTP_OK) {
            return response()->json([
                'data' => $responseBlog['blog'],
                'code' => Response::HTTP_OK
            ]);
        }

        return $this->responseErrors($responseBlog['message']);
    }

    public function destroy(Blog $blog)
    {
        $responseBlog = $this->blogService->deleteBlog($blog);

        if ($responseBlog['code'] === Response::HTTP_OK) {
            return response()->json([
                'data' => $responseBlog['blog'],
                'code' => Response::HTTP_OK
            ]);
        }

        return $this->responseErrors($responseBlog['message']);
    }
}
