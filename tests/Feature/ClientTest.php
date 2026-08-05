<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


beforeEach(function () {

    $this->user = User::factory()->create();

    $this->actingAs($this->user);

});


it('can display clients page', function () {

    Client::factory()
        ->count(5)
        ->create();


    $response = $this->get(
        route('clients.index')
    );


    $response
        ->assertOk()
        ->assertInertia(fn ($page) =>
            $page->component('Clients/Index')
        );

});


it('can create client', function () {

    $response = $this->post(
        route('clients.store'),
        [

            'name' => 'Test Company',

            'tax_number' => 'IE1234567',

            'email' => 'client@test.com',

            'phone' => '+3531234567',

            'street' => 'Main Street 10',

            'city' => 'Dublin',

            'postal_code' => 'D01AB12',

            'country' => 'Ireland',

        ]
    );


    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect();


    $this->assertDatabaseHas('clients', [

        'name' => 'Test Company',

        'tax_number' => 'IE1234567',

        'email' => 'client@test.com',

        'phone' => '+3531234567',

        'street' => 'Main Street 10',

        'city' => 'Dublin',

        'postal_code' => 'D01AB12',

        'country' => 'Ireland',

    ]);

});


it('validates required client fields', function () {


    $response = $this->post(
        route('clients.store'),
        []
    );


    $response->assertSessionHasErrors([

        'name',
        'tax_number',

    ]);

});


it('can show client details', function () {


    $client = Client::factory()->create();


    $response = $this->get(
        route('clients.show', $client)
    );


    $response
        ->assertOk()
        ->assertInertia(fn ($page) =>
            $page->component('Clients/Show')
        );

});


it('can update client', function () {


    $client = Client::factory()->create();


    $response = $this->put(

        route('clients.update', $client),

        [

            'name' => 'Updated Company',

            'tax_number' => 'IE9999999',

            'email' => 'updated@test.com',

            'phone' => '+3539999999',

            'street' => 'Updated Street',

            'city' => 'Cork',

            'postal_code' => 'T12AB12',

            'country' => 'Ireland',

        ]

    );


    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect();


    $this->assertDatabaseHas('clients', [

        'id' => $client->id,

        'name' => 'Updated Company',

        'email' => 'updated@test.com',

        'city' => 'Cork',

    ]);

});


it('can soft delete client', function () {


    $client = Client::factory()->create();


    $response = $this->delete(

        route('clients.destroy', $client)

    );


    $response
        ->assertRedirect();


    $this->assertSoftDeleted(
        'clients',
        [
            'id' => $client->id
        ]
    );

});