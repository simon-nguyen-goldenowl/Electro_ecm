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
        'name',
        'es_status',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    //FILTER FUNCTION
    public function scopeName($query, $request)
    {
        if ($request->has('name')) {
            $name = $request->input('name');
            $query->where('name', 'like', '%' . $name . '%');
        }
        return $query;
    }
}
