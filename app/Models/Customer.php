<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
//    tên bảng
    protected $table = 'customers';

//    tên cột
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'address',
        'gender',
        'birthday',
    ];
    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';
    public const GENDER_OTHER = 'other';

    public const GENDERS = [
        self::GENDER_MALE => 'Nam',
        self::GENDER_FEMALE => 'Nữ',
        self::GENDER_OTHER => 'Khác',
    ];
// các hàm định nghĩa mối quan hệ giữa các bảng
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
}
