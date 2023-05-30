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

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "daffa"
        ])->get('/login')->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "daffa",
            "password" => "rahasia"])
            ->assertRedirect('/')
            ->assertSessionHas('user', 'daffa');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "daffa"
        ])->post('/login', [
            "user" => "daffa",
            "password" => "rahasia"])
            ->assertRedirect('/');
        
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

    public function testLogoutGuest()
    {
        $this->post('/logout')
        ->assertRedirect("/");
        
    }
}
