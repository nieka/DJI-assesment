<?php

namespace Tests\Feature;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateMessageApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateMessageWithoutColleague(): void
    {
        $text = "Pannekoeken vanavond?";
        $response = $this->postJson(
            route('messages.store'),
            [
                'message' => $text,
                'email' => null
            ]
        );

        $response->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('password')
                    ->has('uuid')
            );

        $password = $response->json('password');
        $uuid = $response->json('uuid');
        $message = Message::find($uuid);

        $this->assertNotNull($message);
        $this->assertEquals($text, $message->getDecryptedMessage($password));
    }


    public function testCreateMessageWithColleague(): void
    {
        $text = "Pannekoeken vanavond?";
        $email = "niekhoek@mailinator.com";
        $response = $this->postJson(
            route('messages.store'),
            [
                'message' => $text,
                'email' => $email
            ]
        );

        $response->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('password')
                    ->has('uuid')
            );

        $password = $response->json('password');
        $uuid = $response->json('uuid');
        $message = Message::find($uuid);

        $this->assertNotNull($message);
        $this->assertEquals($text, $message->getDecryptedMessage($password));

        $colleague = $message->colleague;
        $this->assertNotNull($colleague);
        $this->assertEquals($email, $colleague->email);
    }

    public function testCreateMessageAndRetrieveIt(): void
    {
        $text = "Pannekoeken vanavond?";
        $response = $this->postJson(
            route('messages.store'),
            [
                'message' => $text,
                'email' => null
            ]
        );

        $response->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->has('password')
                ->has('uuid')
            );

        $password = $response->json('password');
        $uuid = $response->json('uuid');
        $message = Message::find($uuid);

        $this->assertNotNull($message);

        $response = $this->get(route('messages.getMessage', $uuid) . "?password=" . $password);

        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('message')
            );

        $this->assertEquals($text, $response->json('message'));
    }

    public function testCreateMessageAndRetrieveItWithIncorrectPassword(): void
    {
        $text = "Pannekoeken vanavond?";
        $response = $this->postJson(
            route('messages.store'),
            [
                'message' => $text,
                'email' => null
            ]
        );

        $response->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->has('password')
                ->has('uuid')
            );

        $password = $response->json('password');
        $uuid = $response->json('uuid');
        $message = Message::find($uuid);

        $this->assertNotNull($message);

        $response = $this->getJson(route('messages.getMessage', $uuid) . "?password=" . $password . "231");

        $response
            ->assertStatus(401);
    }
}
