<?php
namespace Database\Seeders;
use App\Models\User;use App\Models\Category;use App\Models\Book;use App\Models\Member;use Illuminate\Database\Seeder;use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {public function run():void{
 $user=User::updateOrCreate(['email'=>'admin@library.test'],['name'=>'Library Admin','password'=>Hash::make('password'),'role'=>'admin']);
 $memberUser=User::updateOrCreate(['email'=>'member@library.test'],['name'=>'Library Member','password'=>Hash::make('password'),'role'=>'user']);
 $fiction=Category::create(['name'=>'Fiction','description'=>'Novels and fictional literature.']);$technology=Category::create(['name'=>'Technology','description'=>'Programming and computer science books.']);$science=Category::create(['name'=>'Science','description'=>'Science and research books.']);
 Book::insert([
 ['category_id'=>$fiction->id,'title'=>'The Alchemist','isbn'=>'9780061122415','author'=>'Paulo Coelho','publisher'=>'HarperOne','published_year'=>1988,'quantity'=>5,'available_quantity'=>5,'created_at'=>now(),'updated_at'=>now()],
 ['category_id'=>$technology->id,'title'=>'Clean Code','isbn'=>'9780132350884','author'=>'Robert C. Martin','publisher'=>'Prentice Hall','published_year'=>2008,'quantity'=>4,'available_quantity'=>4,'created_at'=>now(),'updated_at'=>now()],
 ['category_id'=>$technology->id,'title'=>'Learning Laravel API','isbn'=>'9780000000001','author'=>'Library Demo Author','publisher'=>'Demo Press','published_year'=>2026,'quantity'=>3,'available_quantity'=>3,'created_at'=>now(),'updated_at'=>now()],
 ]);
 Member::updateOrCreate(['email'=>'srijal@example.com'],['name'=>'Srijal Dangol','phone'=>'9800000000','address'=>'Lalitpur, Nepal','membership_date'=>now()->toDateString(),'status'=>'active']);
 Member::updateOrCreate(['email'=>'member@library.test'],['user_id'=>$memberUser->id,'name'=>'Library Member','phone'=>'9811111111','address'=>'Kathmandu, Nepal','membership_date'=>now()->subDays(30)->toDateString(),'status'=>'active']);
 }}
