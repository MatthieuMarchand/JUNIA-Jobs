<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\ContractType;
use App\Models\Domain;
use App\Models\Skill;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ListStudentsProfilesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Gate::authorize('viewAny', StudentProfile::class);

        // Ajouter un log pour déboguer les paramètres reçus
        Log::info('Filtrage étudiants', [
            'domain_names' => $request->research_domain_names,
            'skill_names' => $request->skill_names,
            'contract_type_ids' => $request->contract_type_ids,
        ]);

        $validated = $request->validate([
            'research_area_ids' => ['nullable', 'array'],
            'research_area_ids.*' => 'exists:research_areas,id',

            'skill_names' => ['nullable', 'array'],
            'skill_names.*' => 'string',

            'contract_type_ids' => ['nullable', 'array'],
            'contract_type_ids.*' => 'exists:contract_types,id',

            'research_domain_names' => ['nullable', 'array'],
            'research_domain_names.*' => 'string',
        ]);

        $query = StudentProfile::query();

        // Optimisation du filtrage par compétence
        if ($request->filled('skill_names')) {
            $skillNames = $request->skill_names;
            Log::info('Filtrage par compétences', ['skills' => $skillNames]);

            $query->whereHas('skills', function ($skillQuery) use ($skillNames) {
                $skillQuery->whereIn('name', $skillNames);
            });
        }

        // Filtrage par domaine
        if ($request->filled('research_domain_names')) {
            $domainNames = $request->research_domain_names;
            Log::info('Filtrage par domaines', ['domains' => $domainNames]);

            // Vérifiez si elles existent
            $domainsExist = Domain::whereIn('name', $domainNames)->get();
            Log::info('Domaines trouvés en base', [
                'requested' => $domainNames,
                'found' => $domainsExist->pluck('name')->toArray(),
                'count' => $domainsExist->count(),
            ]);

            $query->whereHas('domains', function ($domainQuery) use ($domainNames) {
                $domainQuery->whereIn('name', $domainNames);
            });

            $testProfiles = StudentProfile::whereHas('domains', function ($q) use ($domainNames) {
                $q->whereIn('name', $domainNames);
            })->get();

            Log::info('Test - Profils avec ces domaines', [
                'count' => $testProfiles->count(),
                'profiles' => $testProfiles->pluck('id')->toArray(),
            ]);
        }

        // Filtrage par type de contrat
        if ($request->filled('contract_type_ids')) {
            $contractTypeIds = $request->contract_type_ids;
            Log::info('Filtrage par types de contrat', ['contract_types' => $contractTypeIds]);

            $query->whereHas('contractTypes', function ($contractTypeQuery) use ($contractTypeIds) {
                $contractTypeQuery->whereIn('id', $contractTypeIds);
            });
        }

        // Récupération des étudiants filtrés
        $students = $query->get();
        Log::info('Nombre d\'étudiants trouvés', ['count' => $students->count()]);

        // Récupération des listes pour les filtres
        $domains = Domain::all();
        $skills = Skill::all();
        $contractTypes = ContractType::all();

        return view('students.profiles.index', compact('students', 'domains', 'skills', 'contractTypes'));
    }
}
