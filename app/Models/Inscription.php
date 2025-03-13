<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'langue_id',
        'niveau_id',
        'name',
        'email',
        'pays',
        'telephone',
        'status',
    ];

    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }
}
