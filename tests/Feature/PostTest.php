<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test
     * Userが投稿可能であることのテスト
     */

    public function a_user_can_create_a_post()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/post/create')->assertOk();
        $response = $this->actingAs($user)->post('/post', $this->requestArray());
        $response->assertRedirect('/post');

    }

    /** @test
     * Userが投稿を閲覧でき、閲覧数カウントがカウントされるテスト
     */
    public function a_user_can_visit_a_post_page()
    {
        //Userが投稿作成を行う
        $user1 = factory(User::class)->create();
        $this->actingAs($user1)->get('/post/create')->assertOk();
        $this->actingAs($user1)->post('/post/', $this->requestArray())->assertRedirect('/post');
        //複数のUserが投稿にアクセスする
        $users = factory(User::class,5)->create();
        foreach ($users as $user){
            $this->actingAs($user)->get('/post/'.$user1->posts()->first()->id)->assertOk();
        }
        $this->assertEquals(5,$user1->posts()->first()->viewed_count);
    }

    /** @test
     * Userが投稿を更新できることのテスト
     */
    public function a_user_can_update_a_post()
    {
        //Userが投稿作成を行う
        $user = factory(User::class)->create();
        $this->actingAs($user)->post('/post', $this->requestArray())->assertRedirect('/post');
        //User編集ページにアクセスする
        $this->actingAs($user)->get('/post/'.$user->posts()->first()->id.'/edit')->assertOk();
        $requestUpdateArray = factory(Post::class)->make()->toArray();
        //Userが投稿内容編集する
        $response = $this->actingAs($user)->patch('/post/'.$user->posts()->first()->id,[
            'thumbnail_comment' => $requestUpdateArray['thumbnail_comment'],
            'main_content' => $requestUpdateArray['main_content'],
            'post_state' => $requestUpdateArray['post_state'],
        ]);
        $response->assertRedirect('/post');
    }

    /** @test
     * Userが投稿を削除できることのテスト
     */
    public function a_user_can_delete_a_post()
    {
        //Userが投稿作成を行う
        $user = factory(User::class)->create();
        $this->actingAs($user)->post('/post', $this->requestArray())->assertRedirect('/post');
        //Userが編集ページにアクセスする
        $this->actingAs($user)->get('/post/'.$user->posts()->first()->id.'/edit')->assertOk();
        //Userが投稿を削除する
        $response = $this->actingAs($user)->delete('/post/'.$user->posts()->first()->id);
        $response->assertRedirect('/post');
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
