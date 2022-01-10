<?php

namespace App\Http\Controllers;

use App\Models\Vulnerability;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        //
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

    public function update(Request $request, Vulnerability $vulnerability)
    {
        //
    }

    public function destroy(Vulnerability $vulnerability)
    {
        if (!$vulnerability->delete()) {
            return back()->with('error', __('vulnerability.delete.failed'));
        };

        return $this->index()->with('success', __('vulnerability.deleted'));
    }
}
