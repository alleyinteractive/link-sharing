<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RuntimeException;

/**
 * App\Models\Link
 *
 * @property string $hash
 * @property string $url
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 *
 * @method static \Database\Factories\LinkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Link extends Model
{
    use HasFactory;

    protected $primaryKey = 'hash';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'hash',
        'url',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(fn (Link $link) => $link->generateHash());
        static::updating(fn (Link $link) => $link->generateHash());
    }

    /**
     * Generate a unique hash for the link.
     */
    public function generateHash(): static
    {
        if (empty($this->hash)) {
            $tries = 0;

            while (true) {
                $this->hash = substr(md5(rand()), 0, 10);

                // Check if there is already a link with the same hash.
                if (! Link::find($this->hash)) {
                    break;
                }

                // If we have tried 10 times, give up.
                if ($tries++ > 10) {
                    throw new RuntimeException('Could not generate a unique hash for link.');
                }
            }
        }

        return $this;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
