<?php

namespace App\Http\Controllers;

use App\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Creates a new product
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ini_set('max_execution_time', 300);

        $validate_data = $request->validate([
            'name' => 'required|min:2',
            'price' => 'required|integer',
            'stock' => 'required',
            'photo' => 'required|file|image|max:5000|mimes:jpeg,png',
        ]);

        $product = product::first();

        if ($product !== null) {

           $this->destroy($product->id);
        }

        $created_product = product::createProduct($request);

        session()->flash("notification", [
            'message' => $created_product->name." ".trans('translations.notifications.created'),
            'type' => 'success',
        ]);

        return back();
    }

    /**
     * Update product details
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');

        $key = $request->input('key');

        $value = $request->input('value');

        $product = product::findOrFail($id);

        $product->{$key} = $value;

        $product->save();

        return response()->json([
            'status' => 'success',
            'product' => $product
        ],200);
    }

    /**
     * Deletes a product
     *
     * @param String $id
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = product::deleteProduct($id);

        session()->flash("notification", [
            'message' => $product." ".trans('translations.notifications.deleted'),
            'type' => 'error',
        ]);

        return back();
    }
}
