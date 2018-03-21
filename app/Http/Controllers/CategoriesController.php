<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
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

      $category = Category::findOrFail($id);
      $category->update($request->all());

      $res['success'] = true;
      $res['code'] = 200;
      $res['message'] = 'Category updated succesfully!';
      $res['data'] = $category;
      return response($res);
        
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