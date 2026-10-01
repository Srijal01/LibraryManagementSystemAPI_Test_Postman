<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Member extends Model {
    use HasFactory;
    protected $fillable=['user_id','name','email','phone','address','membership_date','status'];
    protected $casts=['membership_date'=>'date'];
    public function user(){ return $this->belongsTo(User::class); }
    public function loans(){ return $this->hasMany(Loan::class); }
}
