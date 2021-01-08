<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'brands';
    protected $fillable = [
        'code',
        'name'
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
