<?php

declare(strict_types=1);

$files = [
    'database/migrations/006_create_login_attempts.sql',
    'database/migrations/007_create_features_and_billing.sql',
    'database/migrations/008_alter_tenants_add_limits.sql',
    'database/migrations/009_alter_invoices_add_columns.sql',
    'app/Core/Request.php',
    'app/Core/Response.php',
    'app/Services/RateLimitService.php',
    'app/Services/AuthService.php',
    'app/Services/FeatureService.php',
    'app/Services/BillingService.php',
    'app/Services/ClientService.php',
    'app/Controllers/AuthController.php',
    'app/Controllers/FeatureController.php',
    'app/Controllers/InvoiceController.php',
    'app/Controllers/ClientController.php',
    'app/Views/auth/login.php',
    'app/Views/auth/register.php',
    'app/Views/clients/index.php',
    'app/Views/clients/partials/header.php',
    'app/Views/clients/partials/table.php',
    'app/Views/clients/partials/modal_create.php',
    'app/Views/clients/partials/modal_create_fields.php',
    'app/Views/clients/partials/modal_create_features.php',
    'app/Views/clients/partials/modal_delete.php',
    'app/Views/clients/partials/modal_new_feature.php',
    'app/Views/invoices/show.php',
    'app/Views/invoices/partials/receipt_card.php',
    'public/index.php',
    'bootstrap.php',
    'routes/web.php',
    'database/migrate.php'
];

$failed = false;
foreach ($files as $f) {
    $c = count(file(__DIR__ . '/../' . $f));
    $status = $c <= 100 ? 'OK' : 'EXCEEDED';
    echo sprintf("%-58s : %3d baris [%s]\n", $f, $c, $status);
    if ($c > 100) {
        $failed = true;
    }
}

if ($failed) {
    echo "\nADA FILE YANG MELEBIHI 100 BARIS!\n";
    exit(1);
} else {
    echo "\nSEMUA FILE TERVERIFIKASI <= 100 BARIS.\n";
}
