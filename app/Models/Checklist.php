<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;
    protected $table="cheklists";
    protected $fillable=["name"];

    public function item()
    {
        return $this->hasMany(Item::class);
    }
}
