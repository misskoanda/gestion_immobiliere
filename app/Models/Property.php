<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'agent_id',
        'title',
        'type',
        'usage',
        'option',
        'location',
        'area',
        'price',
        'description',
        'status',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'area' => 'decimal:2',
            'price' => 'decimal:2',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get the owner of the property.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the agent assigned to manage/verify this property.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Get all photos for the property.
     */
    public function photos(): HasMany
    {
        return $this->hasMany(PropertyPhoto::class);
    }

    /**
     * Get the main photo for the property.
     */
    public function mainPhoto(): HasOne
    {
        return $this->hasOne(PropertyPhoto::class)->where('is_main', true);
    }

    /**
     * Get all favorites for this property.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get all visit requests for this property.
     */
    public function visitRequests(): HasMany
    {
        return $this->hasMany(VisitRequest::class);
    }
}
