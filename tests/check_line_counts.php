<?php

declare(strict_types=1);

$files = [
    'database/migrations/010_create_mpwa_features.sql',
    'engine/server.js',
    'engine/src/config.js',
    'engine/src/baileysSocket.js',
    'engine/src/eventHandler.js',
    'engine/src/messageSender.js',
    'engine/src/sessionManager.js',
    'app/Services/EngineService.php',
    'app/Services/AutoReplyService.php',
    'app/Services/ContactService.php',
    'app/Services/CampaignService.php',
    'app/Controllers/DeviceSessionController.php',
    'app/Controllers/Api/InternalCallbackController.php',
    'app/Controllers/AutoReplyController.php',
    'app/Controllers/ContactController.php',
    'app/Controllers/CampaignController.php',
    'app/Views/autoreplies/index.php',
    'app/Views/autoreplies/partials/modal_create.php',
    'app/Views/contacts/index.php',
    'app/Views/contacts/partials/modal_create.php',
    'app/Views/campaigns/index.php',
    'app/Views/campaigns/partials/modal_create.php',
    'app/Views/devices/connect.php',
    'app/Views/devices/partials/tab_qr.php',
    'app/Views/devices/partials/tab_pairing.php',
    'app/Views/devices/partials/connect_script.php',
    'app/Views/partials/sidebar_nav_marketing.php',
    'app/Views/partials/sidebar_nav.php',
    'routes/web.php'
];

$failed = false;
foreach ($files as $f) {
    $full = __DIR__ . '/../' . $f;
    if (!file_exists($full)) {
        echo "FILE NOT FOUND: $f\n";
        $failed = true;
        continue;
    }
    $c = count(file($full));
    $status = $c <= 100 ? 'OK' : 'EXCEEDED';
    echo sprintf("%-55s : %3d baris [%s]\n", $f, $c, $status);
    if ($c > 100) $failed = true;
}

if ($failed) {
    echo "\nADA FILE YANG MELEBIHI 100 BARIS!\n";
    exit(1);
} else {
    echo "\nSEMUA FILE FITUR TERBARU TERVERIFIKASI <= 100 BARIS.\n";
}
