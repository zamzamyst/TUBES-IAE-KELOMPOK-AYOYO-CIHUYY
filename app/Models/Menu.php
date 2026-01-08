<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $connection = 'mysql_menu';

    protected $fillable = [
        'menu_code',
        'name',
        'price',
        'description',
    ];
}
