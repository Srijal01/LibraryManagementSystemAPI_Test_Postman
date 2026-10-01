<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property \Illuminate\Support\Carbon $membership_date
 * @property string $status
 * @property-read User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Loan> $loans
 */
class Member extends Model {
    use HasFactory;
    protected $fillable=['user_id','name','email','phone','address','membership_date','status'];
    protected $casts=['membership_date'=>'date'];
    public function user(){ return $this->belongsTo(User::class); }
    public function loans(){ return $this->hasMany(Loan::class); }
}
