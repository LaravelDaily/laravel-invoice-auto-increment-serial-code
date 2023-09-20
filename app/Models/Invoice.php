<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'due_date',
        'amount',
        'serial',
        'serial_number',
        'serial_series',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(static function (Invoice $invoice) {
            $invoice->serial_number = (Invoice::where('serial_series', $invoice->serial_series)->max('serial_number') ?? 0) + 1;
            $invoice->serial = $invoice->serial_series . '-' . $invoice->serial_number;
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
