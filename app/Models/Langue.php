<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    use HasFactory;
    protected $fillable = ['nom']; // الأعمدة اللي يمكن تكتب فيها

    // ارتباط مع Niveau (إذا لازم)
    public function niveaux()
    {
        return $this->hasMany(Niveau::class, 'langue_id');
    }
}
