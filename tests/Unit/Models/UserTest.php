<?php

namespace Tests\Unit\Models;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_itself(): void
    {
        $userA = User::factory()->student()->create();

        $this->assertTrue(
            $userA->can('update', $userA)
        );
    }

    public function test_user_cannot_update_other(): void
    {
        $userA = User::factory()->student()->create();
        $userB = User::factory()->admin()->create();

        $this->assertTrue(
            $userA->cannot('update', $userB)
        );
    }

    public function test_admin_can_update_other(): void
    {
        $userA = User::factory()->admin()->create();
        $userB = User::factory()->student()->create();

        $this->assertTrue(
            $userA->can('update', $userB)
        );
    }
}
