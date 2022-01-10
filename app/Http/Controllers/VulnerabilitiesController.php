<?php

namespace App\Http\Controllers;

use App\Http\Requests\VulnerabilityStoreRequest;
use App\Http\Requests\VulnerabilityUpdateRequest;
use App\Models\Vulnerability;
use Illuminate\Http\RedirectResponse;

class VulnerabilitiesController extends Controller
{
    public function index()
    {
        return view('vulnerabilities.index', [
            'vulnerabilities' => Vulnerability::query()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('vulnerabilities.create');
    }

    public function store(VulnerabilityStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $vulnerability = Vulnerability::query()->create($validated);

        return redirect()
            ->to(route('vulnerabilities.show', $vulnerability->id))
            ->with('success', __('vulnerability.created'));
    }

    public function show(Vulnerability $vulnerability)
    {
        return view('vulnerabilities.show', [
            'vulnerability' => $vulnerability
        ]);
    }

    public function edit(Vulnerability $vulnerability)
    {
        return view('vulnerabilities.edit', [
            'vulnerability' => $vulnerability
        ]);
    }

    public function update(VulnerabilityUpdateRequest $request, Vulnerability $vulnerability)
    {
        $validated = $request->validated();

        $vulnerability->fill($validated)->save();

        return redirect()
            ->back()
            ->with('success', __('vulnerability.created'));
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
