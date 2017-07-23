<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use DB;

class DashboardController extends Controller
{
    public function redirectToDashboard()
    {
        return redirect('/admin/dashboard');
    }

    public function overview()
    {
        $events = DB::table('event_store')->get();

        return view('admin.overview', [
            'events' => $events
        ]);
    }

    public function analytics()
    {
        return view('admin.analytics');
    }

    public function export()
    {
        return view('admin.export');
    }
}
