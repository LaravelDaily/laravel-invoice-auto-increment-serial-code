<?php

namespace App\Models;

use App\Jobs\GenerateInvoiceNumberJob;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'due_date',
        'amount',
        'serial',
        'serial_number',
        'serial_series',
    ];

    protected static function booted()
    {
        parent::booted();

        self::created(static function (Invoice $invoice) {
            dispatch(new GenerateInvoiceNumberJob($invoice->id));
        });
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
