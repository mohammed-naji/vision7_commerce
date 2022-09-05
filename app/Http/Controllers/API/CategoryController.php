<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appid = request()->appid;
        if(request()->has('appid')) {
            if($appid == env('API_KEY')) {
                return response()->json([
                    'message' => 'Proccess Done',
                    'error' => 0,
                    'data' => Category::with('products')->paginate(10),
                ],
                // Response::HTTP_CREATED
                200
                );
            }else {
                return response()->json([
                    'message' => 'App id does not match',
                    'error' => 1,
                    'data' => []
                ],
                400
                );
            }
        }else {
            return response()->json([
                'message' => 'Please provide app id that sent to your email',
                'error' => 1,
                'data' => []
            ],
            400
            );
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $img_name = null;
        if($request->hasFile('image')) {
            $img_name = rand().time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/categories'), $img_name);
        }

        $name = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar
        ], JSON_UNESCAPED_UNICODE);

        $category = Category::create([
            'name' => $name,
            'image' => $img_name,
            'parent_id' => $request->parent_id
        ]);

        if($category) {
            return response()->json([
                'message' => 'Proccess Done',
                'error' => 0,
                'data' => $category
            ], 201);
        }else {
            return response()->json([
                'message' => 'Proccess Fail',
                'error' => 1,
                'data' => []
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if($category) {
            return response()->json([
                'message' => 'Proccess Done',
                'error' => 0,
                'data' => $category
            ], 200 );
        }else {
            return response()->json([
                'message' => 'Proccess Fail',
                'error' => 1,
                'data' => $category
            ], 404 );
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $category = Category::find($id);
        if(!$category) {
            return response()->json([
                'message' => 'Proccess Fail',
                'error' => 1,
                'data' => $category
            ], 404 );
        }

        $img_name = $category->image;
        if($request->hasFile('image')) {
            $img_name = rand().time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/categories'), $img_name);
        }

        $name = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar
        ], JSON_UNESCAPED_UNICODE);

        $res = $category->update([
            'name' => $name,
            'image' => $img_name,
            'parent_id' => $request->parent_id
        ]);

        if($res) {
            return response()->json([
                'message' => 'Proccess Done',
                'error' => 0,
                'data' => $category
            ], 201);
        }else {
            return response()->json([
                'message' => 'Proccess Fail',
                'error' => 1,
                'data' => []
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::destroy($id);

        if($category) {
            return response()->json([
                'message' => 'Proccess Done',
                'error' => 0,
                'data' => []
            ], 200 );
        }else {
            return response()->json([
                'message' => 'Proccess Fail',
                'error' => 1,
                'data' => $category
            ], 404 );
        }
    }
}
