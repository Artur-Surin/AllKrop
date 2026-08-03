<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ContentService;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $serviceGroups = ContentService::serviceGroups();
        $categories = ContentService::serviceCategories();
        $offices = ContentService::serviceOffices();

        return view('services.index', compact('serviceGroups', 'categories', 'offices'));
    }

    public function show(string $slug): View
    {
        $service = ContentService::getServiceBySlug($slug);

        if (! $service) {
            abort(404);
        }

        $offices = ContentService::serviceOffices();
        $institution = ContentService::getInstitution($slug);

        return view('services.show', compact('service', 'offices', 'institution'));
    }
}
