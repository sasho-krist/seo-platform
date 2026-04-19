<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read WordpressConnection|null $wordpressConnection
 */
#[Fillable(['name', 'email', 'password', 'avatar_path'])]
#[Hidden(['password', 'remember_token', 'avatar_path'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @var list<string>
     */
    protected $appends = ['avatar_url'];

    /**
     * @return HasMany<BlogPost, $this>
     */
    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }

    /**
     * @return HasMany<KeywordSuggestion, $this>
     */
    public function keywordSuggestions(): HasMany
    {
        return $this->hasMany(KeywordSuggestion::class);
    }

    /**
     * @return HasMany<CompetitorAnalysis, $this>
     */
    public function competitorAnalyses(): HasMany
    {
        return $this->hasMany(CompetitorAnalysis::class);
    }

    /**
     * @return HasOne<WordpressConnection, $this>
     */
    public function wordpressConnection(): HasOne
    {
        return $this->hasOne(WordpressConnection::class);
    }

    /**
     * @return HasMany<ContentExport, $this>
     */
    public function contentExports(): HasMany
    {
        return $this->hasMany(ContentExport::class);
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if ($this->avatar_path === null || $this->avatar_path === '') {
                    return null;
                }

                $request = request();

                if ($request->getHttpHost() !== '') {
                    return rtrim($request->root(), '/').'/storage/'.$this->avatar_path;
                }

                return Storage::disk('public')->url($this->avatar_path);
            }
        );
    }

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
}
