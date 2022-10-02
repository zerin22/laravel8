<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Multipic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;


class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


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

        // $name_gen = hexdec(uniqid());
        // $img_ext =strtolower($brand_image->getClientOriginalExtension()); //input image extension get
        // $img_name =$name_gen.'.'.$img_ext;//Generate Image Uniqe Name
        // $up_location = 'image/brand/';
        // $last_img = $up_location.$img_name;
        // $brand_image->move($up_location,$img_name);

        //Image Insert & Resize Intervation Package
        $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300,200)->save('image/brand/'.$name_gen);
        $last_img = 'image/brand/'.$name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);

         $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
         );

        return Redirect()->back()->with($notification);

    }

    //Brand Edit
    public function Edit($id){
      $brands = Brand::find($id);
      return view('admin.brand.edit', compact('brands'));
    }

    public function Update(Request $request, $id){
        $validated = $request->validate([
            'brand_name' => 'required|min:4',
        ],
        [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_name.min' => 'Brand Longer Than 4 Characters',
        ]);

        //update Image
        $old_image = $request->old_image;

        $brand_image = $request->file('brand_image');

        if($brand_image){
            $name_gen = hexdec(uniqid());
            $img_ext =strtolower($brand_image->getClientOriginalExtension()); //input image extension get
            $img_name =$name_gen.'.'.$img_ext;//Generate Image Uniqe Name
            $up_location = 'image/brand/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);

            unlink($old_image);
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
                'created_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'success'
             );

            return Redirect()->back()->with($notification);
        }else{
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'success'
             );

            return Redirect()->route('all.brand')->with($notification);
        }

    }

    //Brand Delete
    public function Delete($id){
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);
        Brand::find($id)->delete();

        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'warning'
         );

        return Redirect()->back()->with($notification);
    }

    //This is For Multi Image All Image
    public function MultiImage(){
        $images = Multipic::all();
        return view('admin.multipic.index', compact('images'));
    }

    //Add Multi image
    public function StoreImg(Request $request){

        $image = $request->file('image');

        foreach($image as $multi_img)
        {
            $name_gen = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension();
            Image::make($multi_img)->resize(300,300)->save('image/multi/'.$name_gen);
            $last_img = 'image/multi/'.$name_gen;

            Multipic::insert([
                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);
        }//end of foreach loop

        return Redirect()->back();
    }

    //Admin Panel Functions
    public function Logout(){
        Auth::logout();

        $notification = array(
            'message' => 'User Logout',
            'alert-type' => 'info'
         );

        return Redirect()->route('login')->with($notification);
    }
}
