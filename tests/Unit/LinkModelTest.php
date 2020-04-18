<?php

namespace Tests\Unit;

use App\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkModelTest extends TestCase
{
    use RefreshDatabase;

    public function testCreated()
    {
        $link = factory(Link::class)->create();

        $this->assertIsInt($link->id);
        $this->assertIsString($link->key);
        $this->assertIsInt($link->count_redirect);
        $this->assertIsString($link->redirect_to);
        $this->assertIsInt($link->user_id);
    }
}
