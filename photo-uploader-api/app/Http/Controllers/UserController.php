<?php

namespace App\Http\Controllers;

use App\Domain\Auth\Models\Role;
use App\Domain\Auth\Repositories\UserRepository;
use App\Domain\Support\DTO\PaginationData;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->middleware('auth.admin', ['only' => ['destroy']]);
    }

    /**
     * LIST
     *
     * @queryParam user.id string Find Photos with exact match on [Photo.user.id]
     * @queryParam sort string Sort Photo by a column. Allowed columns [created_at]. For asc order, use sort=-created_at (note the minus sign)
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return UserResource::collection(
            $this->userRepository->all(['uploadedBy'], PaginationData::fromRequest($request), function ($q) {
                $q->whereHas('role', function ($q) {
                    $q->where('name', Role::$ROLE_ADMIN);
                });
            })
        );
    }


    /**
     * GET
     *
     * @param Request $request
     * @param $id
     */
    public function show(Request $request, $id)
    {
        $user = $this->userRepository->get($id);
        
        return new UserResource($user);
    }

    /**
     * DELETE
     *
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        return $this->userRepository->delete($id);
    }
}
