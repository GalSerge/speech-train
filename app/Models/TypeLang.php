<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeLang extends Model
{
    use HasFactory;
    protected $fillable = ['typelang_id', 'title'];
}
