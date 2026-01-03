<?php

namespace App\Http\Controllers;

use App\Enums\SalesLeadStatus;
use App\Enums\SalesLeadType;
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
            'company'
        ])
            ->search([
                'title',
                'type',
                'status'
            ])
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
        $sales_lead = SalesLead::create($request->validated());

        return redirect()
            ->route('sales-leads.show', $sales_lead->id)
            ->with('success', 'Sales lead created successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        return Inertia::render('SalesLeads/Form', [
            'companies' => (new Company())->toSelect(),
            'sales_lead_types' => SalesLeadType::toSelect(),
            'sales_lead_statuses' => SalesLeadStatus::toSelect(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesLead $sales_lead) : Response
    {
        $sales_lead->load([
            'company',
            'progress'
        ]);

        return Inertia::render('SalesLeads/Show', [
            'sales_lead' => $sales_lead,
            'sales_lead_types' => SalesLeadType::toSelect(),
            'sales_lead_statuses' => SalesLeadStatus::toSelect(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesLead $sales_lead) : Response
    {
        return Inertia::render('SalesLeads/Form', [
            'sales_lead' => $sales_lead,
            'companies'  => (new Company())->toSelect(),
            'sales_lead_types' => SalesLeadType::toSelect(),
            'sales_lead_statuses' => SalesLeadStatus::toSelect(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesLeadRequest $request, SalesLead $sales_lead) : RedirectResponse
    {
        $sales_lead->update($request->validated());

        return redirect()
            ->route('sales-leads.index')
            ->with('success', 'Sales lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesLead $sales_lead) : RedirectResponse
    {

        $sales_lead->delete();

        return redirect()
            ->route('sales-leads.index')
            ->with('success', 'Sales lead deleted successfully.');
    }
}
