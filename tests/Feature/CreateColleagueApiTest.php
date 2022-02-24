<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateColleagueApiTest extends TestCase
{
    public function testGetColleagues(): void
    {
        $response = $this->get(route('colleagues.get'));

        $response->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has(4)
                    ->each(fn (AssertableJson $json) =>
                        $json->has('name')
                            ->has('email')
                    )
            );
    }
}
