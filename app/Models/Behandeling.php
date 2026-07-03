<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Behandeling extends Model
{
    use HasFactory;

    protected $table = 'Behandeling';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Omschrijving',
        'Duurminuten',
        'Prijs',
        'IsActief',
        'Opmerking',
    ];
}
