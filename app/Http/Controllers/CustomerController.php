<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CustomerResource;
use App\Models\Company;
use App\Models\Customer;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index(Company $company)
    {
        $customers = Customer::where('company_id', $company->id)
            ->paginate();

        return Inertia::render('Customers/Index', [
            'company' => new CompanyResource($company),
            'customers' => CustomerResource::collection($customers)
        ]);
    }

    public function create()
    {
        return Inertia::render('Customers/Form',
            [
                'customer' => new CustomerResource(new Customer()),
                'action'  => 'create'
            ]
        );
    }

    public function store(CompanyRequest $request)
    {
        Company::create($request->validated());

        return redirect()
            ->route('companies.index')
            ->with('message', 'Company created successfully')
            ->with('type', 'success');
    }

    public function profile(Company $company)
    {
        return new CompanyResource($company);
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return new CompanyResource($company);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json();
    }
}
