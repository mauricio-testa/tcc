<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Unidade;

class Active
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $loginSuccess = Auth::attempt([
            'email'     => $request->email, 
            'password'  => $request->password, 
            'status'    => '1']);

        if (!$loginSuccess){
            return $this->handleLoginError ('Essas credenciais não existem ou você está inativo!');
        } else if (!Unidade::UnidadeIsActiveByUserEmail($request->email)) {
            return $this->handleLoginError ('Sua unidade está inativa! Contate o administrador.');
        }
        
        return redirect('/');
    }

    public function handleLoginError($message) {
        Auth::logout();
        return redirect('/login')->with('login_error', $message);
    }
}
