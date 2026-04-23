<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Library;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BookTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        // Truncate the MongoDB books collection before each test
        // since RefreshDatabase only refreshes the SQLite connection.
        Book::truncate();
    }

    public function test_can_list_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Books list',
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_can_create_book()
    {
        $library = Library::factory()->create();
        $data = [
            'name' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'isbn' => '9780743273565',
            'price' => 12.99,
            'library_id' => $library->id,
        ];

        $response = $this->postJson('/api/books', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Book created successfully',
            ]);

        $this->assertDatabaseHas('books', ['name' => 'The Great Gatsby'], 'mongodb');
    }

    public function test_can_show_book()
    {
        $book = Book::factory()->create();

        // MongoDB might return the ID as a string or _id depending on serialization.
        // BookController uses Book::find($id) where $id is int in type hint?
        // Wait, BookController show method has: public Function show(int $id)
        // If MongoDB IDs are strings (which they usually are), int $id will fail.
        // Let's check the controller again.

        $response = $this->getJson('/api/books/' . $book->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Book found',
                'data' => [
                    'name' => $book->name,
                ]
            ]);
    }

    public function test_can_delete_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson('/api/books/' . $book->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Book deleted successfully']);

        $this->assertDatabaseMissing('books', ['id' => $book->id], 'mongodb');
    }

    public function test_show_non_existent_book()
    {
        $response = $this->getJson('/api/books/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Book not found']);
    }

    public function test_delete_non_existent_book()
    {
        $response = $this->deleteJson('/api/books/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Book not found']);
    }
}
