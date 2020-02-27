<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class product extends Model
{
    protected $fillable = ['name', 'photo', 'price', 'stock', 'orders','plan_id'];
    
    /**
     * Creates new product
     *
     * @param Illuminate\Http\Request $request
     * @return mixed
     */
    public static function createProduct(Request $request)
    {
        $file = $request->file('photo');

        $photo = '';

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

            $extension = $file->extension();
            $name = sha1(time() . time()) . ".{$extension}";
            $photo = $name;
            $file->storeAs('public', $name);
        } else {
            return 'error';
        }

        $product = static::create([
            'name' => request('name'),
            'photo' => $photo,
            'price' => request('price'),
            'stock' => request('stock'),
            'orders' => 0,
            'plan_id' => env('STRIPE_PLAN')
        ]);

        return $product;
    }

    /**
     * Deletes the product
     *
     * @param String $id
     * @return String 
     */
    public static function deleteProduct($id)
    {
        $product = static::findOrFail($id);

        $product_name = $product->name;

        Storage::disk('public')->delete($product->photo);

        $product->delete();

        return $product_name;
    }
}
