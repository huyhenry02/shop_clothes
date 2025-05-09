<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'payment_time',
        'transaction_no',
        'bank_code',
        'vnp_response_code',
        'transaction_status',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public const TRANSACTION_STATUS_SUCCESS = 'success';
    public const TRANSACTION_STATUS_FAIL = 'fail';

    public const TRANSACTION_STATUSES = [
        self::TRANSACTION_STATUS_SUCCESS => 'Thành công',
        self::TRANSACTION_STATUS_FAIL => 'Thất bại',
    ];
}
