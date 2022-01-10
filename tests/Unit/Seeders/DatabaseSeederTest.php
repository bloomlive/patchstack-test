<?php

namespace Tests\Unit\Seeders;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function it_seeds_expected_data()
    {
        (new DatabaseSeeder)->run();

        $this->assertDatabaseCount('vulnerabilities', 24)
            ->assertDatabaseCount('vulnerability_factor_types', 8)
            ->assertDatabaseCount('vulnerability_factors', 192);
    }
}
