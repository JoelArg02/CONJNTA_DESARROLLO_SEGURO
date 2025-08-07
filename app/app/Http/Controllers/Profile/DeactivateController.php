<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeactivateController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->is_active = false;
        $user->deactivation_reason = $request->reason;
        $user->save();

        activity()
            ->causedBy($user)
            ->withProperties(['reason' => $request->reason])
            ->log('El usuario desactivó su cuenta');

        Auth::logout();

        return redirect()->route('login')->withErrors([
            'email' => 'Tu cuenta ha sido desactivada. Motivo: ' . $request->reason,
        ]);
    }
}