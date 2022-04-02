<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserResourceCollection;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return UserResourceCollection
     */
    public function index()
    {
        return new UserResourceCollection($this->user->index());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|UserResource
     */
    public function store(UserRequest $request)
    {
        try {
            $user = $this->user->createOrUpdate($request->all());
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('user.store', null, $e);
        }

        return new UserResource($user, array('type' => 'store', 'route' => 'user.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|UserResource
     */
    public
    function show($id)
    {
        try {
            $data = $this->user->show($id);
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('user.show', $id, $e);
        }
        return new UserResource($data, array('type' => 'show', 'route' => 'user.show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse|UserResource
     */
    public
    function update(UserRequest $request, $id)
    {
        try {
            $user = $this->user->createOrUpdate($request->all(), $id);
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('user.update', $id, $e);
        }

        return new UserResource($user, array('type' => 'update', 'route' => 'user.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|UserResource|Response
     */
    public
    function destroy($id)
    {
        try {
            $data = $this->user->remove($id);
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('user.destroy', $id, $e);
        }

        return new UserResource($data, array('type' => 'destroy', 'route' => 'user.destroy'));
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            $token = $this
                ->user
                ->login($credentials);
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('user.login', null, $e);
        }
        return response()->json(compact('token'));
    }

    /**
     * Logout user
     *
     * @param Request $request
     * @return JsonResponse|UserResource|Response
     */
    public function logout(Request $request)
    {
        try {
            $this
                ->user
                ->logout($request->input('token'));
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('user.logout', null, $e);
        }

        return response(['status' => true, 'msg' => 'Deslogado com sucesso'], 200);
    }

}
