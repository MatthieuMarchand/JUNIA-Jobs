<?php

use App\Models\AcademicRecord;
use App\Models\StudentProfile;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for(
    'home',
    fn(BreadcrumbTrail $trail) => $trail->push('Accueil', route('home'))
);

// Student
Breadcrumbs::for(
    'companies.students',
    fn(BreadcrumbTrail $trail) => $trail->push('Profil étudiants', route('companies.students'))
);

Breadcrumbs::for(
    'companies.students.show',
    fn(BreadcrumbTrail $trail, StudentProfile $profile) => $trail
        ->parent('companies.students')
        ->push($profile->fullName(), route('companies.students.show', $profile))
);

// Company Profile
Breadcrumbs::for(
    'companies.profile.show',
    fn(BreadcrumbTrail $trail) => $trail->push('Profil entreprise', route('companies.profile.show'))
);

Breadcrumbs::for(
    'companies.profile.edit',
    fn(BreadcrumbTrail $trail) => $trail
        ->parent('companies.profile.show')
        ->push('Modifier', route('companies.profile.edit'))
);

// Student Profile
Breadcrumbs::for(
    'students.profile.show',
    fn(BreadcrumbTrail $trail) => $trail->push('Mon profil', route('students.profile.show'))
);

Breadcrumbs::for(
    'students.profile.edit',
    fn(BreadcrumbTrail $trail) => $trail
        ->parent('students.profile.show')
        ->push('Modifier', route('students.profile.edit'))
);

Breadcrumbs::for(
    'students.profile.academic-records.create',
    fn(BreadcrumbTrail $trail) => $trail
        ->parent('students.profile.edit')
        ->push('Ajouter une formation', route('students.profile.academic-records.create'))
);

Breadcrumbs::for(
    'students.profile.academic-records.edit',
    fn(BreadcrumbTrail $trail, AcademicRecord $academicRecord) => $trail
        ->parent('students.profile.edit')
        ->push('Modifier une formation', route('students.profile.academic-records.edit', $academicRecord))
);

// Admin
Breadcrumbs::for(
    'admin.home',
    fn(BreadcrumbTrail $trail) => $trail->push('Dashboard', route('admin.home'))
);

Breadcrumbs::for(
    'admin.companies.requests.index',
    fn(BreadcrumbTrail $trail) => $trail
        ->parent('admin.home')
        ->push("Entreprises en attente", route('admin.companies.requests.index'))
);

// Legal
Breadcrumbs::for(
    'legal.index',
    fn(BreadcrumbTrail $trail) => $trail->push('Légal', route('legal.index'))
);

Breadcrumbs::for(
    'legal.gdpr',
    fn(BreadcrumbTrail $trail) => $trail
        ->parent('legal.index')
        ->push('RGPD', route('legal.gdpr'))
);

Breadcrumbs::for(
    'legal.conditions-of-use',
    fn(BreadcrumbTrail $trail) => $trail
        ->parent('legal.index')
        ->push("Conditions d'utilisation", route('legal.conditions-of-use'))
);
