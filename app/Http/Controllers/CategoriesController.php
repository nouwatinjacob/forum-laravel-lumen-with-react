<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth', ['only' => 'create', 'update', 'delete']);
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

      $res['success'] = true;
      $res['code'] = 201;
      $res['message'] = 'Category saved succesfully!';
      $res['data'] = $category;
      return response($res);
    }

    public function update($id, Request $request)
    {
      $this->validate($request, [
        'name' => 'required'
      ]);

      $category = Category::find($id);
      if(!category) {
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
      $category = Category::find($id);
      if(!$category){
        $res['success'] = false;
        $res['code'] = 400;
        $res['message'] = 'Category not found';
        return response($res);
      }
      else{
        $category->delete();
        $res['success'] = true;
        $res['code'] = 200;
        $res['message'] = 'Deleted Successfully';
        return response($res);
      }
      
    }
}