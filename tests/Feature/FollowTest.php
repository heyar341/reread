<?php

namespace Tests\Feature;

use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowTest extends TestCase
{
    /** @test Followのテスト */
    use RefreshDatabase;
    public function a_user_can_follow_another_user()
    {
        $user_1 = factory(User::class)->create();
        $user_2 = factory(User::class)->create();
        $user_3 = factory(User::class)->create();
        //user1がuser2とuer3をフォローする。
        $this->actingAs($user_1)->post('/follow/'.$user_2->id);
        $this->actingAs($user_1)->post('/follow/'.$user_3->id);
        $follows = count($user_1->following()->get());
        $this->assertCount(3,User::all());
        $this->assertEquals(2,$follows);
    }

    /** @test UnFollowのテスト */
    public function a_user_can_un_follow_another_user()
    {
        $user_1 = factory(User::class)->create();
        $user_2 = factory(User::class)->create();
        $user_3 = factory(User::class)->create();
        //user1がuser2とuer3をフォローする。
        $this->actingAs($user_1)->post('/follow/'.$user_2->id);
        $this->actingAs($user_1)->post('/follow/'.$user_3->id);
        $this->assertCount(2,$user_1->following);
        //Unfollowする
        $this->actingAs($user_1)->post('/follow/'.$user_2->id);
        $follows = count($user_1->following()->get());
        $this->assertCount(3,User::all());
        $this->assertEquals(1,$follows);
    }
}
