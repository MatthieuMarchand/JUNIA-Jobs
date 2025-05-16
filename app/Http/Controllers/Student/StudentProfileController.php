<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use function to_route;

class StudentProfileController extends Controller
{
    public function show()
    {
        // TODO : page pour consulter son profil
    }

    public function edit()
    {
        return view('students.profile', [
            'studentProfile' => Auth::user()->studentProfile()->firstOrNew(), // si pas de studentProfile, en crée un (pas dans la db)
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'phone_number' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        $profile = $user->studentProfile()->firstOrNew();

        $profile->first_name = $validated['first_name'];
        $profile->last_name = $validated['last_name'];
        $profile->summary = $validated['summary'];
        $profile->phone_number = $validated['phone_number'];

        if ($profile->photo_path && $request->has('photo')) {
            Storage::delete($profile->photo_path);
            $profile->photo_path = null;
        }
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos');
            $profile->photo_path = $path;
        }

        $profile->save();

        return to_route('students.profile.edit');
    }
}
