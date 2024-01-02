<?php

namespace Tests\Feature\CRUD;

use App\Models\Petugas;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_select_all_data_category(): void
    {
        $petugas = Petugas::factory()->create();
        $response = $this->actingAs($petugas)->get(route('crud_category.index'));

        $this->assertAuthenticated();
        $response->assertStatus(200);
    }

    public function test_to_insert_data(): void
    {
        $petugas = Petugas::factory()->create();
        $response = $this->actingAs($petugas)->post(route('crud_category.store'), [
            'category' => 'food',
        ]);

        $this->assertAuthenticated();
        $response->assertCreated();
    }

    public function test_to_insert_duplicate_data(): void
    {
        $petugas = Petugas::factory()->create();
        $category = Category::factory()->create([ 'category' => 'food' ]);
        $response = $this->actingAs($petugas)->post(route('crud_category.store'), [
            'category' => 'food',
        ]);

        $this->assertAuthenticated();
        $response->assertSessionHas('error');
    }

    public function test_to_insert_empty_data(): void
    {
        $petugas = Petugas::factory()->create();
        $response = $this->actingAs($petugas)->post(route('crud_category.store'));

        $this->assertAuthenticated();
        $response->assertSessionHas('error');
    }

    public function test_to_edit_page(): void
    {
        $petugas = Petugas::factory()->create();
        $category = Category::factory()->create();
        $response = $this->actingAs($petugas)->get(route('crud_category.edit', $category->id));

        $this->assertAuthenticated();
        $response->assertOk();
    }

    public function test_to_update_data(): void
    {
        $petugas = Petugas::factory()->create();
        $category = Category::factory()->create();
        $response = $this->actingAs($petugas)->post(route('crud_category.update', $category->id), [
            'category' => 'updated category'
        ]);

        $this->assertAuthenticated();
        $response->assertOk();
    }
    
    public function test_to_fail_update_data(): void
    {
        $petugas = Petugas::factory()->create();
        $response = $this->actingAs($petugas)->post(route('crud_category.update', 'wow-data'), [
            'category' => 'updated category'
        ]);

        $this->assertAuthenticated();
        // $response->assertSessionHas('error');
        $response->assertRedirectToRoute('crud_category.index');
    }
    
    
    public function test_to_delete_data(): void
    {
        $petugas = Petugas::factory()->create();
        $category = Category::factory()->create();
        $response = $this->actingAs($petugas)->post(route('crud_category.destroy', $category->id));

        $this->assertAuthenticated();
        $response->assertOk();
        $response->assertRedirectToRoute('crud_category.index');
    }
}
