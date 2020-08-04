<?php

namespace Tests\Feature;

use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test Profileのedit機能テスト*/
    public function a_profile_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        //UserがProfile編集ページにアクセスする
        $this->actingAs($user)->get('/profile/'.$user->id.'/edit')->assertOk();
        //UserがProfile内容を変更する
        Storage::fake('s3');
        $test_image = UploadedFile::fake()->image('test.png');
        $response = $this->actingAs($user)->patch('/profile/' . $user->id
            ,[$this->requestArray(),'prof_image'=>$test_image]);
        $response->assertRedirect("/profile/{$user->id}");
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
