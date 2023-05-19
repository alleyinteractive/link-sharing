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

    public function testCanAccessFromVpn()
    {
        $link = Link::factory()->create();

        config()->set('auth.alley_vpn', '1.2.3.4');

        // Set the user's IP address to the VPN IP address.
        $this->get(route('link', ['hash' => $link->hash]), [
            'REMOTE_ADDR' => '1.2.3.4',
        ])->assertRedirect($link->url);
    }
}
