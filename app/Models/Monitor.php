<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Url\Url;
use Illuminate\Database\Eloquent\Model;


class Monitor extends Model
{

    public $timestamps = true;

    protected $guarded = [];

    protected $appends = ['raw_url'];

    protected $dates = [
        'uptime_last_check_date',
        'uptime_status_last_change_date',
        'uptime_check_failed_event_fired_on_date',
        'certificate_expiration_date',
    ];

    protected $casts = [
        'uptime_check_enabled' => 'boolean',
        'certificate_check_enabled' => 'boolean',
    ];

    public static function getList()
    {
        $monitors = Monitor::where('user_id', auth()->user()->id)->get()->map(function ($monitor) {
            $monitor->uptime_status = ($monitor->uptime_status == "up") ? 1 : (($monitor->uptime_status == "down") ? 0 : 2);
            $monitor->online_since = ($monitor->uptime_status !== 2) ? Carbon::parse($monitor->uptime_status_last_change_date)->diffForHumans() : "Pending";
            $monitor->link = ($monitor->uptime_check_enabled) ?
                "<a href=".route('frontend.user.monitor.disable', $monitor->id).">Disable</a>" :
                "<a href=".route('frontend.user.monitor.enable', $monitor->id).">Enable</a>";
            return $monitor;
        });
        return $monitors;
    }

    public static function createMonitor($url)
    {
        Monitor::create([
            'user_id' => auth()->user()->id,
            'url' => trim($url, '/'),
            'look_for_string' => $lookForString ?? '',
            'uptime_check_method' => isset($lookForString) ? 'get' : 'head',
            'certificate_check_enabled' => false,
            'uptime_check_interval_in_minutes' => config('uptime-monitor.uptime_check.run_interval_in_minutes'),
        ]);
    }

    public function enable()
    {
        $this->url = Url::fromString($this->url);

        $this->uptime_check_enabled = true;

        if ($this->url->getScheme() === 'https') {
            $this->certificate_check_enabled = true;
        }

        $this->save();

        return $this;
    }

    public function disable()
    {
        $this->uptime_check_enabled = false;
        $this->certificate_check_enabled = false;

        $this->save();

        return $this;
    }

    public function deleteRelation()
    {
        $this->userMonitors()->detach();
        $this->delete();
        return true;
    }

}
