<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'due_date' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'serial_series' => ['required', Rule::in(config('invoiceSettings.availableInvoiceSeries'))]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
