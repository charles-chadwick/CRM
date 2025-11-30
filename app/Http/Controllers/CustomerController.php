<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CustomerResource;
use App\Models\Company;
use App\Models\Customer;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index(Company $company)
    {
        $customers = Customer::with('contact')
            ->where('company_id', $company->id)
            ->paginate();


        return Inertia::render('Customers/Index', [
            'company'   => new CompanyResource($company),
            'customers' => CustomerResource::collection($customers)
        ]);
    }

    public function create()
    {
        return Inertia::render('Customers/Form',
            [
                'customer' => new CustomerResource(new Customer()),
                'action'   => 'create'
            ]
        );
    }

    public function store(CustomerRequest $request)
    {
        Customer::create($request->validated());

        return redirect()
            ->route('customers.index')
            ->with('message', 'Customer created successfully')
            ->with('type', 'success');
    }

    public function profile(Customer $customer)
    {
        $customer->load('contact');
        return Inertia::render('Customers/Form',
            [
                'customer' => new CustomerResource($customer),
                'action'   => 'show'
            ]
        );
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return new CustomerResource($customer);
    }

    public function destroy(Customer $customer)
    {
        $company_id = $customer->company_id;
        $customer->delete();

        return redirect()
            ->route('customers.index', $company_id)
            ->with('message', 'Customer deleted successfully')
            ->with('type', 'success');
    }
}
