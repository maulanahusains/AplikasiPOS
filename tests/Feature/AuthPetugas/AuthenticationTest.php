<?php

namespace Tests\Feature\AuthPetugas;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Petugas;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.php 
     */
    public function test_to_access_login_admin(): void
    {
        $response = $this->get('/adminp4nel');

        $response->assertStatus(200);
    }
    
    public function test_to_authenticate_admin(): void {
        $admin = Petugas::factory()->create();
        
        $response = $this->post(route('postlogin.petugas', 'Admin'), [
            'username' => $admin->username,
            'password' => 'password'
        ]);

        $this->assertAuthenticated('petugas');
        $response->assertRedirectToRoute('dashboard.admin');
    }

    public function test_to_fail_authenticate_admin(): void {
        $admin = Petugas::factory()->create();
        
        $response = $this->post(route('postlogin.petugas', 'Admin'), [
            'username' => $admin->username,
            'password' => 'wrong-password'
        ]);

        $this->assertGuest();
    }
    
    public function test_to_authenticate_petugas(): void {
        $petugas = Petugas::factory()->create([
            'level' => 'Kasir'
        ]);
        
        $response = $this->post(route('postlogin.petugas', 'Kasir'), [
            'username' => $petugas->username,
            'password' => 'password'
        ]);

        $this->assertAuthenticated('petugas');
        $response->assertRedirectToRoute('dashboard.petugas');
    }

    public function test_to_fail_authenticate_petugas(): void {
        $petugas = Petugas::factory()->create([
            'level' => 'Kasir'
        ]);
        
        $response = $this->post(route('postlogin.petugas', 'Kasir'), [
            'username' => $petugas->username,
            'password' => 'wrong-password'
        ]);

        $this->assertGuest();
    }

    public function test_to_can_logout_admin(): void {
        $admin = Petugas::factory()->create();
        
        $response = $this->actingAs($admin, 'petugas')->post(route('logout.petugas'));

        $this->assertGuest();
        $response->assertRedirectToRoute('login.petugas');
    }

    public function test_to_can_logout_petugas(): void {
        $petugas = Petugas::factory()->create([
            'level' => 'Kasir'
        ]);
        
        $response = $this->actingAs($petugas, 'petugas')->post(route('logout.petugas'));

        $this->assertGuest();
        $response->assertRedirectToRoute('login.petugas');
    }
}
