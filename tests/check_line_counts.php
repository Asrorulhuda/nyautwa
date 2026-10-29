<?php

declare(strict_types=1);

$files = [
    'database/full_master_database.sql', 'database/schema.sql', 'database/seeds.sql', 'database/sync_all.php',
    'database/migrations/010_create_mpwa_features.sql', 'database/migrations/011_alter_contacts_for_groups.sql',
    'engine/server.js', 'engine/src/config.js', 'engine/src/baileysSocket.js', 'engine/src/eventHandler.js',
    'engine/src/messageSender.js', 'engine/src/nativeButtonHelper.js', 'engine/src/pollHandler.js', 'database/update_db.php',
    'app/Services/EngineService.php', 'app/Services/DatabaseUpdateService.php', 'app/Services/AutoReplyService.php',
    'app/Services/ContactService.php', 'app/Services/CampaignService.php', 'app/Services/DeviceService.php',
    'app/Services/ExcelParserService.php', 'app/Services/AutoReplyImportService.php', 'app/Services/ChatService.php',
    'app/Controllers/DeviceSessionController.php', 'app/Controllers/Api/InternalCallbackController.php',
    'app/Controllers/Api/DeployController.php', 'app/Controllers/DatabaseUpdateController.php',
    'app/Controllers/AutoReplyController.php', 'app/Controllers/ContactController.php', 'app/Controllers/CampaignController.php',
    'app/Controllers/DeviceController.php', 'app/Controllers/ApiKeyController.php', 'app/Controllers/MessageController.php',
    'app/Controllers/AutoReplyImportController.php', 'app/Controllers/ChatController.php',
    'app/Controllers/Concerns/ParsesAutoReplyInput.php', 'app/Controllers/Concerns/InteractsWithMessagePayload.php',
    'routes/web.php', 'scripts/generate_template_xlsx.php',
    'app/Views/chat/index.php', 'app/Views/chat/partials/conversation_list.php', 'app/Views/chat/partials/chat_box.php',
    'app/Views/chat/partials/tab_conversations.php', 'app/Views/chat/partials/tab_contacts.php',
    'app/Views/chat/partials/chat_script.php', 'app/Views/chat/partials/chat_ui_script.php',
    'app/Views/chat/partials/chat_msg_script.php', 'app/Views/autoreplies/index.php', 'app/Views/autoreplies/partials/table.php',
    'app/Views/autoreplies/partials/bulk_bar.php', 'app/Views/autoreplies/partials/modal_import.php',
    'app/Views/partials/sidebar_nav_workspace.php', 'docs/cpanel/README.md', 'docs/cpanel/01_database_and_env.md',
    'docs/cpanel/02_nodejs_engine.md'
];

$failed = false;
foreach ($files as $f) {
    $full = __DIR__ . '/../' . $f;
    if (!file_exists($full)) { echo "FILE NOT FOUND: $f\n"; $failed = true; continue; }
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
