<?php
/**
 * Sidebar Navigation Orchestrator
 * Modularized to strictly respect <= 100 lines per file
 */
$userRole = $_SESSION['user_role'] ?? ($_SESSION['user']['role'] ?? 'client');
$isAdmin = in_array($userRole, ['admin', 'superadmin'], true);
$tenantId = $_SESSION['tenant']['id'] ?? ($_SESSION['user']['tenant_id'] ?? 'system');
$subService = new \App\Services\SubscriptionService();
$canCrm = $isAdmin || $subService->canAccess($tenantId, 'crm');
$canSend = $isAdmin || $subService->canAccess($tenantId, 'send_message');
$canAuto = $isAdmin || $subService->canAccess($tenantId, 'autoreply');
$canBlast = $isAdmin || $subService->canAccess($tenantId, 'broadcast');
$canApi = $isAdmin || $subService->canAccess($tenantId, 'api_keys');
?>
<!-- 1. Workspace Section -->
<?php require __DIR__ . '/sidebar_nav_workspace.php'; ?>

<!-- 2. Marketing & Automation Section -->
<?php require __DIR__ . '/sidebar_nav_marketing.php'; ?>

<?php if ($isAdmin): ?>
    <!-- Admin Management Section -->
    <?php require __DIR__ . '/sidebar_nav_admin.php'; ?>
<?php endif; ?>

<!-- 3. Developer Section -->
<?php require __DIR__ . '/sidebar_nav_developer.php'; ?>

<!-- 4. Client Billing & Subscription Section -->
<?php require __DIR__ . '/sidebar_nav_billing.php'; ?>
