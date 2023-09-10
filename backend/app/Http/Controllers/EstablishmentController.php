<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Establishment\CreateEstablishmentRequest;
use App\Http\Requests\Establishment\UpdateEstablishmentRequest;
use App\Http\Resources\EstablishmentResource;
use App\Models\Establishment;
use App\Models\User;
use App\Services\Address\CreateAddressService;
use App\Services\Address\UpdateAddressService;
use App\Services\Establishment\CreateEstablishmentService;
use App\Services\Establishment\UpdateEstablishmentService;
use App\Services\User\CreateUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Validation\ValidationException;

class EstablishmentController extends Controller
{
    public function __construct(
        private CreateAddressService $createAddressService,
        private CreateEstablishmentService $createEstablishmentService,
        private CreateUserService $createUserService,
        private UpdateAddressService $updateAddressService,
        private UpdateUserService $updateUserService,
        private UpdateEstablishmentService $updateEstablishmentService
    ) {
    }

    public function index()
    {
        try {
            // pegar pelo usuário autenticado qual o estabelecimento ou pegar pelo estabelecimento ativo só terá um
            $establishment = Establishment::find(1);

            $establishment->load(['address', 'user']);

            return response()->json(new EstablishmentResource($establishment), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao listar estabelecimento',
            ], 401);
        }
    }

    public function store(CreateEstablishmentRequest $request)
    {
        try {
            $data = $request->validated();

            $address = $this->createAddressService->handle($data);

            $establishment = $this->createEstablishmentService->handle($data, $address);

            $this->createUserService->handle($data, $establishment);

            $establishment->load(['address', 'user']);

            return response()->json(new EstablishmentResource($establishment), 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao criar estabelecimento',
            ], 401);
        }
    }

    public function update(UpdateEstablishmentRequest $request)
    {
        try {
            $data = $request->validated();

            //update address
            $this->updateAddressService->handle($data);

            $user = User::findOrFail($data['user_id']);

            if (isset($data['password']) || $user->email !== $data['email']) {
                //update user
                $this->updateUserService->handle($data, $user);
            }

            //update establishment
            $establishment = $this->updateEstablishmentService->handle($data);

            $establishment->load(['address', 'user']);

            return response()->json(new EstablishmentResource($establishment), 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro ao atualizar estabelecimento',
            ], 401);
        }
    }
}
