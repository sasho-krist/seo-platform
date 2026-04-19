<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read SeoMeta|null $seoMeta
 */
#[Fillable(['user_id', 'title', 'slug', 'body', 'tone', 'language', 'status'])]
class BlogPost extends Model
{
    #[\Override]
    public function resolveRouteBinding($value, $field = null)
    {
        $field ??= $this->getRouteKeyName();

        $post = $this->where($field, $value)
            ->where('user_id', auth()->id())
            ->first();

        if ($post === null) {
            throw new NotFoundHttpException;
        }

        return $post;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seoMeta(): HasOne
    {
        return $this->hasOne(SeoMeta::class);
    }
}
