<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
  public function __construct()
  {
    // $this->middleware('auth', ['only' => 'create', 'update', 'delete']);
  }


  public function showAllCategory()
  {
    return response()->json(Category::all());
  }


  public function create(Request $request)
    {
      $this->validate($request, [
        'name' => 'required'
      ]);

      $category = Category::create([
        'name' => $request->name
        ]);

      return response()->json([
        'status' => 'success', 
        'message' => 'Category saved succesfully!',
        'data' => $topic
      ], 201);
    }


    public function update($id, Request $request)
    {
      $this->validate($request, [
        'name' => 'required'
      ]);

      $category = Category::where('id', $id)->first();
      if(!$category) {
      return response()->json(['status' => 'error', 'message' => 'Category not found'], 404);        
      }
      
      $category->update($request->all());
      
      return response()->json([
        'status' => 'success',
        'message' => 'Category updated succesfully!',
        'data' => $category
      ], 200);          
    }


    public function delete($id)
    {
      $category = Category::where('id',$id)->first();
      if(!$category){        
        return response()->json([
          'status' => 'error', 
          'message' => 'Category not found'
        ], 404);
      }
      else{
        $category->delete();

        return response()->json([
          'status' => 'success', 
          'message' => 'Deleted Successfully'
        ], 200);
      }
      
    }
}