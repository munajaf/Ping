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
        $monitors = Monitor::getList();
        return view('frontend.user.dashboard', compact('monitors'));
    }

    public function store(CreateMonitorRequest $request)
    {

        $url = Url::fromString($request->url);
        if (! in_array($url->getScheme(), ['http', 'https'])) {
            $url = $url->withScheme('http');
        }

        Monitor::createMonitor($url);

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
