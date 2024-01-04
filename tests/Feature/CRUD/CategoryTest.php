<?php

namespace Tests\Feature\CRUD;

use App\Models\Petugas;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Illuminate\Support\Str;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_select_all_data_category(): void
    {
        $petugas = Petugas::factory()->create();
        $response = $this->actingAs($petugas, 'petugas')->get(route('crud_category.index'));

        $this->assertAuthenticated('petugas');
        $response->assertStatus(200);
    }

    public function test_to_insert_data(): void
    {
        $categoryName = fake()->word();
        $admin = Petugas::factory()->create();

        $this->actingAs($admin, 'petugas')
            ->post(route('crud_category.store'), ['category' => $categoryName])
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Petugas/Manages/Category/Index')
                    ->has('success')
            );
    }

    public function test_to_insert_duplicate_data(): void
    {
        $admin = Petugas::factory()->create();
        $category = Category::factory()->create();

        
        $this->actingAs($admin, 'petugas')
            ->post(route('crud_category.store'), ['category' => $category->category])
            ->assertInertia(
                fn(Assert $page) => $page
                ->component('Petugas/Manages/Category/Index')
                ->has('error')
            );
    }

    public function test_to_insert_empty_data(): void
    {
        $admin = Petugas::factory()->create();

        $this->actingAs($admin, 'petugas')
            ->post(route('crud_category.store'))
            ->assertInertia(
                function ($page) {
                    $page->component('Petugas/Manages/Category/Index');
                    $page->has('errors.category', 'The category field is required');       
                }
            );

    }

    public function test_to_edit_page(): void
    {
        $petugas = Petugas::factory()->create();
        $category = Category::factory()->create();
        $response = $this->actingAs($petugas, 'petugas')->get(route('crud_category.edit', $category->id));

        $this->assertAuthenticated();
        $response->assertOk();
    }

    public function test_to_update_data(): void
    {
        $petugas = Petugas::factory()->create();
        $category = Category::factory()->create();
        $updated = [ 'category' => 'updated category' ];
        $response = $this->actingAs($petugas, 'petugas')->put(route('crud_category.update', $category->id), $updated);

        $response->assertStatus(200);
        $this->assertAuthenticated();
        $this->assertDatabaseHas('categories', $updated);
    }
    
    public function test_to_fail_update_data(): void
    {
        $petugas = Petugas::factory()->create();
        $response = $this->actingAs($petugas, 'petugas')->post(route('crud_category.update', 'wow-data'), [
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
        $response = $this->actingAs($petugas, 'petugas')->post(route('crud_category.destroy', $category->id));

        $this->assertAuthenticated();
        $response->assertOk();
        $response->assertRedirectToRoute('crud_category.index');
    }
}
