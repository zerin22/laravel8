<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ServiceController extends Controller
{
    public function HomeService()
    {
        $servies = Services::latest()->get();
        return view('admin.service.index', compact('servies'));
    }

    public function AddService()
    {
        return view('admin.service.create');
    }

    public function StoreService(Request $request)
    {
        Services::insert([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->route('home.service')->with('success', 'Service Inserted Successfully');
    }

    public function EditService($id)
    {
       $services = Services::find($id);
       return view ('admin.service.edit', compact('services'));
    }

    public function UpdateService(Request $request, $id)
    {
        Services::find($id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'creates_at' => Carbon::now()
        ]);

        return Redirect()->route('home.service')->with('success', 'Service Updated Successfully');
    }

    public function DeleteService($id)
    {
        Services::find($id)->Delete();
        return Redirect()->back()->with('success', 'Service Updated Successfully');
    }

}
