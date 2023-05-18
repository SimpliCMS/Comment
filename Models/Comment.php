<?php

namespace Modules\Comment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\User;
use Carbon\Carbon;

class Comment extends Model {

    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'comment',
        'user_id',
        'parent_id',
        'type',
        'type_id',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent(): BelongsTo {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function replies(): HasMany {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function timeAgo() {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

}
