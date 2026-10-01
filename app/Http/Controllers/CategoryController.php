<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller {
 public function index(){return response()->json(Category::withCount('books')->latest()->get());}
 public function store(Request $r){$d=$r->validate(['name'=>'required|string|max:100|unique:categories,name','description'=>'nullable|string|max:500']);return response()->json(Category::create($d),201);}
 public function show(Category $category){return response()->json($category->load('books'));}
 public function update(Request $r,Category $category){$d=$r->validate(['name'=>'required|string|max:100|unique:categories,name,'.$category->id,'description'=>'nullable|string|max:500']);$category->update($d);return response()->json($category);}
 public function destroy(Category $category){if($category->books()->exists())return response()->json(['message'=>'Cannot delete a category containing books.'],409);$category->delete();return response()->json(['message'=>'Category deleted']);}
}
