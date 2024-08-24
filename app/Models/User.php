<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'gender',
        'phone',
        'linkedin_url',
        'profile_url',
        'coin_amount',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

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
        ];
    }

    public function works(): BelongsToMany
    {
        return $this->belongsToMany(Work::class, 'users_works', 'user_id', 'work_id');
    }

    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user1_id', 'user2_id')
            ->withPivot('status')
            ->wherePivot('status', 'accepted')
            ->orWhere(function ($query) {
                $query->where('friends.user2_id', $this->id)
                    ->where('friends.status', 'accepted');
            })
            ->select(DB::raw('CASE WHEN friends.user2_id = ' . $this->id . ' THEN friends.user1_id ELSE friends.user2_id END as id'));
    }

    public function notifications(): BelongsToMany
    {
        return $this->belongsToMany(Notification::class, 'users_notifications', 'user_id', 'notification_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function avatars(): BelongsToMany
    {
        return $this->belongsToMany(Avatar::class, 'users_avatars', 'user_id', 'avatar_id');
    }

    public function isFriendWith(User $user): bool
    {
        return Friend::where(function ($query) use ($user) {
            $query->where('user1_id', $this->id)
                ->where('user2_id', $user->id)
                ->orWhere(function ($query) use ($user) {
                    $query->where('user1_id', $user->id)
                        ->where('user2_id', $this->id);
                });
        })
            ->where('status', 'accepted')
            ->exists();
    }
}
