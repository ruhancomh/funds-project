<?php

namespace Tests\Unit;

use App\Events\DuplicateFundWarning;
use App\Events\FundCreated;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use App\Models\Fund;
use App\Models\FundManager;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FundTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_fund_without_aliases()
    {
        // Arrange
        $fundManager = FundManager::factory()->create();

        // Act
        $response = $this->postJson('/api/funds', [
            'name' => 'Tech Growth Fund',
            'start_year' => 2024,
            'fund_manager_id' => $fundManager->id,
        ]);

        // Assert
        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => ['id', 'name', 'start_year', 'fund_manager']
            ])
            ->assertJsonFragment(['name' => 'Tech Growth Fund'])
            ->assertJsonFragment(['start_year' => 2024])
            ->assertJsonFragment(['fund_manager_id' => $fundManager->id]);
    }

    /** @test */
    public function it_can_create_a_fund_with_aliases()
    {
        // Arrange
        $fundManager = FundManager::factory()->create();

        // Act
        $response = $this->postJson('/api/funds', [
            'name' => 'AI Investment Fund',
            'start_year' => 2025,
            'fund_manager_id' => $fundManager->id,
            'aliases' => ['AI Growth', 'Future AI Fund']
        ]);

        // Assert
        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'AI Investment Fund'])
            ->assertJsonFragment(['start_year' => 2025])
            ->assertJsonFragment(['fund_manager_id' => $fundManager->id])
            ->assertJsonFragment(['alias' => 'AI Growth'])
            ->assertJsonFragment(['alias' => 'Future AI Fund']);
    }

    /** @test */
    public function it_validates_fund_creation()
    {
        // Act
        $response = $this->postJson('/api/funds', []);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'start_year', 'fund_manager_id']);
    }

    /** @test */
    public function it_can_update_a_fund()
    {
        // Arrange
        $fundManager = FundManager::factory()->create();
        $fund = Fund::factory()->create(['fund_manager_id' => $fundManager->id]);

        // Act
        $response = $this->putJson("/api/funds/{$fund->id}", [
            'name' => 'Updated Fund Name',
            'start_year' => 2023,
            'fund_manager_id' => $fundManager->id
        ]);

        // Assert
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Fund Name']);
    }

    /** @test */
    public function it_returns_not_found_for_invalid_update()
    {
        // Arrange
        $fundManager = FundManager::factory()->create();

        // Act
        $response = $this->putJson('/api/funds/9999', [
            'name' => 'Non-existent Fund',
            'start_year' => 2025,
            'fund_manager_id' => $fundManager->id,
        ]);

        // Assert
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_list_all_funds()
    {
        // Arrange
        Fund::factory()->count(3)->create();

        // Act
        $response = $this->getJson('/api/funds');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_filter_funds_by_name()
    {
        // Arrange
        Fund::factory()->create(['name' => 'Tech Fund']);
        Fund::factory()->create(['name' => 'Healthcare Fund']);

        // Act
        $response = $this->getJson('/api/funds?name=Tech');

        // Assert
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Tech Fund'])
            ->assertJsonMissing(['name' => 'Healthcare Fund']);
    }

    /** @test */
    public function it_dispatches_fund_created_event_when_fund_is_created()
    {
        // Arrange
        Event::fake();

        $fundManager = FundManager::factory()->create();

        // Act
        $response = $this->postJson('/api/funds', [
            'name' => 'Tech Growth Fund',
            'start_year' => 2024,
            'fund_manager_id' => $fundManager->id
        ]);

        // Assert
        $response->assertStatus(201);

        Event::assertDispatched(FundCreated::class);
    }

    /** @test */
    public function it_dispatches_duplicate_fund_warning_event_when_duplicate_fund_is_created()
    {
        // Arrange
        Event::fake([DuplicateFundWarning::class]);

        $fundManager = FundManager::factory()->create();

        Fund::factory()->create([
            'name' => 'AI Fund',
            'start_year' => 2023,
            'fund_manager_id' => $fundManager->id
        ]);

        // Act
        $response = $this->postJson('/api/funds', [
            'name' => 'AI Fund',
            'start_year' => 2024,
            'fund_manager_id' => $fundManager->id
        ]);

        // Assert
        $response->assertStatus(201);

        Event::assertDispatched(DuplicateFundWarning::class);
    }
}
