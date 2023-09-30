<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientRequest;
use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\User;
use App\Services\Client\CreateClientService;
use App\Services\Client\UpdateClientService;
use App\Services\User\CreateUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function __construct(
        private CreateUserService $createUserService,
        private UpdateUserService $updateUserService,
        private CreateClientService $createClientService,
        private UpdateClientService $updateClientService,
    ) {
    }

    public function show(ClientRequest $request)
    {
        try {
            //get one client
            $data = $request->validated();

            $client = Client::findOrFail($data['id'])->load(['user']);

            return response()->json(new ClientResource($client), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar cliente',
            ], 401);
        }
    }

    public function store(CreateClientRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            //create user
            $user = $this->createUserService->handle($data, null);
            
            $client = $this->createClientService->handle($data, $user);

            $client->load(['user']);

            DB::commit();
            return response()->json(new ClientResource($client), 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao criar cliente',
            ], 401);
        }
    }

    public function update(UpdateClientRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $user = User::findOrFail($data['user_id']);

            if (isset($data['password']) || $user->email !== $data['email']) {
                //update user
                $this->updateUserService->handle($data, $user);
            }
            
            $client = $this->updateClientService->handle($data);

            $client->load(['user']);

            DB::commit();
            return response()->json(new ClientResource($client), 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar cliente',
            ], 401);
        }
    }
}
