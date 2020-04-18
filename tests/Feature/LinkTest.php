<?php

namespace Tests\Feature;

use App\Link;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LinkTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Тестируем создание бессрочной ссылки не авторизированным пользователем
     *
     * @return void
     */
    public function testCreateLinkUndeadNoauthTest()
    {
        $url = "https://ya.ru";

        $response = $this->post('/create_link',[
            "link" => $url
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(["key"]);

        $link = Link::where("key", $response->json("key"))->first();
        $this->assertNotEmpty($link);
        $this->assertEquals($link->redirect_to, $url);
        $this->assertEquals($link->undead, 1);
        $this->assertEquals($link->dead_time, null);
    }


    /**
     * Тестируем создание бессрочной ссылки авторизированным пользователем
     *
     * @return void
     */
    public function testCreateLinkUndeadAuthTest()
    {
        $url = "https://ya.ru";
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, "web")->post('/create_link',[
            "link" => $url
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(["key"]);

        $link = Link::where("key", $response->json("key"))->first();
        $this->assertNotEmpty($link);
        $this->assertEquals($link->redirect_to, $url);
        $this->assertEquals($link->undead, 1);
        $this->assertEquals($link->dead_time, null);
        $this->assertEquals($link->user_id, $user->id);
    }


    /**
     *  Тестируем создание ссылки с временным ограничением не авторизованным пользователем
     */
    public function testCreateLinkDeadLinkNoauthTest(){
        $date = "2020-04-10T07:41:00.000Z";
        $url = "https://ya.ru";

        $response = $this->post('/create_link',[
            "link" => $url,
            "dead_time" => $date
        ]);

        $response->assertStatus(201);
        $link = Link::where("key", $response->json("key"))->first();
        $this->assertNotEmpty($link);
        $this->assertEquals($link->redirect_to, $url);
        $this->assertEquals($link->undead, 0);
        $this->assertEquals($link->dead_time, Carbon::parse($date)->format("Y-m-d"));
    }


    /**
     *  Тестируем создание ссылки с временным ограничением авторизованного пользователя
     */
    public function testCreateLinkDeadLinkAuthTest(){
        $date = "2020-04-10T07:41:00.000Z";
        $url = "https://ya.ru";

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, "web")->post('/create_link',[
            "link" => $url,
            "dead_time" => $date
        ]);

        $response->assertStatus(201);
        $link = Link::where("key", $response->json("key"))->first();
        $this->assertNotEmpty($link);
        $this->assertEquals($link->redirect_to, $url);
        $this->assertEquals($link->undead, 0);
        $this->assertEquals($link->dead_time, Carbon::parse($date)->format("Y-m-d"));
        $this->assertEquals($link->user_id, $user->id);
    }
}
