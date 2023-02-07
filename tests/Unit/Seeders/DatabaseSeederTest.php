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
        (new DatabaseSeeder())->run();

        $this->assertDatabaseCount('vulnerabilities', 26)
            ->assertDatabaseCount('vulnerability_factor_types', 9)
            ->assertDatabaseCount('vulnerability_factors', 234);
    }
}
