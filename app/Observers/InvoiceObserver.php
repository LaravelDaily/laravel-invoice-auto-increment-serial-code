<?php

namespace App\Observers;

use App\Models\Invoice;

class InvoiceObserver
{

    public function creating(Invoice $invoice): void
    {
        $invoice->serial_number = (Invoice::where('serial_series', $invoice->serial_series)->max('serial_number') ?? 0) + 1;
        $invoice->serial = $invoice->serial_series . '-' . $invoice->serial_number;
    }
}
