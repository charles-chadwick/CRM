<?php

namespace App\Http\Controllers;

use App\Enums\CompanyType;
use App\Enums\ContactType;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of companies.
     */
    public function index()
    {
        $companies = Company::ordered()
            ->paginate()
            ->withQueryString();

        return Inertia::render('Companies/Index', [
            'companies' => $companies,
        ]);
    }

    public function show(Company $company)
    {
        $company->load(['contacts', 'customers']);

        return Inertia::render('Companies/Show', [
            'company' => $company,
        ]);
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        return Inertia::render('Companies/Form', [
            'company_types' => CompanyType::toSelect(),
        ]);
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();
        $company = Company::create($validated);

        return redirect()
            ->route('companies.edit', $company->id)
            ->with('message', 'Company created successfully.')
            ->with('type', 'success');
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company)
    {
        return Inertia::render('Companies/Form', [
            'company'       => $company,
            'company_types' => CompanyType::toSelect()
        ]);
    }

    /**
     * Update the specified company in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $validated = $request->validated();
        $company->update($validated);

        return redirect()
            ->route('companies.index')
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

