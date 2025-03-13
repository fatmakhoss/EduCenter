<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'langue_id']; // الأعمدة اللي يمكن تكتب فيها

    // ارتباط مع Langue
    public function langue()
    {
        return $this->belongsTo(Langue::class, 'langue_id');
    }
}
