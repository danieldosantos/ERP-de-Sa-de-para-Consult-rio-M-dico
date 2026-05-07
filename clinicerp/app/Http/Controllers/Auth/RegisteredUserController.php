<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usuario;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => array_filter([
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email'),
                Schema::hasTable('usuarios') ? Rule::unique('usuarios', 'email') : null,
            ]),
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (Schema::hasTable('usuarios') && Usuario::where('email', $request->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Este e-mail já está cadastrado em outro usuário.',
            ]);
        }

        try {
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                if (Schema::hasTable('usuarios')) {
                    Usuario::create([
                        'user_id' => $user->id,
                        'nome' => $user->name,
                        'email' => $user->email,
                        'ativo' => true,
                        'is_admin' => false,
                    ]);
                }

                return $user;
            });
        } catch (QueryException $exception) {
            if ($exception->errorInfo[1] === 1062) {
                throw ValidationException::withMessages([
                    'email' => 'Este e-mail já está cadastrado em outro usuário.',
                ]);
            }

            throw $exception;
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
