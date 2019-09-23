<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMonitorRequest;
use App\Models\Monitor;
use Spatie\Url\Url;

/**
 * Class Models\DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $monitors = Monitor::with('userMonitors')->get();

        return view('frontend.user.dashboard', compact('monitors'));
    }

    public function store(CreateMonitorRequest $request)
    {

        $url = Url::fromString($request->url);
        if (! in_array($url->getScheme(), ['http', 'https'])) {
            $url = $url->withScheme('http');
        }
        $monitor = Monitor::create([
            'url' => trim($url, '/'),
            'look_for_string' => $lookForString ?? '',
            'uptime_check_method' => isset($lookForString) ? 'get' : 'head',
            'certificate_check_enabled' => false,
            'uptime_check_interval_in_minutes' => config('uptime-monitor.uptime_check.run_interval_in_minutes'),
        ]);

        $monitor->userMonitors()->attach(\Auth::id());

        return redirect()->route('frontend.user.dashboard')->withFlashSuccess($url . ' Will be monitored!');
    }

    public function destroy(Monitor $monitorId)
    {
        $monitorId->deleteRelation();

        return redirect()->route('frontend.user.dashboard')->withFlashSuccess($monitorId->url . ' Deleted');
    }

    public function enable(Monitor $monitorId)
    {
        $monitorId->enable();

        return redirect()->route('frontend.user.dashboard')->withFlashSuccdess($monitorId->url . ' Enabled');
    }

    public function disable(Monitor $monitorId)
    {
        $monitorId->disable();

        return redirect()->route('frontend.user.dashboard')->withFlashSuccdess($monitorId->url . ' Disabled');
    }
}
