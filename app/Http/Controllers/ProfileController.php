<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

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
        $user = $request->user();

        $validatedData = $request->validated();

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
        
            $path = $request->file('photo')->store('photo', 'public');
            $user->photo = $path;
        }
        
        // // ✅ Perbaikan: Set default hanya jika kosong atau file tidak ditemukan
        // if (!$user->photo || !Storage::disk('public')->exists($user->photo)) {
        //     $user->photo = 'profile.jpeg'; // Pastikan ini ada di public/storage/default/profile.jpg
        // }
        

        
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->fill($validatedData);
        $user->save();
        

        return Redirect::route('profile.edit')->with('status', 'profile-updated');

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
