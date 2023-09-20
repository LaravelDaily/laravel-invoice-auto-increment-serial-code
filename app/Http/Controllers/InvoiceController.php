<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Jobs\GenerateInvoiceNumberJob;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['user'])->get();

        return view('invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    public function create()
    {
        $users = User::pluck('name', 'id');
        $invoiceSeries = config('invoiceSettings.availableInvoiceSeries');

        return view('invoices.create', [
            'users' => $users,
            'invoiceSeries' => $invoiceSeries,
        ]);
    }

    public function store(StoreInvoiceRequest $request): RedirectResponse
    {
        $invoice = Invoice::create($request->validated());

        dispatch(new GenerateInvoiceNumberJob($invoice->id));

        return redirect()->route('invoice.index');
    }

    public function edit(Invoice $invoice)
    {
        $users = User::pluck('name', 'id');

        return view('invoices.edit', [
            'invoice' => $invoice,
            'users' => $users,
        ]);
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice): RedirectResponse
    {
        $invoice->update($request->validated());

        return redirect()->route('invoice.index');
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();

        return redirect()->route('invoice.index');
    }
}
