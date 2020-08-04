<?php

namespace Tests\Unit;

use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /** @test */
    use RefreshDatabase;

    public function not_login_profile_controller_test()
    {
        $this->get('/profile/1')->assertRedirect('/login');
        $this->get('/profile/1/edit')->assertRedirect('/login');
    }

    /** @test */
    public function login_profile_controller_test()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/profile/' . $user->id . '/edit')->assertOk();
        //UserがProfile内容を変更する
        Storage::fake('s3');
        $dummy = UploadedFile::fake()->image('aaa.png');
        $response = $this->actingAs($user)->patch('/profile/' . $user->id,
            [$this->requestArray(), 'prof_image' => $dummy]);
        $response->assertRedirect("/profile/{$user->id}");
    }

    /** @test */
    public function profile_controller_access_another_user_page()
    {
        //他のユーザーページにアクセスしようとすると弾かれてホームページに飛ばされる。
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();
        $this->actingAs($user2)->get("/profile/{$user3->id}")->assertRedirect('/')
            ->assertSessionHas('error', '他のユーザーのページです。');
        $this->actingAs($user2)->get("/profile/{$user3->id}/edit")->assertRedirect('/')
            ->assertSessionHas('error', '他のユーザーのページです。');
    }

    /** @test */
    public function profile_controller_access_not_existing_page()
    {
        //存在しないページにアクセスすると404コードが返ってくる。
        $user4 = factory(User::class)->create();
        $this->actingAs($user4)->get('/profile/10')->assertStatus(404);
        $this->actingAs($user4)->get('/profile/foo')->assertStatus(404);
        $this->actingAs($user4)->get('/profile/10/edit')->assertStatus(404);
        $this->actingAs($user4)->get('/profile/foo/edit')->assertStatus(404);
        $this->get('/profile/10')->assertStatus(404);
        $this->get('/profile/foo')->assertStatus(404);
        $this->get('/profile/10/edit')->assertStatus(404);
        $this->get('/profile/foo/edit')->assertStatus(404);
    }

    //Profile更新時のダミーデータ
    private function requestArray(): array
    {
        $data = factory(Profile::class)->make();
        $array = [
            'intro_self' => $data->intro_self,
            'prof_url' => $data->prof_url,
        ];
        return $array;
    }
}
