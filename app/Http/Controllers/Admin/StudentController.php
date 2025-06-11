<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        return view('admin.students.index', [
            'users' => User::where('role', UserRole::Student)
                ->with('studentProfile')
                ->paginate(20),
        ]);
    }

    public function destroy(User $student): RedirectResponse
    {
        Gate::authorize('delete', $student);

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Compte étudiant supprimé avec succès.');
    }
}
