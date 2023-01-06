<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $table = 'stock_upload';
    protected $primaryKey = 'id';
    protected $fillable = [
        'branch_id',
        'item_code',
        'item_name',
        'price',
        'unit',
        'stock',
    ];


}
