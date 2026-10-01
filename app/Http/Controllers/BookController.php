<?php
namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
class BookController extends Controller {
 public function index(){return response()->json(Book::with('category')->latest()->paginate(10));}
 public function store(Request $r){$d=$r->validate(['category_id'=>'required|exists:categories,id','title'=>'required|string|max:200','isbn'=>'required|string|max:30|unique:books,isbn','author'=>'required|string|max:150','publisher'=>'nullable|string|max:150','published_year'=>'nullable|integer|min:1000|max:2100','quantity'=>'required|integer|min:1']);$d['available_quantity']=$d['quantity'];return response()->json(Book::create($d)->load('category'),201);}
 public function show(Book $book){return response()->json($book->load('category'));}
 public function update(Request $r,Book $book){$d=$r->validate(['category_id'=>'sometimes|exists:categories,id','title'=>'sometimes|required|string|max:200','isbn'=>'sometimes|required|string|max:30|unique:books,isbn,'.$book->id,'author'=>'sometimes|required|string|max:150','publisher'=>'nullable|string|max:150','published_year'=>'nullable|integer|min:1000|max:2100','quantity'=>'sometimes|required|integer|min:1']);if(isset($d['quantity'])){$difference=$d['quantity']-$book->quantity;$d['available_quantity']=max(0,$book->available_quantity+$difference);} $book->update($d);return response()->json($book->load('category'));}
 public function destroy(Book $book){if($book->loans()->where('status','borrowed')->exists())return response()->json(['message'=>'Cannot delete a currently borrowed book.'],409);$book->delete();return response()->json(['message'=>'Book deleted']);}
 public function search(Request $r){$r->validate(['q'=>'required|string|min:1']);$q=$r->q;$books=Book::with('category')->where(fn($x)=>$x->where('title','like',"%$q%")->orWhere('author','like',"%$q%")->orWhere('isbn','like',"%$q%"))->get();return response()->json($books);}
}
