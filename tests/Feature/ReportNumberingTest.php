<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Instansi;
use App\Models\FacilityReport;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportNumberingTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_numbering_is_sequential_in_admin_dashboard()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin_sarpras']);
        $studentRole = Role::create(['name' => 'mahasiswa']);

        // Create institution
        $instansi = Instansi::create(['name' => 'Test Instansi', 'code' => 'TEST']);

        // Create admin
        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->role_id,
            'instansi_id' => $instansi->instansi_id,
        ]);

        // Create students
        $student1 = User::create([
            'username' => 'student1',
            'email' => 'student1@test.com',
            'password' => bcrypt('password'),
            'role_id' => $studentRole->role_id,
            'instansi_id' => $instansi->instansi_id,
        ]);

        $student2 = User::create([
            'username' => 'student2',
            'email' => 'student2@test.com',
            'password' => bcrypt('password'),
            'role_id' => $studentRole->role_id,
            'instansi_id' => $instansi->instansi_id,
        ]);

        // Create category
        $category = Category::create(['name' => 'Test Category']);

        // Create reports
        FacilityReport::create([
            'user_id' => $student1->user_id,
            'category_id' => $category->category_id,
            'instansi_id' => $instansi->instansi_id,
            'title' => 'Report 1',
            'description' => 'Test report 1',
            'location' => 'Test location 1',
            'status' => 'pending',
        ]);

        FacilityReport::create([
            'user_id' => $student2->user_id,
            'category_id' => $category->category_id,
            'instansi_id' => $instansi->instansi_id,
            'title' => 'Report 2',
            'description' => 'Test report 2',
            'location' => 'Test location 2',
            'status' => 'pending',
        ]);

        // Test admin dashboard shows sequential numbering
        $this->actingAs($admin);
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        
        // Check that the page contains the expected sequential numbers
        $response->assertSee('#1'); // First report should be numbered 1
        $response->assertSee('#2'); // Second report should be numbered 2
    }

    public function test_report_numbering_continues_across_pages()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin_sarpras']);
        $studentRole = Role::create(['name' => 'mahasiswa']);

        // Create institution
        $instansi = Instansi::create(['name' => 'Test Instansi', 'code' => 'TEST']);

        // Create admin
        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->role_id,
            'instansi_id' => $instansi->instansi_id,
        ]);

        // Create student
        $student = User::create([
            'username' => 'student',
            'email' => 'student@test.com',
            'password' => bcrypt('password'),
            'role_id' => $studentRole->role_id,
            'instansi_id' => $instansi->instansi_id,
        ]);

        // Create category
        $category = Category::create(['name' => 'Test Category']);

        // Create 15 reports (more than default pagination of 10)
        for ($i = 1; $i <= 15; $i++) {
            FacilityReport::create([
                'user_id' => $student->user_id,
                'category_id' => $category->category_id,
                'instansi_id' => $instansi->instansi_id,
                'title' => "Report $i",
                'description' => "Test report $i",
                'location' => "Test location $i",
                'status' => 'pending',
            ]);
        }

        // Test first page
        $this->actingAs($admin);
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        
        // First page should show reports 1-10
        for ($i = 1; $i <= 10; $i++) {
            $response->assertSee("#$i");
        }

        // Test second page
        $response = $this->get('/dashboard?page=2');
        $response->assertStatus(200);
        
        // Second page should show reports 11-15
        for ($i = 11; $i <= 15; $i++) {
            $response->assertSee("#$i");
        }
    }
}