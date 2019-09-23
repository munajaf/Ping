<?php

namespace App\Models;

use Spatie\Url\Url;
use App\Models\Auth\User;
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

    public function userMonitors()
    {
        return $this->belongsToMany(User::class, 'user_monitors')->withTimestamps();
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
