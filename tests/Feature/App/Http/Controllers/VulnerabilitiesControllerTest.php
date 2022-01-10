<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Vulnerability;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class VulnerabilitiesControllerTest extends TestCase
{

    /** @test */
    public function visitor_can_see_vulnerabilities_index_with_pagination()
    {
        Vulnerability::factory()->count(24)->create();

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
        $response = $this->get(route('vulnerabilities.edit'));

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

        $response = $this->put(route('vulnerabilities.update', $model->id), [
            'title' => 'New title'
        ]);

        $this
            ->assertDatabaseHas('vulnerabilities', [
                'id'    => $model->id,
                'title' => 'Old title'
            ])
            ->assertInstanceOf(Vulnerability::class, $response->viewData('vulnerability'));

        $response
            ->assertRedirectContains(route('vulnerabilities.show', $model->id))
            ->assertViewIs('vulnerabilities.show');
    }

    /** @test */
    public function visitor_can_delete_vulnerability()
    {
        $model = Vulnerability::factory()->create();

        $response = $this->delete(route('vulnerabilities.destroy', $model->id));

        $this
            ->assertSoftDeleted($model);

        $response
            ->assertRedirect(route('vulnerabilities.index'))
            ->assertViewHas('message', __('vulnerability.deleted'))
            ->assertViewIs('vulnerabilities.index');
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

        $this->assertDatabaseMissing('vulnerabilities', [
            'title' => $data['title']
        ]);

        $response = $this->post(route('vulnerabilities.store'), $data);

        $this->assertDatabaseHas('vulnerabilities', [
            'title' => $data['title']
        ]);

        $response
            ->assertRedirect(route('vulnerabilities.show', json_encode($response->json()->id)))
            ->assertViewHas('message', __('vulnerability.created'))
            ->assertViewIs('vulnerabilities.show');
    }

    /** @test */
    public function visitor_is_redirected_from_root_to_vulnerabilities_index()
    {
        $response = $this->get('/');

        $response
            ->assertRedirect(route('vulnerabilities.index'))
            ->assertViewIs('vulnerabilities.index');;
    }
}
