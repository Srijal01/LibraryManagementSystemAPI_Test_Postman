<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Book> $books
 */
class Category extends Model {
    use HasFactory;
    protected $fillable=['name','description'];
    public function books(){ return $this->hasMany(Book::class); }
}
