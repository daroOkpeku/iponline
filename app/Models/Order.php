<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
class Order extends Model
{
    use HasFactory, SearchableTrait;


  protected $searchable = [
        'columns' => [
            'orders.category'=>10,
            'orders.price' => 10,
        ],
    ];

    protected $fillable = [
        'title',
        'category',
        'price',
        'image',
    ];
}
