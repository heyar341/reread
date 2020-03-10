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
//        $this->withoutExceptionHandling();
        $user = factory(User::class , 3)->create();
//                                    ↑作成するインスタンスの数
        $user_1 = $user->find(1);
        $user_2 = $user->find(2);
        $user_3 = $user->find(3);

        $this->actingAs($user_1)->post('/follow/'.$user_2->id);
        $this->actingAs($user_1)->post('/follow/'.$user_3->id);

        $follows = $user_1->following()->count();

        $this->assertCount(3,User::all());
        $this->assertEquals(2,$follows);
    }

    /** @test UnFollowのテスト */
    public function a_user_can_un_follow_another_user()
    {
//        $this->withoutExceptionHandling();
        $user = factory(User::class , 3)->create();
//                                 ↓Refreshdatabaseを使っても、パフォーマンスの関係から、オートインクリメントはリセットされない。
        $user_1 = $user->find(4);
        $user_2 = $user->find(5);
        $user_3 = $user->find(6);

        $this->actingAs($user_1)->post('/follow/'.$user_2->id);
        $this->actingAs($user_1)->post('/follow/'.$user_3->id);
        $this->assertCount(2,$user_1->following);
// Unfollowする
        $this->actingAs($user_1)->post('/follow/'.$user_2->id);

        $follows = $user_1->following()->count();
        $this->assertCount(3,User::all());
        $this->assertEquals(1,$follows);
    }
}
