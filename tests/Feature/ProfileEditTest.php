<?php

namespace Tests\Feature;

use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileEditTest extends TestCase
{
    /** @test Profileのedit機能テスト*/
    use RefreshDatabase;
    public function a_profile_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->patch('/profile/' . $user->id,[
//          ダミーデータで書き換え
            factory(Profile::class)->make(),
        ]);
        $response->assertRedirect("/profile/{$user->id}");

    }
}
