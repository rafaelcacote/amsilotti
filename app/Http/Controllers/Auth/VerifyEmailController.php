<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Redirecionar usuários cliente_amostra para a página de consulta
            if ($request->user()->hasRole('cliente_amostra')) {
                return redirect()->intended(route('consulta.cliente.index').'?verified=1');
            }
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Redirecionar usuários cliente_amostra para a página de consulta
        if ($request->user()->hasRole('cliente_amostra')) {
            return redirect()->intended(route('consulta.cliente.index').'?verified=1');
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
