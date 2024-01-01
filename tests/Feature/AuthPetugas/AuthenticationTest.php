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
        $admin = Petugas::factory()->create([
            'level' => 'Admin'
        ]);
        
        $response = $this->post('/adminp4nel/login', [
            'username' => $admin->username,
            'password' => 'password'
        ]);

        $this->assertAuthenticated('petugas');
        $response->assertRedirectToRoute('dashboard.admin');
    }

    public function test_to_fail_authenticate_admin(): void {
        $admin = Petugas::factory()->create([
            'level' => 'Admin'
        ]);
        
        $response = $this->post('/adminp4nel/login', [
            'username' => $admin->username,
            'password' => 'wrong-password'
        ]);

        $this->assertGuest();
    }
    
    public function test_to_authenticate_petugas(): void {
        $petugas = Petugas::factory()->create([
            'level' => 'Kasir'
        ]);
        
        $response = $this->post('/adminp4nel/login', [
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
        
        $response = $this->post('/adminp4nel/login', [
            'username' => $petugas->username,
            'password' => 'wrong-password'
        ]);

        $this->assertGuest();
    }

    public function test_to_can_logout_admin(): void {
        $admin = Petugas::factory()->create([
            'level' => 'Admin'
        ]);
        
        $response = $this->actingAs($admin)->get('/adminp4nel/logout');

        $this->assertGuest();
        $response->assertRedirectToRoute('login.petugas');
    }
}
