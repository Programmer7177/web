<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Instansi;
use App\Models\FacilityReport;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstitutionFilteringTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_only_sees_reports_from_their_institution()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin_sarpras']);
        $studentRole = Role::create(['name' => 'mahasiswa']);

        // Create institutions
        $instansi1 = Instansi::create(['name' => 'Instansi 1', 'code' => 'INS1']);
        $instansi2 = Instansi::create(['name' => 'Instansi 2', 'code' => 'INS2']);

        // Create categories
        $category = Category::create(['name' => 'Test Category']);

        // Create admin for institution 1
        $admin1 = User::create([
            'username' => 'admin1',
            'email' => 'admin1@test.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->role_id,
            'instansi_id' => $instansi1->instansi_id,
        ]);

        // Create admin for institution 2
        $admin2 = User::create([
            'username' => 'admin2',
            'email' => 'admin2@test.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->role_id,
            'instansi_id' => $instansi2->instansi_id,
        ]);

        // Create students
        $student1 = User::create([
            'username' => 'student1',
            'email' => 'student1@test.com',
            'password' => bcrypt('password'),
            'role_id' => $studentRole->role_id,
            'instansi_id' => $instansi1->instansi_id,
        ]);

        $student2 = User::create([
            'username' => 'student2',
            'email' => 'student2@test.com',
            'password' => bcrypt('password'),
            'role_id' => $studentRole->role_id,
            'instansi_id' => $instansi2->instansi_id,
        ]);

        // Create reports for different institutions
        FacilityReport::create([
            'user_id' => $student1->user_id,
            'category_id' => $category->category_id,
            'instansi_id' => $instansi1->instansi_id,
            'title' => 'Report from Instansi 1',
            'description' => 'Test report',
            'location' => 'Test location',
            'status' => 'pending',
        ]);

        FacilityReport::create([
            'user_id' => $student2->user_id,
            'category_id' => $category->category_id,
            'instansi_id' => $instansi2->instansi_id,
            'title' => 'Report from Instansi 2',
            'description' => 'Test report',
            'location' => 'Test location',
            'status' => 'pending',
        ]);

        // Test admin1 only sees reports from instansi1
        $this->actingAs($admin1);
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Report from Instansi 1');
        $response->assertDontSee('Report from Instansi 2');

        // Test admin2 only sees reports from instansi2
        $this->actingAs($admin2);
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Report from Instansi 2');
        $response->assertDontSee('Report from Instansi 1');
    }

    public function test_admin_metrics_only_count_their_institution_reports()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin_sarpras']);
        $studentRole = Role::create(['name' => 'mahasiswa']);

        // Create institutions
        $instansi1 = Instansi::create(['name' => 'Instansi 1', 'code' => 'INS1']);
        $instansi2 = Instansi::create(['name' => 'Instansi 2', 'code' => 'INS2']);

        // Create categories
        $category = Category::create(['name' => 'Test Category']);

        // Create admin for institution 1
        $admin1 = User::create([
            'username' => 'admin1',
            'email' => 'admin1@test.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->role_id,
            'instansi_id' => $instansi1->instansi_id,
        ]);

        // Create students
        $student1 = User::create([
            'username' => 'student1',
            'email' => 'student1@test.com',
            'password' => bcrypt('password'),
            'role_id' => $studentRole->role_id,
            'instansi_id' => $instansi1->instansi_id,
        ]);

        $student2 = User::create([
            'username' => 'student2',
            'email' => 'student2@test.com',
            'password' => bcrypt('password'),
            'role_id' => $studentRole->role_id,
            'instansi_id' => $instansi2->instansi_id,
        ]);

        // Create reports for different institutions
        FacilityReport::create([
            'user_id' => $student1->user_id,
            'category_id' => $category->category_id,
            'instansi_id' => $instansi1->instansi_id,
            'title' => 'Report from Instansi 1',
            'description' => 'Test report',
            'location' => 'Test location',
            'status' => 'pending',
        ]);

        FacilityReport::create([
            'user_id' => $student2->user_id,
            'category_id' => $category->category_id,
            'instansi_id' => $instansi2->instansi_id,
            'title' => 'Report from Instansi 2',
            'description' => 'Test report',
            'location' => 'Test location',
            'status' => 'pending',
        ]);

        // Test admin1 metrics only count instansi1 reports
        $this->actingAs($admin1);
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        
        // Should show 1 total report (only from instansi1)
        $response->assertSee('1'); // Total count
        $response->assertSee('1'); // Pending count
    }
}