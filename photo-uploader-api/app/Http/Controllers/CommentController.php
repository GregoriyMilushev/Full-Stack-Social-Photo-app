<?php

namespace App\Http\Controllers;

use App\Domain\Messaging\Repositories\CommentRepository;
use App\Domain\Support\DTO\PaginationData;
use App\Domain\Workflow\Actions\CreateCommentAction;
use App\Domain\Workflow\Actions\UpdateCommentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentCreateRequest;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CommentController extends Controller
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * LIST
     *
     * @queryParam filter[conversation.id] string Find ConversationMessages by Conversation.id
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter');

        if (!$filter || !array_key_exists('photo.id', $filter)) {
            throw new UnprocessableEntityHttpException('Comments can only be fetched for a specific photo via filter[photo.id]');
        }

        $with = [
            'user' => function ($q) {
                $q->select('id', 'first_name', 'last_name');
            },
            'photo'=> function ($q) {
                $q->select('id', 'user_id');
            },
        ];

        $comments =  $this->commentRepository->all($with, PaginationData::fromRequest($request));

        return CommentResource::collection(
            $comments
        );
    }

    /**
     * CREATE
     *
     * @bodyParam photo_id string required
     * @bodyParam message string required
     *
     * @param CommentCreateRequest $request
     * @param CreateCommentAction $createCommentAction
     * @return CommentResource
     */
    public function store(CommentCreateRequest $request, CreateCommentAction $createCommentAction)
    {
        $comment = $createCommentAction($request->all());

        $comment->load([
            'user' => function ($q) {
                $q->select('id', 'first_name', 'last_name');
            },
            'photo'=> function ($q) {
                $q->select('id', 'user_id');
            },
        ]);

        return new CommentResource($comment);
    }

    /**
     * UPDATE
     *
     * @param Request $request
     * @return CommentResource
     */
    public function update(Request $request, UpdateCommentAction $updateCommentAction, $id)
    {
        $comment = $updateCommentAction($id, $request->only(['message']));

        $comment->load([
            'user' => function ($q) {
                $q->select('id', 'first_name', 'last_name');
            },
            'photo'=> function ($q) {
                $q->select('id', 'user_id');
            },
        ]);

        return new CommentResource($comment);
    }


    /**
     * DELETE
     *
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        return $this->commentRepository->delete($id);
    }
}
