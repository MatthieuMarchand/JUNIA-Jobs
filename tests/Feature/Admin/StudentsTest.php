<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_list(): void
    {
        $student = User::factory()->student()->create();

        $admin = User::factory()->admin()->create();
        $response = $this->actingAs($admin)->get('/admin/students');

        $response->assertStatus(200);
        $response->assertSee($student->email);
    }

    public function test_student_cannot_see_list(): void
    {
        $student = User::factory()->student()->create();

        $response = $this->actingAs($student)->get('/admin/students');

        $response->assertForbidden();
    }

    public function test_company_cannot_see_list(): void
    {
        $company = User::factory()->company()->create();

        $response = $this->actingAs($company)->get('/admin/students');

        $response->assertForbidden();
    }

    public function test_admin_can_delete_company_user(): void
    {
        $studentUser = User::factory()->student()->create();

        $admin = User::factory()->admin()->create();
        $response = $this->actingAs($admin)->delete("/admin/students/$studentUser->id");

        $response->assertRedirect('/admin/students');

        $this->assertCount(1, User::all());
    }

    public function test_student_cannot_delete_company_user(): void
    {
        $studentUser = User::factory()->student()->create();

        $student = User::factory()->student()->create();
        $response = $this->actingAs($student)->delete("/admin/students/$studentUser->id");

        $response->assertForbidden();

        $this->assertCount(2, User::all());
    }

    public function test_company_cannot_delete_company_user(): void
    {
        $studentUser = User::factory()->student()->create();

        $company = User::factory()->company()->create();
        $response = $this->actingAs($company)->delete("/admin/students/$studentUser->id");

        $response->assertForbidden();

        $this->assertCount(2, User::all());
    }
}
