<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    /** @test MypageControllerのテスト */
    use RefreshDatabase;

    public function not_login_mypage_controller_test()
    {
        $this->get('/')->assertOk();
        $this->get('mypage/favorite/1')->assertRedirect('/login');
        $this->get('mypage/1/postshow')->assertRedirect('/login');
        $this->get('follow/1/show')->assertRedirect('/login');
        $this->get('follower/1/show')->assertRedirect('/login');
        $this->get('mypage/1/delete_confirm')->assertRedirect('/login');
        $this->get('mypage/1/1')->assertRedirect('/login');
        $this->get('mypage/1')->assertRedirect('/login');
    }

    /** @test */
    public function login_mypage_controller_test()
    {
        //ログイン状態で、自分のページにアクセスする。
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->actingAs($user)->get('/mypage/' . $user->id)->assertOk();
        $this->actingAs($user)->get('/mypage/favorite/' . $user->id)->assertOk();
        $this->actingAs($user)->get('/mypage/' . $user->id . '/postshow')->assertOk();
        $this->actingAs($user)->get('/follow/' . $user->id . '/show')->assertOk();
        $this->actingAs($user)->get('/follower/' . $user->id . '/show')->assertOk();
        $this->actingAs($user)->get('/mypage/' . $user->id . '/delete_confirm')->assertOk();
        $this->actingAs($user)->get('/mypage/' . $user->id . '/1')->assertOk();
        $this->actingAs($user)->post('/mypage/' . $user->id . '/delete')
            ->assertRedirect('/')->assertSessionHas('success', 'ユーザーアカウントを削除しました !');
    }

    /** @test */
    public function mypage_controller_access_another_user_page()
    {
        //他のユーザーページにアクセスしようとすると弾かれてホームページに飛ばされる。
        $user2 = factory(User::class)->create();
        $other_user = factory(User::class)->create();
        $this->actingAs($user2)->get("mypage/{$other_user->id}")->assertRedirect('/')
            ->assertSessionHas('error', '他のユーザーのページです。');
        $this->actingAs($user2)->get("mypage/favorite/{$other_user->id}")->assertRedirect('/')
            ->assertSessionHas('error', '他のユーザーのページです。');
        $this->actingAs($user2)->get("mypage/{$other_user->id}/postshow")->assertRedirect('/')
            ->assertSessionHas('error', '他のユーザーのページです。');
        $this->actingAs($user2)->get("follow/{$other_user->id}/show")->assertRedirect('/')
            ->assertSessionHas('error', '他のユーザーのページです。');
        $this->actingAs($user2)->get("follower/{$other_user->id}/show")->assertRedirect('/')
            ->assertSessionHas('error', '他のユーザーのページです。');
        $this->actingAs($user2)->get("mypage/{$other_user->id}/delete_confirm")->assertRedirect('/')
            ->assertSessionHas('error', '他のユーザーのページです。');
        $this->actingAs($user2)->get("mypage/{$other_user->id}/2")->assertRedirect('/')
            ->assertSessionHas('error', '他のユーザーのページです。');
    }

    /** @test */
    public function mypage_controller_access_not_existing_page()
    {
        //存在しないページにアクセスすると404コードが返ってくる。
        $user3 = factory(User::class)->create();
        $this->actingAs($user3)->get('/mypage/hoo')->assertStatus(404);
        $this->actingAs($user3)->get('mypage/favorite/10')->assertStatus(404);
        $this->actingAs($user3)->get('mypage/10/postshow')->assertStatus(404);
        $this->actingAs($user3)->get('follow/10/show')->assertStatus(404);
        $this->actingAs($user3)->get('follower/10/show')->assertStatus(404);
        $this->actingAs($user3)->get('mypage/10/delete_confirm')->assertStatus(404);
        $this->actingAs($user3)->get('mypage/10/3')->assertStatus(404);
        $this->actingAs($user3)->get('mypage/1/4')->assertStatus(404);
        $this->get('/mypage/hoo')->assertStatus(404);
        $this->get('mypage/favorite/10')->assertStatus(404);
        $this->get('mypage/10/postshow')->assertStatus(404);
        $this->get('follow/10/show')->assertStatus(404);
        $this->get('follower/10/show')->assertStatus(404);
        $this->get('mypage/10/delete_confirm')->assertStatus(404);
        $this->get('mypage/10/3')->assertStatus(404);
        $this->get('mypage/1/4')->assertStatus(404);
    }
}

