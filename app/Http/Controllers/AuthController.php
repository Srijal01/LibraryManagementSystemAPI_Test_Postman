<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller {
    public function register(Request $request){
        $data=$request->validate(['name'=>'required|string|max:100','email'=>'required|email|unique:users,email','password'=>'required|string|min:6|confirmed']);
        $data['role']='user';
        $user=User::create($data);
        $token=$user->createToken('postman-token')->plainTextToken;
        return response()->json(['message'=>'Registration successful','user'=>$user,'token'=>$token],201);
    }
    public function login(Request $request){
        return $this->loginForRole($request);
    }
    public function adminLogin(Request $request){
        return $this->loginForRole($request, 'admin');
    }
    public function userLogin(Request $request){
        return $this->loginForRole($request, 'user');
    }
    private function loginForRole(Request $request, ?string $role = null){
        $data=$request->validate(['email'=>'required|email','password'=>'required|string']);
        $user=User::where('email',$data['email'])->first();
        if(!$user || !Hash::check($data['password'],$user->password) || ($role && $user->role !== $role)) throw ValidationException::withMessages(['email'=>['Invalid email or password.']]);
        $user->tokens()->delete();
        return response()->json(['message'=>'Login successful','user'=>$user,'token'=>$user->createToken('postman-token')->plainTextToken]);
    }
    public function user(Request $request){ return response()->json($request->user()); }
    public function logout(Request $request){ $request->user()->currentAccessToken()?->delete(); return response()->json(['message'=>'Logged out successfully']); }
}
