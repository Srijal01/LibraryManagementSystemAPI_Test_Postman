<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $isbn
 * @property string $author
 * @property string|null $publisher
 * @property int|null $published_year
 * @property int $quantity
 * @property int $available_quantity
 * @property-read Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Loan> $loans
 */
class Book extends Model {
    use HasFactory;
    protected $fillable=['category_id','title','isbn','author','publisher','published_year','quantity','available_quantity'];
    protected $casts=['published_year'=>'integer','quantity'=>'integer','available_quantity'=>'integer'];
    public function category(){ return $this->belongsTo(Category::class); }
    public function loans(){ return $this->hasMany(Loan::class); }
}
