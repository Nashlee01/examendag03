<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Behandeling extends Model
{
    use HasFactory;

    protected $table = 'behandelingen';

    protected $fillable = [
        'user_id',
        'klant_naam',
        'datum',
        'start_tijd',
        'duur_minuten',
        'status',
        'opmerking',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
