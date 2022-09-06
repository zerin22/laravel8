<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function AllCat(){

        // //Join Table With Query Builder
        // $categories = DB::table('categories')
        //             ->join('users','categories.user_id','users.id')
        //             ->select('categories.*','users.name')
        //             ->latest()->paginate(5);

        // //Read data with Eloquent ORM
        //$categories = Category::all();
        //$categories = Category::latest()->get(); //last data will see at 1st in the row
        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->latest()->paginate(3); //for temporary catagory delete

        // //Read Data with Query Builder & Pagination
        // $categories = DB::table('categories')->latest()->get();
        // $categories = DB::table('categories')->latest()->paginate(5);

        return view ('admin.category.index', compact('categories','trashCat'));
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


        // //Insert Data With Eloquent ORM 2nd Process

        // $category =new Category();
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        // //Insert Data With Query Builder

        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('Categories')->insert($data);

        //After Save Data redirect page with message
        return redirect()->back()->with('success', 'Category Inserted Successfully');

    }

    //Edit Data(category) with Eloquent ORM /Query Builder
    public function Edit($id){
        //$categories = Category::find($id);
        $categories = DB::table('categories')->where('id',$id)->first();
        return view('admin.category.edit', compact('categories'));
    }

    //Update Data(category) with Eloquent ORM //Query Builder
    public function Update(Request $request, $id){
        // $categories = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,

        // ]);
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id',$id)->update($data);

        return Redirect()->route('all.category')->with('success', 'Category Updated Successfully');

    }

    //Soft Delete Category Method
    public function SoftDelete($id){
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Soft Delete Successfully');
    }

    //Restore Category Method
    public function Restore($id){
        $restore = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restore Successfully');
    }

    //Parmanent delete Method
    public function Pdelete($id){
        $pdelete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category Parmanently Deleted ');
    }


}
