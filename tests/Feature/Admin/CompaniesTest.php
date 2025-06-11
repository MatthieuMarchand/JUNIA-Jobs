<?php

namespace Tests\Feature\Admin;

use App\Models\CompanyRegistrationRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompaniesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_list(): void
    {
        $approvedCompanyUser = User::factory()->company()->has(
            CompanyRegistrationRequest::factory()->state([
                'company_name' => 'Approved Company',
                'approved' => true,
            ])
        )->create();

        $unapprovedCompanyUser = User::factory()->company()->has(
            CompanyRegistrationRequest::factory()->state([
                'company_name' => 'Unapproved Company',
                'approved' => false,
            ])
        )->create();

        $admin = User::factory()->admin()->create();
        $response = $this->actingAs($admin)->get('/admin/companies');

        $response->assertStatus(200);
        $response->assertSee($approvedCompanyUser->email);
        $response->assertDontSee($unapprovedCompanyUser->email);
    }

    public function test_student_cannot_see_list(): void
    {
        $student = User::factory()->student()->create();

        $response = $this->actingAs($student)->get('/admin/companies');

        $response->assertForbidden();
    }

    public function test_company_cannot_see_list(): void
    {
        $company = User::factory()->company()->create();

        $response = $this->actingAs($company)->get('/admin/companies');

        $response->assertForbidden();
    }

    public function test_admin_can_delete_company_user(): void
    {
        $companyUser = User::factory()->company()->has(
            CompanyRegistrationRequest::factory()->state([
                'company_name' => 'Approved Company',
                'approved' => true,
            ])
        )->create();

        $admin = User::factory()->admin()->create();
        $response = $this->actingAs($admin)->delete("/admin/companies/$companyUser->id");

        $response->assertRedirect('/admin/companies');

        $this->assertCount(1, User::all());
    }

    public function test_student_cannot_delete_company_user(): void
    {
        $companyUser = User::factory()->company()->has(
            CompanyRegistrationRequest::factory()->state([
                'company_name' => 'Approved Company',
                'approved' => true,
            ])
        )->create();

        $student = User::factory()->student()->create();
        $response = $this->actingAs($student)->delete("/admin/companies/$companyUser->id");

        $response->assertForbidden();

        $this->assertCount(2, User::all());
    }

    public function test_company_cannot_delete_company_user(): void
    {
        $companyUser = User::factory()->company()->has(
            CompanyRegistrationRequest::factory()->state([
                'company_name' => 'Approved Company',
                'approved' => true,
            ])
        )->create();

        $company = User::factory()->company()->create();
        $response = $this->actingAs($company)->delete("/admin/companies/$companyUser->id");

        $response->assertForbidden();

        $this->assertCount(2, User::all());
    }
}
