<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\CompanyType;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of companies.
     */
    public function index()
    {
        $companies = Company::search('name')
            ->sort()
            ->paginate()
            ->withQueryString();

        return Inertia::render('Companies/Index', [
            'companies'     => $companies,
            'company_types' => (new CompanyType())->toSelect()
        ]);
    }

    public function show(Company $company)
    {
        $company->load([
            'contacts',
            'customers',
            'discussions'
        ]);

        return Inertia::render('Companies/Show', [
            'company' => $company,
        ]);
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(CompanyRequest $request)
    {
        $validated = $request->validated();
        $company = Company::create($validated);

        return redirect()
            ->route('companies.edit', $company->id)
            ->with('message', 'Company created successfully.')
            ->with('type', 'success');
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        return Inertia::render('Companies/Form', [
            'company_types' => (new CompanyType())->toSelect()
        ]);
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company)
    {
        return Inertia::render('Companies/Form', [
            'company'       => $company,
            'company_types' => (new CompanyType())->toSelect()

        ]);
    }

    /**
     * Update the specified company in storage.
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $validated = $request->validated();

        // sanity check for notes
        if (trim(strip_tags($validated['notes'])) === '') {
            $validated['notes'] = null;
        }

        $company->update($validated);

        return redirect()
            ->route('companies.show', $company->id)
            ->with('message', 'Company updated successfully.')
            ->with('type', 'success');
    }

    /**
     * Remove the specified company from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company deleted successfully.')
            ->with('type', 'success');
    }
}

