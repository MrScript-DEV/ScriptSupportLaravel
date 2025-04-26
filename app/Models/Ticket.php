<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subject',
        'rating',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class)->withTrashed();
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
