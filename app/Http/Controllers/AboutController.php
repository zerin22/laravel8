<?php

namespace App\Http\Controllers;

use App\Models\HomeAbout;
use App\Models\Multipic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AboutController extends Controller
{
    public function HomeAbout()
    {
        $homeabout = HomeAbout::latest()->get();
        return view('admin.home.index', compact('homeabout'));
    }

    public function AddAbout()
    {
       return view('admin.home.create');
    }

    public function StoreAbout(Request $request)
    {
        HomeAbout::insert([
            'title' => $request->title,
            'short_dis' => $request->short_dis,
            'long_dis' => $request->long_dis,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'About Inserted Successfully',
            'alert-type' => 'success'
         );

        return Redirect()->route('home.about')->with($notification);
    }

    public function EditAbout($id)
    {
        $homeabout = HomeAbout::find($id);
        return view('admin.home.edit', compact('homeabout'));
    }

    public function UpdateAbout(Request $request, $id)
    {
        $update = HomeAbout::find($id)->update([
            'title' => $request->title,
            'short_dis' => $request->short_dis,
            'long_dis' => $request->long_dis,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'About updated Successfully',
            'alert-type' => 'success'
         );

        return Redirect()->route('home.about')->with($notification);
    }

    public function DeleteAbout($id)
    {
        $delete = HomeAbout::find($id)->Delete();

        $notification = array(
            'message' => 'About Deleted Successfully',
            'alert-type' => 'warning'
         );

        return Redirect()->back()->with($notification);

    }


    public function Portfolio()
    {
       $images = Multipic::all();
        return view('pages.portfolio', compact('images'));
    }

}
