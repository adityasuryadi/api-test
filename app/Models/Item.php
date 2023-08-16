<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table="items";
    protected $fillable=["name","cheklist_id"];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
