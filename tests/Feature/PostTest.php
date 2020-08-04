<?php

namespace Tests\Feature;

use App\Book;
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
        $this->actingAs($user)->post('/post/create',$this->requestArrayBook())->assertOk();
        $response = $this->actingAs($user)->post('/post',
            array_merge($this->requestArrayPost(),$this->requestArrayBook()));
        $response->assertRedirect('/');
    }

    /** @test
     * Userが投稿を閲覧でき、閲覧数カウントがカウントされるテスト
     */
    public function a_user_can_visit_a_post_page()
    {
        //Userが投稿作成を行う
        $user1 = factory(User::class)->create();
        $this->actingAs($user1)->post('/post/create',$this->requestArrayBook())->assertOk();
        $data = factory(Post::class)->make();
        $this->actingAs($user1)->post('/post/',
            array_merge([
                'thumbnail_comment' => $data->thumbnail_comment,
                'main_content' => $data->main_content,
                'post_state' => 1,
            ],$this->requestArrayBook()))
            ->assertRedirect('/');
        //複数のUserが投稿にアクセスする
        $users = factory(User::class,5)->create();
        foreach ($users as $user){
            $this->actingAs($user)->get('/post/'.$user1->posts()->first()->id);
        }
        //自分の投稿にアクセスしてもカウントされない。
        $this->actingAs($user1)->get('/post/'.$user1->posts()->first()->id);
        $this->assertEquals(5,$user1->posts()->first()->viewed_count);
    }

    /** @test
     * 非公開、または下書きの投稿でUserが閲覧できないテスト
     */
    public function a_user_can_not_visit_a_post_page()
    {
        //Userが投稿作成を行う
        $user1 = factory(User::class)->create();
        $this->actingAs($user1)->post('/post/create',$this->requestArrayBook())->assertOk();
        $data = factory(Post::class)->make();
        //非公開で投稿
        $this->actingAs($user1)->post('/post/',
            array_merge([
                'thumbnail_comment' => $data->thumbnail_comment,
                'main_content' => $data->main_content,
                'post_state' => 2,
            ],$this->requestArrayBook()))
            ->assertRedirect('/');
        //下書きで投稿
        $this->actingAs($user1)->post('/post/',
            array_merge([
                'thumbnail_comment' => $data->thumbnail_comment,
                'main_content' => $data->main_content,
                'post_state' => 3,
            ],$this->requestArrayBook()))
            ->assertRedirect('/');
        //複数のUserが投稿にアクセスする
        $users = factory(User::class,5)->create();
        foreach ($users as $user){
            $this->actingAs($user)->get('/post/'.$user1->posts()->first()->id);
            $this->actingAs($user)->get('/post/'.$user1->posts()->skip(1)->first()->id);
        }
        //自分の投稿にアクセスしてもカウントされない。
        $this->actingAs($user1)->get('/post/'.$user1->posts()->first()->id);
        $this->actingAs($user1)->get('/post/'.$user1->posts()->skip(1)->first()->id);
        $this->assertEquals(0,$user1->posts()->first()->viewed_count);
        $this->assertEquals(0,$user1->posts()->skip(1)->first()->viewed_count);
    }

    /** @test
     * Userが投稿を更新できることのテスト
     */
    public function a_user_can_update_a_post()
    {
        //Userが投稿作成を行う
        $user = factory(User::class)->create();
        $this->actingAs($user)->post('/post',
            array_merge($this->requestArrayPost(),$this->requestArrayBook()))
            ->assertRedirect('/');
        //User編集ページにアクセスする
        $this->actingAs($user)->get('/post/'.$user->posts()->first()->id.'/edit')->assertOk();
        $requestUpdateArray = array_merge($this->requestArrayPost(),$this->requestArrayBook());
        //Userが投稿内容編集する
        $response = $this->actingAs($user)->patch('/post/'.$user->posts()->first()->id,[
            'thumbnail_comment' => $requestUpdateArray['thumbnail_comment'],
            'main_content' => $requestUpdateArray['main_content'],
            'post_state' => $requestUpdateArray['post_state'],
        ]);
        $response->assertRedirect("/post/{$user->posts()->first()->id}");
    }

    /** @test
     * Userが投稿を削除できることのテスト
     */
    public function a_user_can_delete_a_post()
    {
        //Userが投稿作成を行う
        $user = factory(User::class)->create();
        $this->actingAs($user)->post('/post',
            array_merge($this->requestArrayPost(),$this->requestArrayBook()))
            ->assertRedirect('/');
        //Userが編集ページにアクセスする
        $this->actingAs($user)->get('/post/'.$user->posts()->first()->id.'/edit')->assertOk();
        //Userが投稿を削除する
        $response = $this->actingAs($user)->delete('/post/'.$user->posts()->first()->id);
        $response->assertRedirect('/');
    }



    //投稿作成時のダミーデータ
    private function requestArrayPost(): array
    {
        $post_data = factory(Post::class)->make();
        $array = [
            'thumbnail_comment' => $post_data->thumbnail_comment,
            'main_content' => $post_data->main_content,
            'post_state' => $post_data->post_state,
            ];
        return $array;
    }
    private function requestArrayBook(): array
    {
        $book_data = factory(Book::class)->make();
        $array = [
            'bookCode' => $book_data->bookCode,
            'title' => $book_data->title,
            'infoLink' => $book_data->infoLink,
            'authors' => $book_data->authors,
            'publishedDate' => $book_data->publishedDate,
            'pageCount' => $book_data->pageCount,
            'description' => $book_data->description,
            'thumbnail' => $book_data->thumbnail,

        ];
        return $array;
    }
}
