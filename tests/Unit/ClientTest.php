<?php

namespace Tests\Unit;

use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testClientIndexGuest()
    {
        $response = $this->get(route('clients.index'));
        $response->assertRedirect();
    }

}
