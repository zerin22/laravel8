<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function AllCat(){

        //Read data with Eloquent ORM

        // $categories = Category::all();
        // $categories = Category::latest()->get(); //last data will see at 1st in the row
        $categories = Category::latest()->paginate(5);

        //Read Data with Query Builder
       // $categories = DB::table('categories')->latest()->get();

        //Pagination
       // $categories = DB::table('categories')->latest()->paginate(5);

        return view ('admin.category.index', compact('categories'));
    }

    public function AddCat(Request $request){
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category Less than 255Chars',
        ]);

        //Insert Data by Eloquent ORM One Process

        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);


        //Insert Data With Eloquent ORM 2nd Process

        // $category =new Category();
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        //Insert Data With Query Builder

        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('Categories')->insert($data);

        //After Save Data redirect page with message
        return redirect()->back()->with('success', 'Category Inserted Successfully');




    }
}
