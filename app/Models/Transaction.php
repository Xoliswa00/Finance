<?php

namespace App\Models;
use App\Models\category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;


class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'Category',
        'Description',
        'Amount',
        'bill_date',
        'Status',
        'paymentId',
        'Added_by',
        'category'
    ];

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'paymentId');
    }

    public function Added_by()
    {
        return $this->belongsTo(User::class, 'Added_by');
    }

    public function category()
    {
        return $this->belongsTo(category::class, 'Category');
    }
}
