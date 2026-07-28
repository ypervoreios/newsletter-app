<?php

use App\Models\Campaign;
use App\Models\User;

it('shows an edit button on the campaign preview page', function () {
    $user = new User([
        'id' => 1,
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => 'secret',
    ]);
    $campaign = Campaign::create([
        'title' => 'Spring Campaign',
        'subject' => 'Hello there',
        'content' => '<p>Preview content</p>',
    ]);

    $response = $this->actingAs($user)->get(route('campaigns.preview', $campaign));

    $response->assertOk();
    $response->assertSee('Edit campaign');
    $response->assertSee(route('campaigns.edit', $campaign));
});
