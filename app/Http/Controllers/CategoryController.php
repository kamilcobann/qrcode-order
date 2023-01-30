<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api',['except'=>[
            'getAllCategories',
            'getCategoryById'
        ]]);
    }
    
    public function getAllCategories()
    {
        $categories = Category::all();

        return response()->json([
            'status' => true,
            'categories' => $categories,
        ]);
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        
        if($category = Category::whereSlug(str_slug($request->name))->get())
        {
            return response()->json([
                'status' => false,
                'message' => 'Category exists',
                'category' => $category,
            ]);
        }else{
            $category = Category::create([
                'name' => $request->name,
                'slug' => str_slug($request->name),
            ]);
        
            return response()->json([
                'status' => true,
                'message' => 'Category successfully created',
                'category' => $category,
            ]);
    }
        

        
    }

    public function getCategoryById($id)
    {
        if ($category = Category::find($id))
        {
            return response()->json([
                'status' => true,
                'message' => 'Category found',
                'category' => $category,
            ]);  
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ]);
        }
    }

    public function updateCategoryById(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        if($category = Category::find($id))
        {
            $category->name = $request->name;
            $category->slug = str_slug($request->name);
            $category->save();

            return response()->json([
                'status' => true,
                'message' => 'category updated',
                'category' => $category,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'category not found',
            ]);
        }

    }

    public function deleteCategoryById($id)
    {
        if ($category = Category::find($id)) {
            $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'category deleted',
                'category' => $category
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'category not found',
        ]);
    }
}
