<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for(
    'home',
    fn(BreadcrumbTrail $trail) => $trail->push('Accueil', route('home'))
);

// Admin
Breadcrumbs::for(
    'admin.home',
    fn(BreadcrumbTrail $trail) => $trail->push('Dashboard', route('admin.home'))
);

// Home >
Breadcrumbs::for(
    'admin.companies.requests.index',
    fn(BreadcrumbTrail $trail) => $trail
        ->parent('admin.home')
        ->push("Entreprises en attente", route('admin.companies.requests.index'))
);

