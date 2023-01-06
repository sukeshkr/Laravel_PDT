<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock_taking';
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_code',
        'item_name',
        'unit',
        'difference',
        'phy_stock',
        'sys_stock',
        'branch_id',
        'price',
    ];
}
