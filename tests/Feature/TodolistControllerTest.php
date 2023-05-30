<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "daffa",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Daffa"
                ],
                [
                    "id" => "2",
                    "todo" => "Julistio"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Daffa")
            ->assertSeeText("2")
            ->assertSeeText("Julistio");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "daffa"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "daffa"
        ])->post("/todolist", [
            "todo" => "Daffa"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "daffa",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Daffa"
                ],
                [
                    "id" => "2",
                    "todo" => "Julistio"
                ]
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }
}
