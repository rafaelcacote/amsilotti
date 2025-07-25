<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\ValidCpf;
use App\Helpers\CpfHelper;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
        // Limpa o CPF antes da validação
        $cpf = CpfHelper::clean($request->cpf);
        $request->merge(['cpf' => $cpf]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'cpf' => ['required', 'string', 'size:11', 'unique:'.User::class, new ValidCpf()],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'cpf.unique' => 'Este CPF já está cadastrado em nosso sistema.',
            'cpf.size' => 'O CPF deve conter exatamente 11 dígitos.',
            'email.unique' => 'Este e-mail já está cadastrado em nosso sistema.',
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Por favor, digite um e-mail válido.',
            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'cpf' => $cpf,
                'password' => Hash::make($request->password),
            ]);

            // Atribuir automaticamente o role "cliente_amostra" para novos usuários
            $user->assignRole('cliente_amostra');

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('consulta-cliente.index', absolute: false))->with('success', 'Conta criada com sucesso! Bem-vindo ao Sistema Amsillote.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao criar conta. Tente novamente.'])->withInput();
        }
    }
}
