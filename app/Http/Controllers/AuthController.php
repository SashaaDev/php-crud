<?php

namespace App\Http\Controllers;

use App\DTO\UserRegistrationDTO;
use App\DTO\UserLoginDTO;
use App\Http\Requests\AppUserRequest;
use App\Http\Requests\RegistartionRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\AuthService;
use Exception;
// use Illuminate\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

use function PHPSTORM_META\type;

class AuthController extends Controller
{
    public function __construct(public readonly AuthService $authService)
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(LoginRequest $loginRequest)
    {
        $credentials = new UserLoginDTO(
            email: $loginRequest->get('email'),
            password: $loginRequest->get('password')
        );
        return $this->authService->loginAuth($credentials);
    }

    public function registration(RegistartionRequest $registartionRequest): array
    {
        $credentials = new UserRegistrationDTO(
            name: $registartionRequest->get('name'),
            email: $registartionRequest->get('email'),
            password: $registartionRequest->get('password')
        );

        return $this->authService->registrationUser($credentials);
    }

    public function generateHash(string $email): array
    {
        return $this->authService->emailInviteCheck($email);
    }

    public function generateBcrypt(array $user): array
    {
        return $this->authService->hashUpdate($user);
    }
}
