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
        $this->actingAs($user)->get('/mypage/'.$user->id)->assertOk();
        $this->actingAs($user)->get('/mypage/favorite/'.$user->id)->assertOk();
        $this->actingAs($user)->get('/mypage/'.$user->id.'/postshow')->assertOk();
        $this->actingAs($user)->get('/follow/'.$user->id.'/show')->assertOk();
        $this->actingAs($user)->get('/follower/'.$user->id.'/show')->assertOk();
        $this->actingAs($user)->get('/mypage/'.$user->id.'/delete_confirm')->assertOk();
        $this->actingAs($user)->get('/mypage/'.$user->id.'/1')->assertOk();
        $this->actingAs($user)->post('/mypage/'.$user->id.'/delete')
            ->assertRedirect('/')->assertSessionHas('success', 'ユーザーアカウントを削除しました !');

        //他のユーザーページにアクセスしようとすると弾かれてホームページに飛ばされる。
        $other_user = factory(User::class)->create();
        $this->actingAs($user)->get('mypage/2')->assertRedirect('/')
            ->assertSessionHas('error','他のユーザーのページです。');
        $this->actingAs($user)->get('mypage/favorite/2')->assertRedirect('/')
            ->assertSessionHas('error','他のユーザーのページです。');
        $this->actingAs($user)->get('mypage/2/postshow')->assertRedirect('/')
            ->assertSessionHas('error','他のユーザーのページです。');
        $this->actingAs($user)->get('follow/2/show')->assertRedirect('/')
            ->assertSessionHas('error','他のユーザーのページです。');
        $this->actingAs($user)->get('follower/2/show')->assertRedirect('/')
            ->assertSessionHas('error','他のユーザーのページです。');
        $this->actingAs($user)->get('mypage/2/delete_confirm')->assertRedirect('/')
            ->assertSessionHas('error','他のユーザーのページです。');
        $this->actingAs($user)->get('mypage/2/2')->assertRedirect('/')
            ->assertSessionHas('error','他のユーザーのページです。');

        //存在しないページにアクセスすると404コードが返ってくる。
        $this->actingAs($user)->get('/mypage/hoo')->assertStatus(404);
        $this->actingAs($user)->get('mypage/favorite/3')->assertStatus(404);
        $this->actingAs($user)->get('mypage/3/postshow')->assertStatus(404);
        $this->actingAs($user)->get('follow/3/show')->assertStatus(404);
        $this->actingAs($user)->get('follower/3/show')->assertStatus(404);
        $this->actingAs($user)->get('mypage/3/delete_confirm')->assertStatus(404);
        $this->actingAs($user)->get('mypage/3/3')->assertStatus(404);
        $this->actingAs($user)->get('mypage/1/4')->assertStatus(404);

    }
}

