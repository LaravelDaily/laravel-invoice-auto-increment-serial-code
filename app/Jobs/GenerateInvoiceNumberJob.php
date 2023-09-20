<?php

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateInvoiceNumberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Invoice $invoice;

    public function __construct(int $invoiceID)
    {
        $this->invoice = Invoice::findOrFail($invoiceID);
    }

    public function handle(): void
    {
        $this->invoice->serial_number = (Invoice::where('serial_series', $this->invoice->serial_series)->max('serial_number') ?? 0) + 1;
        $this->invoice->serial = $this->invoice->serial_series . '-' . str_pad($this->invoice->serial_number, 5, '0', STR_PAD_LEFT);
        $this->invoice->save();
    }
}
