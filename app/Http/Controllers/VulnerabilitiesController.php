<?php

namespace App\Http\Controllers;

use App\Http\Requests\VulnerabilityStoreRequest;
use App\Models\Vulnerability;
use App\Models\VulnerabilityFactorType;
use Illuminate\Http\RedirectResponse;

class VulnerabilitiesController extends Controller
{
    public function index()
    {
        return view('vulnerabilities.index', [
            'vulnerabilities' => Vulnerability::query()->paginate(12)
        ]);
    }

    public function create()
    {
        return view('vulnerabilities.create', [
            'vulnerabilityFactorTypes' => VulnerabilityFactorType::all()
        ]);
    }

    public function store(VulnerabilityStoreRequest $request): RedirectResponse
    {
        $validated = $request->except('vulnerability_type_value');

        $vulnerability = Vulnerability::query()->create($validated);

        $vulnerabilityFactors = $request->only('vulnerability_type_value')['vulnerability_type_value'];

        foreach ($vulnerabilityFactors as $id => $value) {
            $vulnerability->vulnerabilityFactors()->create([
                'value'                        => $value,
                'vulnerability_factor_type_id' => $id
            ]);
        }

        return redirect()
            ->to(route('vulnerabilities.show', $vulnerability->id))
            ->with('success', __('vulnerability.created'))
            ->withInput();
    }

    public function show(Vulnerability $vulnerability)
    {
        return view('vulnerabilities.show', [
            'vulnerability' => $vulnerability->load('vulnerabilityFactors'),
        ]);
    }

    public function edit(Vulnerability $vulnerability)
    {
        return view('vulnerabilities.edit', [
            'vulnerability' => $vulnerability->load('vulnerabilityFactors'),
        ]);
    }

    public function update(VulnerabilityStoreRequest $request, Vulnerability $vulnerability)
    {
        $validated = $request->except('vulnerability_type_value');
        $vulnerabilityFactors = $request->only('vulnerability_type_value')['vulnerability_type_value'];

        \DB::transaction(function () use ($vulnerability, $validated, $vulnerabilityFactors) {
            $vulnerability->vulnerabilityFactors()->delete();

            foreach ($vulnerabilityFactors as $id => $value) {
                $vulnerability->vulnerabilityFactors()->create([
                    'value'                        => $value,
                    'vulnerability_factor_type_id' => $id
                ]);
            }

            $vulnerability->fill($validated)->save();
        });

        return redirect()
            ->back()
            ->with('success', __('vulnerability.updated'));
    }

    public function destroy(Vulnerability $vulnerability): RedirectResponse
    {
        $delete = $vulnerability->delete();

        if (!$delete) {
            return back()->with('message', __('vulnerability.delete.failed'));
        };

        return back()->with('success', __('vulnerability.deleted'));
    }
}
