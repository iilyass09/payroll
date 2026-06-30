<?php

namespace App\Http\Controllers;

use App\Http\Requests\PinUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function pin(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function updatePin(PinUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasPin()) {
            if (!password_verify($request->current_pin, $user->pin_hash)) {
                return back()->withErrors(['current_pin' => 'PIN saat ini tidak sesuai.'])->withInput();
            }
        }

        $isNew = !$user->hasPin();
        $user->pin_hash = bcrypt($request->pin);
        $user->save();

        $message = $isNew ? 'PIN Persetujuan berhasil dibuat.' : 'PIN Persetujuan berhasil diperbarui.';

        return Redirect::route('profile.edit')->with('pin_success', $message);
    }

}
