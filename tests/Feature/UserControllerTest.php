<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $response = $this->get('/login');
        $response->assertSeeText("Login");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "daffa",
            "password" => "rahasia"])
            ->assertRedirect('/')
            ->assertSessionHas('user', 'daffa');
    }

    public function testLoginValidationError(){
        $this->post('/login', [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed(){
        $this->post('/login', [
            "user" => "sada",
            "password" => "salah"])
            ->assertSeeText("User or password is Wrong");
    }

    // public function testL
    public function testLogout()
    {
        $this->withSession([
            "user" => "daffa"
        ])->post('/logout')
        ->assertRedirect("/")
        ->assertSessionMissing("user");
    }
}
