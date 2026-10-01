<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $category_id
 * @property int $quantity
 * @property int $available_quantity
 */
class Book extends Model {
    use HasFactory;
    protected $fillable=['category_id','title','isbn','author','publisher','published_year','quantity','available_quantity'];
    protected $casts=['published_year'=>'integer','quantity'=>'integer','available_quantity'=>'integer'];
    public function category(){ return $this->belongsTo(Category::class); }
    public function loans(){ return $this->hasMany(Loan::class); }
}
