<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Vulnerability;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class VulnerabilitiesControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function visitor_can_see_vulnerabilities_index_with_pagination()
    {
        $response = $this->get(route('vulnerabilities.index'));

        $response->assertOk();
    }

    /** @test */
    public function visitor_can_see_vulnerability()
    {
        $model = Vulnerability::factory()->create();

        $response = $this->get(route('vulnerabilities.show', $model->id));

        $response->assertOk();
    }

    /** @test */
    public function visitor_can_edit_vulnerability()
    {
        $model = Vulnerability::factory(['title' => 'Old title'])->create();

        $this->assertDatabaseHas('vulnerabilities', [
           'id' => $model->id,
           'title' => 'Old title'
        ]);

        $response = $this->put(route('vulnerabilities.update', $model->id), [
            'title' => 'New title'
        ]);

        $this->assertDatabaseHas('vulnerabilities', [
            'id' => $model->id,
            'title' => 'Old title'
        ]);

        $response->assertRedirectContains(route('vulnerabilities.show', $model->id));
    }

    /** @test */
    public function visitor_can_delete_vulnerability()
    {
        $model = Vulnerability::factory()->create();

        $response = $this->get(route('vulnerabilities.destroy', $model->id));

        $this->assertSoftDeleted($model);

        $response->assertRedirect(route('vulnerabilities.index'));
    }

    /** @test */
    public function visitor_can_create_vulnerability()
    {
        $data = Vulnerability::factory()->raw();

        $this->assertDatabaseMissing('vulnerabilities' ,[
            'title' => $data['title']
        ]);

        $response = $this->post(route('vulnerabilities.store'), $data);

        $this->assertDatabaseHas('vulnerabilities' ,[
            'title' => $data['title']
        ]);

        $response->assertRedirect(route('vulnerabilities.show', json_encode($response->json()->id)));
    }

    /** @test */
    public function visitor_is_redirected_from_root_to_vulnerabilities_index()
    {
        $response = $this->get('/');

        $response->assertRedirect(route('vulnerabilities.index'));
    }
}
