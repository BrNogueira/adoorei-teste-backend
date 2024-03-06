<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Mobile;
use App\Models\Sale;

class ApiTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    public function testListMobiles()
    {
        Mobile::factory()->count(5)->create();
        $response = $this->get('/api/mobile');
        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function testCreateSale()
    {
        $mobile = Mobile::factory()->create();

        $data = [
            'mobile_id' => $mobile->id,
            'quantity' => 2,
        ];

        $response = $this->post('/api/sales', $data);

        $response->assertStatus(201);

        $response->assertJsonFragment(['mobile_id' => $mobile->id, 'quantity' => 2]);

        $this->assertDatabaseHas('sales', ['mobile_id' => $mobile->id, 'quantity' => 2]);
    }
}
