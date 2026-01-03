<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalesLeadRequest;
use App\Http\Requests\UpdateSalesLeadRequest;
use App\Models\Company;
use App\Models\SalesLead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SalesLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : Response
    {
        $sales_leads = SalesLead::with([
            'company',
            'createdBy',
            'updatedBy'
        ])
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('SalesLeads/Index', [
            'sales_leads' => $sales_leads,
            'filters'     => $request->only(['search']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesLeadRequest $request) : RedirectResponse
    {
        $sales_lead = SalesLead::create([
            ...$request->validated(),
            'created_by_id' => auth()->id(),
            'updated_by_id' => auth()->id(),
        ]);

        activity()
            ->performedOn($sales_lead)
            ->causedBy(auth()->user())
            ->log('Sales lead created');

        return redirect()
            ->route('sales-leads.index')
            ->with('success', 'Sales lead created successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        $companies = Company::select('id', 'name')
            ->orderBy('name')
            ->get();

        return Inertia::render('SalesLeads/Create', [
            'companies' => $companies,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesLead $salesLead) : Response
    {
        $salesLead->load([
            'company',
            'progress.createdBy',
            'createdBy',
            'updatedBy'
        ]);

        return Inertia::render('SalesLeads/Show', [
            'sales_lead' => $salesLead,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesLead $salesLead) : Response
    {
        $companies = Company::select('id', 'name')
            ->orderBy('name')
            ->get();

        return Inertia::render('SalesLeads/Edit', [
            'sales_lead' => $salesLead,
            'companies'  => $companies,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesLeadRequest $request, SalesLead $salesLead) : RedirectResponse
    {
        $salesLead->update([
            ...$request->validated(),
            'updated_by_id' => auth()->id(),
        ]);

        activity()
            ->performedOn($salesLead)
            ->causedBy(auth()->user())
            ->log('Sales lead updated');

        return redirect()
            ->route('sales-leads.index')
            ->with('success', 'Sales lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesLead $salesLead) : RedirectResponse
    {
        activity()
            ->performedOn($salesLead)
            ->causedBy(auth()->user())
            ->log('Sales lead deleted');

        $salesLead->delete();

        return redirect()
            ->route('sales-leads.index')
            ->with('success', 'Sales lead deleted successfully.');
    }
}
