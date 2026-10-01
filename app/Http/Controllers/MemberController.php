<?php
namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;
class MemberController extends Controller {
 public function index(){return response()->json(Member::withCount('loans')->latest()->get());}
 public function store(Request $r){$d=$r->validate(['name'=>'required|string|max:100','email'=>'required|email|unique:members,email','phone'=>'nullable|string|max:30','address'=>'nullable|string|max:255','membership_date'=>'required|date','status'=>'sometimes|in:active,inactive']);$d['status']=$d['status']??'active';return response()->json(Member::create($d),201);}
 public function show(Member $member){return response()->json($member->load('loans.book'));}
 public function update(Request $r,Member $member){$d=$r->validate(['name'=>'sometimes|required|string|max:100','email'=>'sometimes|required|email|unique:members,email,'.$member->id,'phone'=>'nullable|string|max:30','address'=>'nullable|string|max:255','membership_date'=>'sometimes|date','status'=>'sometimes|in:active,inactive']);$member->update($d);return response()->json($member);}
 public function destroy(Member $member){if($member->loans()->where('status','borrowed')->exists())return response()->json(['message'=>'Cannot delete a member with an active loan.'],409);$member->delete();return response()->json(['message'=>'Member deleted']);}
}
