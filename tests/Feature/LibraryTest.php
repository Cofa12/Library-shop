<?php

namespace Tests\Feature;

use App\Models\Library;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_libraries()
    {
        Library::factory()->count(3)->create();

        $response = $this->getJson('/api/library');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_can_create_library()
    {
        $data = [
            'name' => 'City Library',
            'address' => '123 Main St',
            'phone' => '555-1234',
            'email' => 'city@library.com',
        ];

        $response = $this->postJson('/api/library', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Library created successfully',
                'data' => $data
            ]);

        $this->assertDatabaseHas('library', $data);
    }

    public function test_can_show_library()
    {
        $library = Library::create([
            'name' => 'Solo Library',
            'address' => '456 Oak Ave',
            'phone' => '555-5678',
            'email' => 'solo@library.com',
        ]);

        $response = $this->getJson('/api/library/' . $library->id);

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Solo Library',
            ]);
    }

    public function test_can_update_library()
    {
        $library = Library::create([
            'name' => 'Old Name',
            'address' => 'Old Address',
            'phone' => '000',
            'email' => 'old@old.com',
        ]);

        $data = [
            'name' => 'New Name',
            'address' => 'New Address',
            'phone' => '111',
            'email' => 'new@new.com',
        ];

        $response = $this->putJson('/api/library/' . $library->id, $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Library updated successfully',
                'data' => $data
            ]);

        $this->assertDatabaseHas('library', $data);
    }

    public function test_can_delete_library()
    {
        $library = Library::create([
            'name' => 'To Be Deleted',
            'address' => 'Addr',
            'phone' => '123',
            'email' => 'del@del.com',
        ]);

        $response = $this->deleteJson('/api/library/' . $library->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Library deleted successfully']);

        $this->assertDatabaseMissing('library', ['id' => $library->id]);
    }

    public function test_library_validation()
    {
        $response = $this->postJson('/api/library', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'address', 'phone', 'email']);
    }
}
