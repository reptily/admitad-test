<?php

namespace Tests\Feature;

use App\Link;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Тестируем переадресацию
     *
     * @return void
     */
    public function testRedirect()
    {
        $link = factory(Link::class)->create();

        $response = $this->get('/s/' . $link->key);

        $response->assertStatus(302);
        $response->assertRedirect($link->redirect_to);
    }

    /**
     * Тестируем если время жизни ссылки кончалось
     */
    public function testRedirectIfDeadTime()
    {
        $link = factory(Link::class)->create([
            'undead' => 0,
            'dead_time' => '1975-01-01'
        ]);

        $response = $this->get('/s/' . $link->key);

        $response->assertStatus(302);
        $response->assertRedirect("/");
    }
}
