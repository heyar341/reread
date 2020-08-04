<?php

namespace Tests\Unit;

use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFake;

class UserTest extends TestCase
{
    /** @test */

    use RefreshDatabase;

    public function user_and_profile_can_be_created()
    {
        $user = factory(User::class)->create();

        $this->assertCount(1,User::all());
        $this->assertCount(1,Profile::all());
    }
}
