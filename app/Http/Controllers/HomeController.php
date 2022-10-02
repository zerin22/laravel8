<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    public function HomeSlider(){
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function AddSlider(){
        return view('admin.slider.create');
    }

    public function StoreSlider(Request $request){

        $slider_image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$slider_image->getClientOriginalExtension();
        Image::make($slider_image)->resize(1920,1088)->save('image/slider/'.$name_gen);
        $last_img = 'image/slider/'.$name_gen;

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
         );

        return Redirect()->route('home.slider')->with($notification);
    }

    public function EditSlider($id){
        $sliders = Slider::find($id);
        return view('admin.slider.edit', compact('sliders'));
    }

    public function UpdateSlider(Request$request, $id){
        $old_image = $request->old_image;

        $slider_image = $request->file('image');

        if($slider_image){
            $name_gen = hexdec(uniqid());
            $img_ext =strtolower($slider_image->getClientOriginalExtension()); //input image extension get
            $img_name =$name_gen.'.'.$img_ext;//Generate Image Uniqe Name
            $up_location = 'image/slider/';
            $last_img = $up_location.$img_name;
            $slider_image->move($up_location,$img_name);

            unlink($old_image);
            Slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Slider Updated Successfully',
                'alert-type' => 'success'
             );

            return Redirect()->back()->with($notification);
        }else{
            Slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'created_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Slider Updated Successfully',
                'alert-type' => 'success'
             );

            return Redirect()->route('home.slider')->with($notification);
        }
    }

    public function DeleteSlider($id)
    {
        $image = Slider::find($id);
        $old_image = $image->image;
        unlink($old_image);
        Slider::find($id)->delete();

        $notification = array(
            'message' => 'Slider Image Deleted Successfully',
            'alert-type' => 'success'
         );

        return Redirect()->back()->with($notification);
    }


}
