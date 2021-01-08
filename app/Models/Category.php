<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';
    protected $fillable = [
        'code',
        'name'
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
    public function scopeName($query, $request)
    {
        if ($request->has('cate_name')) {
            $query->where('name', $request->input('cate_name'));
        }
        return $query;
    }
}
