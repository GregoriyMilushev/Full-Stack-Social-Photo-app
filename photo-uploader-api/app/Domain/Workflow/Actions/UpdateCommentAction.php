<?php

namespace App\Domain\Workflow\Actions;

use App\Domain\Messaging\Repositories\CommentRepository;
use App\Domain\Workflow\Models\Comment;
use Exception;

class UpdateCommentAction
{
    /**
     * @var CommentRepository
     */
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param PhotoData $photoData
     * @return Photo $photo
     */
    public function __invoke($id, array $commentData): Comment
    {
        $currentComment = $this->commentRepository->get($id);
        $user = auth()->user();

        if ($currentComment->user_id !== $user->id) {
            throw new Exception('Unexpected error');
        }

        $comment = $this->commentRepository->update($id, $commentData);

        return $comment;
    }
}
