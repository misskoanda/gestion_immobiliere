<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'email', 'password', 'phone', 'role', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the properties owned by this user (if landlord/bailleur).
     */
    public function propertiesOwned(): HasMany
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    /**
     * Get the properties managed/verified by this agent.
     */
    public function propertiesManaged(): HasMany
    {
        return $this->hasMany(Property::class, 'agent_id');
    }

    /**
     * Get the list of favorites for this client.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'client_id');
    }

    /**
     * Get the properties favorited by this client.
     */
    public function favoriteProperties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'favorites', 'client_id', 'property_id');
    }

    /**
     * Get visit requests made by this client.
     */
    public function visitRequests(): HasMany
    {
        return $this->hasMany(VisitRequest::class, 'client_id');
    }

    /**
     * Get visit requests assigned to this agent.
     */
    public function assignedVisitRequests(): HasMany
    {
        return $this->hasMany(VisitRequest::class, 'agent_id');
    }

    /**
     * Get client assignment to an agent (if this user is a client).
     */
    public function clientAssignment(): HasOne
    {
        return $this->hasOne(ClientAgentAssignment::class, 'client_id');
    }

    /**
     * Get client assignments managed by this agent.
     */
    public function agentAssignments(): HasMany
    {
        return $this->hasMany(ClientAgentAssignment::class, 'agent_id');
    }

    /**
     * Get assignments made by this manager.
     */
    public function managedAssignments(): HasMany
    {
        return $this->hasMany(ClientAgentAssignment::class, 'manager_id');
    }

    /**
     * Get XML exports created by this manager.
     */
    public function xmlExports(): HasMany
    {
        return $this->hasMany(XmlExport::class, 'manager_id');
    }
}
