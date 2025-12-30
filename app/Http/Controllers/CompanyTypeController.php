<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyTypeRequest;
use App\Models\CompanyType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyTypeController extends Controller
{
    /**
     * Display a listing of company types.
     */
    public function index()
    {
        $companyTypes = CompanyType::ordered()
            ->search('name')
            ->paginate()
            ->withQueryString();

        return Inertia::render('CompanyTypes/Index', [
            'company_types' => $companyTypes,
        ]);
    }

    /**
     * Show the form for creating a new company type.
     */
    public function create()
    {
        return Inertia::render('CompanyTypes/Form');
    }

    /**
     * Store a newly created company type in storage.
     */
    public function store(CompanyTypeRequest $request)
    {
        $validated = $request->validated();
        $companyType = CompanyType::create($validated);

        return redirect()
            ->route('company-types.index')
            ->with('message', 'Company Type created successfully.')
            ->with('type', 'success');
    }

    /**
     * Show the form for editing the specified company type.
     */
    public function edit(CompanyType $companyType)
    {
        return Inertia::render('CompanyTypes/Form', [
            'company_type' => $companyType,
        ]);
    }

    /**
     * Update the specified company type in storage.
     */
    public function update(CompanyTypeRequest $request, CompanyType $companyType)
    {
        $validated = $request->validated();
        $companyType->update($validated);

        return redirect()
            ->route('company-types.index')
            ->with('message', 'Company Type updated successfully.')
            ->with('type', 'success');
    }

    /**
     * Remove the specified company type from storage.
     */
    public function destroy(CompanyType $companyType)
    {
        $companyType->delete();

        return redirect()
            ->route('company-types.index')
            ->with('message', 'Company Type deleted successfully.')
            ->with('type', 'success');
    }
}
