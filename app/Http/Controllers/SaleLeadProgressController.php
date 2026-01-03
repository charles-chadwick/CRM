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
            'salesLead',
            'createdBy',
            'updatedBy'
        ])
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->when($request->input('sales_lead_id'), function ($query, $salesLeadId) {
                $query->where('sales_lead_id', $salesLeadId);
            })
            ->latest()
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
     * Show the form for creating a new resource.
     */
    public function create(Request $request) : Response
    {
        $sales_leads = SalesLead::select('id', 'title')
            ->orderBy('title')
            ->get();
        $selected_sales_lead_id = $request->input('sales_lead_id');

        return Inertia::render('SaleLeadProgress/Create', [
            'sales_leads'            => $sales_leads,
            'selected_sales_lead_id' => $selected_sales_lead_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleLeadProgressRequest $request) : RedirectResponse
    {
        $progress = SaleLeadProgress::create([
            ...$request->validated(),
            'created_by_id' => auth()->id(),
            'updated_by_id' => auth()->id(),
        ]);

        activity()
            ->performedOn($progress)
            ->causedBy(auth()->user())
            ->log('Sale lead progress created');

        return redirect()
            ->route('sale-lead-progress.index', ['sales_lead_id' => $progress->sales_lead_id])
            ->with('success', 'Progress record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleLeadProgress $saleLeadProgress) : Response
    {
        $saleLeadProgress->load([
            'salesLead',
            'createdBy',
            'updatedBy'
        ]);

        return Inertia::render('SaleLeadProgress/Show', [
            'progress' => $saleLeadProgress,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleLeadProgress $saleLeadProgress) : Response
    {
        $sales_leads = SalesLead::select('id', 'title')
            ->orderBy('title')
            ->get();

        return Inertia::render('SaleLeadProgress/Edit', [
            'progress'    => $saleLeadProgress,
            'sales_leads' => $sales_leads,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleLeadProgressRequest $request, SaleLeadProgress $saleLeadProgress) : RedirectResponse
    {
        $saleLeadProgress->update([
            ...$request->validated(),
            'updated_by_id' => auth()->id(),
        ]);

        activity()
            ->performedOn($saleLeadProgress)
            ->causedBy(auth()->user())
            ->log('Sale lead progress updated');

        return redirect()
            ->route('sale-lead-progress.index', ['sales_lead_id' => $saleLeadProgress->sales_lead_id])
            ->with('success', 'Progress record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleLeadProgress $saleLeadProgress) : RedirectResponse
    {
        $sales_lead_id = $saleLeadProgress->sales_lead_id;

        activity()
            ->performedOn($saleLeadProgress)
            ->causedBy(auth()->user())
            ->log('Sale lead progress deleted');

        $saleLeadProgress->delete();

        return redirect()
            ->route('sale-lead-progress.index', ['sales_lead_id' => $sales_lead_id])
            ->with('success', 'Progress record deleted successfully.');
    }
}
