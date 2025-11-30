<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\Customer;
use Inertia\Inertia;
use function dd;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with(['customers'])
            ->paginate();

        return Inertia::render('Companies/Index', [
            'companies' => CompanyResource::collection($companies)
        ]);
    }

    public function create()
    {
        return Inertia::render('Companies/Form',
            [
                'company' => new CompanyResource(new Customer()),
                'action'  => 'create'
            ]
        );
    }

    public function store(CompanyRequest $request)
    {
        Customer::create($request->validated());

        return redirect()
            ->route('companies.index')
            ->with('message', 'Company created successfully')
            ->with('type', 'success');
    }

    public function show(Customer $company)
    {
        return new CompanyResource($company);
    }

    public function update(CompanyRequest $request, Customer $company)
    {
        $company->update($request->validated());

        return new CompanyResource($company);
    }

    public function destroy(Customer $company)
    {
        $company->delete();

        return response()->json();
    }
}
