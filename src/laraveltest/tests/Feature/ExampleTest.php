<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Acount;
use App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {

        $acount = Acount::factory()->create();
        $response = $this->actingAs($acount)->post(
            route('disp.search')
        );
        $response->assertStatus(200);
    }
}
