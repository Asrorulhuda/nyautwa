<?php
/**
 * Sidebar Navigation Orchestrator
 * Modularized to strictly respect <= 100 lines per file
 */
$userRole = $_SESSION['user_role'] ?? ($_SESSION['user']['role'] ?? 'client');
$isAdmin = in_array($userRole, ['admin', 'superadmin'], true);
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
