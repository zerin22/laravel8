<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    public function AllBrand(){
        $brands = Brand::latest()->paginate(5);
        return view ('admin.brand.index', compact('brands'));
    }

    // Add Brand
    public function StoreBrand(Request $request){
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:png,jpg,jpeg',
        ],
        [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_name.min' => 'Brand Longer Than 4 Characters',
        ]);

        //Add Image

        $brand_image = $request->file('brand_image');

        $name_gen = hexdec(uniqid());
        $img_ext =strtolower($brand_image->getClientOriginalExtension()); //input image extension get
        $img_name =$name_gen.'.'.$img_ext;//Generate Image Uniqe Name
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Brand Inserted Successfully');

    }

}
