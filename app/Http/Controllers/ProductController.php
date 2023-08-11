<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
// use App\Http\Requests\StoreImageRequest;
// use App\Http\Requests\UpdateImageRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();


        foreach ($products as $key => $value) {
            $category = Category::where('id', $value->category_id)->first();
            $value->category = $category->name;
            $image = Image::where('product_id', $value->id)->first();
            $value->imageUrl = URL::to('/').'/images/'.$image->url_image;
        }

        return response()->json($products, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function menus(StoreProductRequest $request)
    {
        $category = Category::where('name', $request->category)->first();
        $products = Product::where('category_id', $category->id)->orderBy('created_at', 'DESC')->get();


        foreach ($products as $key => $value) {
            $image = Image::where('product_id', $value->id)->first();
            $value->category = $category->name;
            $value->imageUrl = URL::to('/').'/images/'.$image->url_image;
        }

        return response()->json($products, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {

        $this->validate($request,[
            'name' => 'required|max:255',
            'ingredients' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'imageUpload' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // return response()->json($request->all(), 200);


        try {
            if ($request->hasFile('imageUpload')) {
                $image = $request->file('imageUpload');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
                // $this->save();
            }

            // Insert to Database

            $product = new Product();
            $product->name = $request['name'];
            $product->ingredients = $request['ingredients'];
            $product->description = $request['description'];
            $product->price = $request['price'];
            $product->discount = $request['discount'];
            $product->category_id = $request['category_id'];
            $product->image_id = 0;
            $product->save();

            $image = new Image();
            $image->product_id = $product->id;
            $image->url_image = $name;
            $image->save();

            // Get Category
            $category = Category::find($product->category_id);
            $product->category = $category->name;
            $product->imageUrl = URL::to('/').'/images/'.$image->url_image;

            return response()->json($product, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|max:255',
            // 'ingredients' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            // 'imageUpload' => 'required',
        ]);

        try {
            if ($request->hasFile('imageUpload')) {
                $imageDelete = Image::where('product_id', $id)->first();
                $deleteImage = File::delete('images/'.$imageDelete->url_image);
                if($deleteImage) {
                    $imageDelete->delete();
                }

                $images = $request->file('imageUpload');
                $name = time().'.'.$images->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $images->move($destinationPath, $name);


                $imageStore = new Image();
                $imageStore->product_id = $id;
                $imageStore->url_image = $name;
                $imageStore->save();
            }
            $image = Image::where('product_id', $id)->first();

            // Insert to Database

            $product = Product::find($id);
            $product->name = $request['name'];
            $product->ingredients = $request['ingredients'];
            $product->description = $request['description'];
            $product->price = $request['price'];
            $product->discount = $request['discount'];
            $product->category_id = $request['category_id'];
            // $product->imageUrl = $changeName;
            $product->image_id = 0;
            $product->save();

            // Get Category
            $category = Category::where('id', $product->category_id)->first();
            $product->category = $category->name;
            $product->imageUrl = URL::to('/').'/images/'.$image->url_image;

            return response()->json($product, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {
        $product = Product::findorFail($id);
        if ($product) {
            $image = Image::where('product_id', $id)->first();
            $deleteImage = File::delete('images/'.$image->url_image);
            if($deleteImage) {
                $image->delete();
                $product->delete();
                return response()->json($id, 200);
            }
            return response()->json("Error", 200);
        } else {
            return response()->json("Error", 200);
        }
    }
}
