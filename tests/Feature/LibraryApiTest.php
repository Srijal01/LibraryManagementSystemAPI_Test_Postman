<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LibraryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_requires_valid_credentials(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrong',
        ]);

        $response->assertStatus(422);
    }

    public function test_unauthenticated_user_cannot_access_books(): void
    {
        $this->getJson('/api/books')->assertStatus(401);
    }

    public function test_admin_and_user_have_separate_login_endpoints(): void
    {
        $this->createUser('admin@library.test', 'admin');
        $this->createUser('member@library.test', 'user');

        $this->postJson('/api/auth/admin/login', [
            'email' => 'admin@library.test',
            'password' => 'password',
        ])->assertOk()->assertJsonPath('user.role', 'admin');

        $this->postJson('/api/auth/user/login', [
            'email' => 'member@library.test',
            'password' => 'password',
        ])->assertOk()->assertJsonPath('user.role', 'user');
    }

    public function test_user_cannot_create_admin_records(): void
    {
        $user = $this->createUser('member@library.test', 'user');
        $token = $user->createToken('test')->plainTextToken;

        $this->withToken($token)->postJson('/api/categories', [
            'name' => 'Restricted category',
        ])->assertForbidden();
    }

    public function test_user_can_borrow_and_view_their_own_loan(): void
    {
        $user = $this->createUser('member@library.test', 'user');
        $member = Member::create([
            'user_id' => $user->id,
            'name' => 'Library Member',
            'email' => 'member@library.test',
            'membership_date' => now()->toDateString(),
            'status' => 'active',
        ]);
        $book = $this->createBook(1);
        $token = $user->createToken('test')->plainTextToken;

        $this->withToken($token)->postJson('/api/my-loans', [
            'book_id' => $book->id,
            'due_date' => now()->addDays(14)->toDateString(),
        ])->assertCreated()->assertJsonPath('member.id', $member->id);

        $this->assertDatabaseHas('books', ['id' => $book->id, 'available_quantity' => 0]);
        $this->withToken($token)->getJson('/api/loans/mine')->assertOk()->assertJsonPath('data.0.book.id', $book->id);
    }

    public function test_user_cannot_borrow_the_same_book_twice(): void
    {
        $user = $this->createUser('member@library.test', 'user');
        Member::create([
            'user_id' => $user->id,
            'name' => 'Library Member',
            'email' => 'member@library.test',
            'membership_date' => now()->toDateString(),
            'status' => 'active',
        ]);
        $book = $this->createBook(2);
        $token = $user->createToken('test')->plainTextToken;
        $payload = ['book_id' => $book->id, 'due_date' => now()->addDays(14)->toDateString()];

        $this->withToken($token)->postJson('/api/my-loans', $payload)->assertCreated();
        $this->withToken($token)->postJson('/api/my-loans', $payload)->assertConflict();
    }

    private function createUser(string $email, string $role): User
    {
        return User::create([
            'name' => ucfirst($role),
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => $role,
        ]);
    }

    private function createBook(int $quantity): Book
    {
        $category = Category::create(['name' => 'Test category']);

        return Book::create([
            'category_id' => $category->id,
            'title' => 'Test book',
            'isbn' => 'TEST-' . $quantity,
            'author' => 'Test author',
            'quantity' => $quantity,
            'available_quantity' => $quantity,
        ]);
    }
}
