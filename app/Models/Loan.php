<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Loan extends Model {
    use HasFactory;
    protected $fillable=['book_id','member_id','loan_date','due_date','returned_at','status'];
    protected $casts=['loan_date'=>'date','due_date'=>'date','returned_at'=>'date'];
    public function book(){ return $this->belongsTo(Book::class); }
    public function member(){ return $this->belongsTo(Member::class); }
}
