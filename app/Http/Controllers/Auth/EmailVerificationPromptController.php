<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Redirecionar usuários cliente_amostra para a página de consulta
            if ($request->user()->hasRole('cliente_amostra')) {
                return redirect()->intended(route('consulta.cliente.index'));
            }
            return redirect()->intended(route('dashboard', absolute: false));
        }
        
        return view('auth.verify-email');
    }
}
