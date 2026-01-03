<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleLeadProgressRequest;
use App\Http\Requests\UpdateSaleLeadProgressRequest;
use App\Models\SaleLeadProgress;
use App\Models\SalesLead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SaleLeadProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : Response
    {
        $progress = SaleLeadProgress::with([
            'salesLead'
        ])
            ->search([
                'title',
                'status'
            ])
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('SaleLeadProgress/Index', [
            'progress' => $progress,
            'filters'  => $request->only([
                'search',
                'sales_lead_id'
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleLeadProgressRequest $request) : RedirectResponse
    {
        $progress = SaleLeadProgress::create($request->validated());

        return redirect()
            ->route('sale-lead-progress.index', ['sales_lead_id' => $progress->sales_lead_id])
            ->with('success', 'Progress record created successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) : Response
    {
        $sales_leads = SalesLead::select('id', 'title')
            ->orderBy('title')
            ->get();
        $selected_sales_lead_id = $request->input('sales_lead_id');

        return Inertia::render('SaleLeadProgress/Form', [
            'sales_leads'            => $sales_leads,
            'selected_sales_lead_id' => $selected_sales_lead_id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleLeadProgress $sale_lead_progress) : Response
    {
        $sale_lead_progress->load([
            'salesLead',
            'discussions'
        ]);

        return Inertia::render('SaleLeadProgress/Show', [
            'progress' => $sale_lead_progress,
            'on_type'  => 'SaleLeadProgress',
            'on_id'    => $sale_lead_progress->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleLeadProgress $sale_lead_progress) : Response
    {
        $sales_leads = SalesLead::select('id', 'title')
            ->orderBy('title')
            ->get();

        return Inertia::render('SaleLeadProgress/Form', [
            'progress' => $sale_lead_progress,
            'sales_leads' => $sales_leads,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleLeadProgressRequest $request, SaleLeadProgress $sale_lead_progress) : RedirectResponse
    {
        $sale_lead_progress->update($request->validated());

        return redirect()
            ->route('sale-lead-progress.index', ['sales_lead_id' => $sale_lead_progress->sales_lead_id])
            ->with('success', 'Progress record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleLeadProgress $sale_lead_progress) : RedirectResponse
    {
        $sales_lead_id = $sale_lead_progress->sales_lead_id;

        $sale_lead_progress->delete();

        return redirect()
            ->route('sale-lead-progress.index', ['sales_lead_id' => $sales_lead_id])
            ->with('success', 'Progress record deleted successfully.');
    }
}
