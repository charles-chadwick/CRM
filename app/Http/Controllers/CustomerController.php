<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $customers = Customer::with(['company'])
            ->ordered()
            ->paginate()
            ->withQueryString();

        return Inertia::render('Customers/Index', [
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        $companies = Company::orderBy('name', 'asc')->get();

        return Inertia::render('Customers/Form', [
            'companies' => $companies,
        ]);
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by_id'] = auth()->id();
        $validated['updated_by_id'] = auth()->id();

        Customer::create($validated);

        return redirect()
            ->route('customers.index')
            ->with('message', 'Customer created successfully.')
            ->with('type', 'success');
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        $companies = Company::orderBy('name', 'asc')->get();

        return Inertia::render('Customers/Form', [
            'customer'  => $customer->load(['company']),
            'companies' => $companies,
        ]);
    }

    public function show(Customer $customer)
    {
        $customer->load(['contacts']);
        return Inertia::render('Customers/Show', [
            'customer' => $customer->load(['company']),
        ]);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $validated = $request->validated();
        $validated['updated_by_id'] = auth()->id();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('message', 'Customer updated successfully.')
            ->with('type', 'success');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('message', 'Customer deleted successfully.')
            ->with('type', 'success');
    }
}
