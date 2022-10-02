<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;

class ChangePassController extends Controller
{
    public function CPassword()
    {
        return view('admin.body.change_password');
    }

    public function UpdatePassword(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ]);

        $hashedPassword = Auth::user()->password;

        if(Hash::check($request->oldpassword,$hashedPassword))
        {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return Redirect()->route('login')->with('success', 'Password is Changed Successfully');
        }else{
            return Redirect()->back()->with('error', 'Current Password is Invalid');
        }
    }

    public function PUpdate()
    {
        if(Auth::user()){
            $user = User::find(Auth::user()->id);
            if($user){
                return view('admin.body.update_profile', compact('user'));
            }
        }
    }

    public function UpdateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $old_image = $user->profile_image;


        if( $request->file('profile_image')){
            $file = $request->file('profile_image');
            $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            Image::make($file)->resize(100, 100)->save('image/profile/'.$filename);
            $user['profile_image'] = $filename;

            if(is_file('image/profile/'.$old_image)){
                unlink('image/profile/'.$old_image);
            }
        }
        $user->save();

        $notification = array(
            'message' => 'Profile Update Successfully',
            'alert-type' => 'success'
         );

        return Redirect()->back()->with($notification);


    }



}
