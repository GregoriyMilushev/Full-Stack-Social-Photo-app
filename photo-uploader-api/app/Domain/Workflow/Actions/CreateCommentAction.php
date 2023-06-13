<?php

namespace App\Domain\Workflow\Actions;

use App\Domain\Messaging\Repositories\CommentRepository;
use App\Domain\Workflow\Models\Comment;


class CreateCommentAction
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
     * @param array $commentData
     * @return Comment $comment
     */
    public function __invoke(array $commentData): Comment
    {
        $user = auth()->user();
        $comment = $this->commentRepository->create(array_merge(
            $commentData,
            ['user_id' => $user->id]
        ));

        return $comment;
    }
}
