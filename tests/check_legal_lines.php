<?php
$files = [
    'app/Controllers/LegalController.php',
    'routes/legal.php',
    'app/Views/pages/legal/terms.php',
    'app/Views/pages/legal/privacy.php',
    'app/Views/pages/legal/sla.php',
    'app/Views/pages/legal/contact.php',
    'app/Services/LogoUploadService.php',
    'app/Views/landing/partials/client_showcase.php',
    'app/Views/auth/register.php',
    'app/Views/layouts/landing.php',
    'app/Services/AuthService.php',
    'app/Controllers/AuthController.php',
    'app/Controllers/LandingController.php',
    'app/Views/landing/index.php',
    'app/Views/landing/partials/footer.php',
    'app/Views/landing/partials/developer_code.php',
    'app/Views/landing/partials/developer_snippets.php',
    'app/Services/PlanService.php',
    'app/Controllers/OnboardingPlanController.php',
    'app/Views/onboarding/plan.php',
];
$allOk = true;
foreach ($files as $f) {
    if (!file_exists($f)) {
        echo "$f : NOT FOUND\n";
        $allOk = false;
        continue;
    }
    $lines = count(file($f));
    printf("%-50s : %3d baris [%s]\n", $f, $lines, $lines <= 100 ? 'OK' : 'FAIL');
    if ($lines > 100) $allOk = false;
}
if ($allOk) {
    echo "\nSELURUH FILE BARU & DIMODIFIKASI TERVERIFIKASI STRICTLY <= 100 BARIS.\n";
} else {
    echo "\nPERINGATAN: ADA FILE MELEBIHI 100 BARIS!\n";
}
