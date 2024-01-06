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
                ->has('errors')
            );
    }

    public function test_to_insert_empty_data(): void
    {
        $admin = Petugas::factory()->create();

        $cuk = $this->actingAs($admin, 'petugas')
            ->assertAuthenticated()
            ->post(route('crud_category.store'), [])
            ->assertInertia(
            fn (Assert $page) => $page
                ->component('Petugas/Manages/Category/Index')
                // cek validation error
                ->has('errors')       
        );
    }

    public function test_to_edit_page(): void
    {
        $admin = Petugas::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($admin, 'petugas')
            ->assertAuthenticated()
            ->get(route('crud_category.edit', $category->id))
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Petugas/Manages/Category/Edit')
                    ->has('category')
            );
    }

    public function test_to_update_data(): void
    {
        $petugas = Petugas::factory()->create();
        $category = Category::factory()->create();
        $updated = [ 'category' => 'updated category' ];
        
        $this->actingAs($petugas, 'petugas')
            ->assertAuthenticated()
            ->put(route('crud_category.update', $category->id), $updated)
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Petugas/Manages/Category/Index')
                    ->has('success')
            );
    }
    
    public function test_to_fail_update_data(): void
    {
        $updated = [ 'category' => 'updated category' ];
        $petugas = Petugas::factory()->create();
        
        $this->actingAs($petugas, 'petugas')
        ->assertAuthenticated()
        ->put(route('crud_category.update', 'wowo'), $updated)
        ->assertInertia(
            fn(Assert $page) => $page
                ->component('Petugas/Manages/Category/Index')
                ->has('success')
        );
    }   
    
    public function test_to_delete_data(): void
    {
        $petugas = Petugas::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($petugas, 'petugas')
            ->assertAuthenticated()
            ->delete(route('crud_category.destroy', $category->id))
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Petugas/Manages/Category/Index')
                    ->has('success')
            );
    }
}
