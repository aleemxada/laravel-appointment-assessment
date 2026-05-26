<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly ReportService $reportService,
    ) {}

    public function index(): View
    {
        $weeklyReport = $this->reportService->getWeeklyAppointmentCountsPerDoctor();

        return view('dashboard', compact('weeklyReport'));
    }
}