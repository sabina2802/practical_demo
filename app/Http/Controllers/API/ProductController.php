<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;

class ProductController extends BaseController
{
    //
    
    /**
     * Method addProduct
     *
     * @param REQUEST $Request [explicite description]
     *
     * @return void
     */
    public function addProduct(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:50',
            'description' => 'required|max:250',
            'file'        => 'required|image|mimes:jpeg,png,jpg,gif',
            'type'        => 'in:1,2,3'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();

        $imageName = time().'.'.$request->file->extension();  

        $request->file->storeAs('images', $imageName);

        $input['file']  = $imageName;

        $product = Product::create($input);

        $productDetail['name']        = $product['name'];
        $productDetail['description'] = $product['description'];
        $productDetail['type']        = $product['type'];

   
        return $this->sendResponse($productDetail, 'Product created successfully.');
    }
        
    /**
     * Method listProduct
     *
     * @return void
     */
    public function listProduct()
    {
        $products = Product::paginate(10,['name','type','description']);
    
        return $this->sendResponse($products, 'Products retrieved successfully.');
    }
    
    /**
     * Method showProduct
     *
     * @param REQUEST $Request [explicite description]
     *
     * @return void
     */
    public function showProduct(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:50',
            
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        
        $input = $request->all();

        $product = Product::where('name',$input['name'])->first();

        $path = asset("storage/app/images/".$product['file']);

        $productDetail['name']        = $product['name'];
        $productDetail['type']        = $product['type'];
        $productDetail['description'] = $product['description'];
        $productDetail['file']        = $path;


        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse($productDetail, 'Product retrieved successfully.');

    
    }
}
