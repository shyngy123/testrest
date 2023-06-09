<?php

namespace App\Http\Controllers\Api\v1;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\loginRequest;



class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // Валидация входных данных
        $data = $request->validated();

        // Создание нового пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Возвращение данных пользователя и токена доступа
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken,
        ]);
    }

    public function login(loginRequest $request)
    {
        $data = $request->validated();

        // Аутентификация пользователя
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Возвращение данных пользователя и токена доступа
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('API Token')->plainTextToken,
            ]);
        }

        // Если аутентификация не удалась
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
