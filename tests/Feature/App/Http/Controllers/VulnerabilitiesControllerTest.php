<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Vulnerability;
use App\Models\VulnerabilityFactor;
use App\Models\VulnerabilityFactorType;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class VulnerabilitiesControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function visitor_can_see_vulnerabilities_index_with_pagination()
    {
        Vulnerability::factory()->count(26)->create();

        $response = $this->get(route('vulnerabilities.index'));

        $this
            ->assertInstanceOf(LengthAwarePaginator::class, $response->viewData('vulnerabilities'));

        $response
            ->assertOk()
            ->assertViewIs('vulnerabilities.index');
    }

    /** @test */
    public function visitor_can_see_vulnerability()
    {
        $model = Vulnerability::factory()->create();

        $response = $this->get(route('vulnerabilities.show', $model->id));

        $this
            ->assertInstanceOf(Vulnerability::class, $response->viewData('vulnerability'));

        $response
            ->assertOk()
            ->assertViewIs('vulnerabilities.show');
    }

    /** @test */
    public function visitor_can_edit_vulnerability()
    {
        $model = Vulnerability::factory()->create();

        $response = $this->get(route('vulnerabilities.edit', $model->id));

        $this
            ->assertInstanceOf(Vulnerability::class, $response->viewData('vulnerability'));

        $response
            ->assertOk()
            ->assertViewIs('vulnerabilities.edit');
    }

    /** @test */
    public function visitor_can_update_vulnerability()
    {
        $model = Vulnerability::factory(['title' => 'Old title'])->create();

        $this->assertDatabaseHas('vulnerabilities', [
            'id'    => $model->id,
            'title' => 'Old title'
        ]);

        $response = $this
            ->followingRedirects()
            ->from(route('vulnerabilities.edit', $model->id))
            ->put(route('vulnerabilities.update', $model->id), [
                'title' => 'New title'
            ]);

        $this
            ->assertDatabaseHas('vulnerabilities', [
                'id'    => $model->id,
                'title' => 'Old title'
            ]);

        $response
            ->assertOk()
            ->assertViewIs('vulnerabilities.edit');
    }

    /** @test */
    public function visitor_can_delete_vulnerability()
    {
        $model = Vulnerability::factory()->create();

        $response = $this
            ->from(route('vulnerabilities.index'))
            ->delete(route('vulnerabilities.destroy', $model->id));

        $this
            ->assertSoftDeleted($model);

        $response
            ->assertRedirect(route('vulnerabilities.index'));
    }

    /** @test */
    public function visitor_can_create_vulnerability()
    {
        $response = $this->get(route('vulnerabilities.create'));

        $response
            ->assertOk()
            ->assertViewIs('vulnerabilities.create');
    }

    /** @test */
    public function visitor_can_store_vulnerability()
    {
        $data = Vulnerability::factory()->raw();

        $values = [];

        VulnerabilityFactorType::all()->each(function($type) use (&$values) {
           $values[$type->id] = VulnerabilityFactor::factory()->raw()['value'];
        });

        $data['vulnerability_type_value'] = $values;

        $response = $this
            ->followingRedirects()
            ->post(route('vulnerabilities.store'), $data);

        $this->assertDatabaseHas('vulnerabilities', [
            'title' => $data['title']
        ]);

        $response
            ->assertOk()
            ->assertViewIs('vulnerabilities.show');
    }

    /** @test */
    public function visitor_is_redirected_from_root_to_vulnerabilities_index()
    {
        $response = $this->get('/');

        $response
            ->assertRedirect(route('vulnerabilities.index'));
    }

    /** @test */
    public function deleting_non_existing_vulnerability_throws_error()
    {
        $response = $this->delete(route('vulnerabilities.destroy', 1));

        $this->assertDatabaseMissing('vulnerabilities', [
            'id' => 1,
        ]);

        $response->assertNotFound();
    }
}
