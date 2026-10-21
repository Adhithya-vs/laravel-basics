<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasUuids;

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    // This table intentionally does not have updated_at.
    public const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'preferred_date',
        'message',
    ];

    protected $casts = [
        'preferred_date' => 'date:Y-m-d',
    ];
}