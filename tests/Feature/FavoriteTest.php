<?php

namespace Tests\Feature;

use App\Book;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;
    /** @test お気に入り追加のテスト */
    public function a_user_can_add_a_post_favorite()
    {
        $user_1 = factory(User::class)->create();
        $user_2 = factory(User::class)->create();
        $user_3 = factory(User::class)->create();
        //投稿を作成する
        $this->actingAs($user_2)->post('/post', $this->requestArray());
        $this->actingAs($user_3)->post('/post', $this->requestArray());
        //投稿をお気に入りに追加する
        $this->actingAs($user_1)->post('/favorite/' . $user_2->posts()->first()->id);
        $this->actingAs($user_1)->post('/favorite/' . $user_3->posts()->first()->id);
        $likeCount = count($user_1->likes()->get());
        $this->assertCount(3, User::all());
        $this->assertCount(2, Post::all());
        $this->assertEquals(2, $likeCount);
    }

    /** @test お気に入り解除wのテスト */
    public function a_user_can_remove_a_post_favorite()
    {
        $user_1 = factory(User::class)->create();
        $user_2 = factory(User::class)->create();
        $user_3 = factory(User::class)->create();
        //投稿を作成する
        $this->actingAs($user_2)->post('/post', $this->requestArray());
        $this->actingAs($user_3)->post('/post', $this->requestArray());
        //投稿をお気に入りに追加する
        $this->actingAs($user_1)->post('/favorite/' . $user_2->posts()->first()->id);
        $this->actingAs($user_1)->post('/favorite/' . $user_3->posts()->first()->id);
        $this->assertCount(2, $user_1->likes);
        //お気に入りから１つ削除する
        $this->actingAs($user_1)->post('/favorite/' . $user_2->posts()->first()->id);

        $likeCount = count($user_1->likes()->get());
        $this->assertCount(3, User::all());
        $this->assertEquals(1, $likeCount);
    }


    //投稿作成時のダミーデータ
    private function requestArray(): array
    {
        $post_data = factory(Post::class)->make();
        $book_data = factory(Book::class)->make();
        $array = [
            'thumbnail_comment' => $post_data->thumbnail_comment,
            'main_content' => $post_data->main_content,
            'post_state' => $post_data->post_state,
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
