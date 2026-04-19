<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'your_url', 'competitor_url', 'your_excerpt', 'competitor_excerpt', 'analysis'])]
class CompetitorAnalysis extends Model
{
    #[\Override]
    public function resolveRouteBinding($value, $field = null)
    {
        $field ??= $this->getRouteKeyName();

        $row = $this->where($field, $value)
            ->where('user_id', auth()->id())
            ->first();

        if ($row === null) {
            throw new NotFoundHttpException;
        }

        return $row;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
