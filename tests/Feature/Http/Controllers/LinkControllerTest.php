<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCanAccessLinkLoggedIn()
    {
        // Log the user in.
        $this->actingAs(User::factory()->create());

        $link = Link::factory()->create();

        $this->assertIsString($link->hash);

        $this->get(route('link', ['hash' => $link->hash]))
            ->assertRedirect($link->url);
    }

    public function testCanAccessLinkLoggedOut()
    {
        $link = Link::factory()->create();

        $this->assertIsString($link->hash);

        $this->get(route('link', ['hash' => $link->hash]))
            ->assertRedirect('/auth/login');
    }
}
