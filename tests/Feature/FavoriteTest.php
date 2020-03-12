<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    /** @test Followのテスト */
    use RefreshDatabase;
    public function a_user_can_add_a_post_favorite()
    {

        $user = factory(User::class , 3)->create();
//                                    ↑作成するインスタンスの数
        $user_1 = $user->find(1);
        $user_2 = $user->find(2);
        $user_3 = $user->find(3);

        //投稿を作成する
        $this->actingAs($user_2)->post('/post', $this->requestArray());
        $this->actingAs($user_3)->post('/post', $this->requestArray());

        //投稿をお気に入りに追加する
        $this->actingAs($user_1)->post('/favorite/'.$user_2->posts()->first()->id);
        $this->actingAs($user_1)->post('/favorite/'.$user_3->posts()->first()->id);

        $likeCount = $user_1->likes()->count();

        $this->assertCount(3,User::all());
        $this->assertCount(2,Post::all());
        $this->assertEquals(2,$likeCount);
    }

//    /** @test UnFollowのテスト */
    public function a_user_can_un_follow_another_user()
    {
        $user = factory(User::class , 3)->create();
//                                 ↓Refreshdatabaseを使っても、パフォーマンスの関係から、オートインクリメントはリセットされない。
        $user_1 = $user->find(4);
        $user_2 = $user->find(5);
        $user_3 = $user->find(6);

        //投稿を作成する
        $this->actingAs($user_2)->post('/post', $this->requestArray());
        $this->actingAs($user_3)->post('/post', $this->requestArray());

        //投稿をお気に入りに追加する
        $this->actingAs($user_1)->post('/favorite/'.$user_2->posts()->first()->id);
        $this->actingAs($user_1)->post('/favorite/'.$user_3->posts()->first()->id);
        $this->assertCount(2,$user_1->likes);
        //お気に入りから１つ削除する
        $this->actingAs($user_1)->post('/favorite/'.$user_2->posts()->first()->id);

        $likeCount = $user_1->likes()->count();
        $this->assertCount(3,User::all());
        $this->assertEquals(1,$likeCount);
    }


    //投稿作成時のダミーデータ
    private function requestArray(): array
    {
        $data = factory(Post::class)->make()->toArray();
        $array = [
            'thumbnail_comment' => $data['thumbnail_comment'],
            'main_content' => $data['main_content'],
            'post_state' => $data['post_state'],
        ];
        return $array;
    }
}
