<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

Breadcrumbs::for('admin.webstatus.index', function ($trail, $id) {
    $trail->push(__('strings.backend.web_status.title'), route('admin.webstatus.index', $id));
});

require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';
