<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use GuzzleHttp\Handler\Proxy;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('all_products');
        $products = Product::with('category')->orderByDesc('id')->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.products.create', compact('categories'));
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
            'content_en' => 'required',
            'content_ar' => 'required',
            'image' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $img_name = null;
        if($request->hasFile('image')) {
            $img_name = rand().time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $img_name);
        }

        $name = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar
        ], JSON_UNESCAPED_UNICODE);

        $content = json_encode([
            'en' => $request->content_en,
            'ar' => $request->content_ar
        ], JSON_UNESCAPED_UNICODE);

        $data = $request->except('_token');
        unset($data['name_en']);
        unset($data['name_ar']);
        unset($data['content_en']);
        unset($data['content_ar']);
        $data['name'] = $name;
        $data['content'] = $content;
        $data['image'] = $img_name;
        $data['user_id'] = Auth::id();

        Product::create($data);

        return redirect()->route('admin.products.index')->with('msg', 'Product created successfully')->with('type', 'success');
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
    public function edit(Product $product)
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'content_en' => 'required',
            'content_ar' => 'required',
            'image' => 'nullable',
            'price' => 'required',
            'quantity' => 'required',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $img_name = $product->image;
        if($request->hasFile('image')) {
            $img_name = rand().time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $img_name);
        }

        $name = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar
        ], JSON_UNESCAPED_UNICODE);

        $content = json_encode([
            'en' => $request->content_en,
            'ar' => $request->content_ar
        ], JSON_UNESCAPED_UNICODE);

        $data = $request->except('_token');
        unset($data['name_en']);
        unset($data['name_ar']);
        unset($data['content_en']);
        unset($data['content_ar']);
        $data['name'] = $name;
        $data['content'] = $content;
        $data['image'] = $img_name;

        $product->update($data);

        return redirect()->route('admin.products.index')->with('msg', 'Product updated successfully')->with('type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);

        return redirect()->route('admin.products.index')->with('msg', 'Product deleted successfully')->with('type', 'danger');
    }

    /**
     * Display a trashed listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $products = Product::onlyTrashed()->get();
        return view('admin.products.trash', compact('products'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Product::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.products.trash')->with('msg', 'Product restored successfully')->with('type', 'warning');
    }

    /**
     * forcedelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forcedelete($id)
    {
        $product = Product::onlyTrashed()->find($id);
        File::delete(public_path('uploads/categories/'. $product->image));
        $product->forcedelete();

        return redirect()->route('admin.products.trash')->with('msg', 'Product deleted permanintly successfully')->with('type', 'danger');
    }
}
