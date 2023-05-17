<?php

namespace Modules\Comment\Models;

use Modules\Comment\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Commentable {

    /**
     * @return mixed
     */
    public function comments(): MorphMany {
        return $this->morphMany(Comment, 'commentable')->whereNull('parent_id');
    }

    /**
     * @return mixed
     */
    public function allComments(): MorphMany {
        return $this->morphMany(Comment, 'commentable');
    }

    /**
     * @return mixed
     */
    public function activeComments(): MorphMany {
        return $this->morphMany(Comment, 'commentable')->whereNull('parent_id')->where('active', true);
    }

    /**
     * @return mixed
     */
    public function allActiveComments(): MorphMany {
        return $this->morphMany(Comment, 'commentable')->where('active', true);
    }

    /**
     * @param $data
     * @param Model      $creator
     * @param Model|null $parent
     *
     * @return static
     */
    public function comment($data, Model $creator, Model $parent = null) {

        $comment = (new Comment)->createComment($this, $data, $creator);

        if (!empty($parent)) {
            $parent->appendNode($comment);
        }

        return $comment;
    }

    /**
     * @param $id
     * @param $data
     * @param Model|null $parent
     *
     * @return mixed
     */
    public function updateComment($id, $data, Model $parent = null) {

        $comment = (new Comment)->updateComment($id, $data);

        if (!empty($parent)) {
            $parent->appendNode($comment);
        }

        return $comment;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteComment($id): bool {

        return (bool) (new Comment)->deleteComment($id);
    }

    /**
     * @return mixed
     */
    public function commentCount(): int {
        return $this->allComments()->count();
    }

}
