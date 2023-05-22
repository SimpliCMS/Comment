<?php

namespace Modules\Comment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Comment\Contracts\Reply as ReplyContract;
use Modules\User\Models\User;
use Modules\Comment\Models\Comment;
use Carbon\Carbon;

class Reply extends Model implements ReplyContract {

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

    public function comment() {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

    public function timeAgo() {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

}
