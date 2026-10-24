# Client Management, Dynamic Features, Payment Methods & Automated Invoice Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build client deletion, "Tambahkan Pengguna" modal matching user mockup with dynamic feature checkboxes, dynamic feature catalog management for admin, payment methods setup, and automated billing invoices (nota pembayaran).

**Architecture:** Clean PHP Native MVC with prepared statements, modular sub-views under 100 lines, dedicated `FeatureService`, `BillingService`, enhanced `ClientService`, and Tailwind CSS UI following NyautWa Design System tokens (`#F6F8F7`, `#FFFFFF`, `#16A36A`, `#17211F`).

**Tech Stack:** PHP 8.2+, SQLite / MySQL PDO, Tailwind CSS, Vanilla JS.

**Spec:** User uploaded modal reference "Tambahkan Pengguna", `AGENTS.md` rules (<= 100 lines per file, PDO prepared statements, CSRF, clean Indonesian copywriting).

## Global Constraints
- Every file MUST be `<= 100 lines` of code.
- All database mutations must use prepared statements and CSRF token verification.
- Output escaping via `e()` or `htmlspecialchars()`.
- Copywriting in professional Indonesian business terminology.

---

### Task 1: Database Migration for Features, Payment Methods, and Invoices

**Files:**
- Create: `database/migrations/007_create_features_and_billing.sql`
- Test: `tests/feature_billing_migration_test.php`

**Interfaces:**
- Produces: Tables `features`, `tenant_features`, `payment_methods`, and `invoices`. Columns in `tenants`: `message_limit`, `device_limit`, `subscription_ends_at`, `role`.

- [ ] **Step 1: Write SQL Migration File**
Create `007_create_features_and_billing.sql` with seed features corresponding to screenshot (Pesan AI, Jadwalkan Pesan, Pesan Massal, Balasan Otomatis, Kirim Pesan, Kirim Media, Kirim Produk, Kirim Teks ke Saluran, Kirim Daftar, Kirim Tombol, Kirim Lokasi, Kirim Polling, Kirim Stiker, Kirim VCard, Webhook, API) and default payment methods (Transfer Bank BCA, QRIS Instant).

- [ ] **Step 2: Run migration and verify tables**
Execute `php database/migrate.php` and verify table existence.

- [ ] **Step 3: Write migration test**
Ensure all tables and default seeded features can be queried.

---

### Task 2: FeatureService & FeatureController for Dynamic Feature Catalog

**Files:**
- Create: `app/Services/FeatureService.php`
- Create: `app/Controllers/FeatureController.php`
- Modify: `routes/web.php`
- Test: `tests/feature_service_test.php`

**Interfaces:**
- `FeatureService::getAll(): array`
- `FeatureService::create(string $name, ?string $code = null, ?string $description = null): string`
- `FeatureService::syncTenantFeatures(string $tenantId, array $featureCodes): void`
- `FeatureService::getTenantFeatures(string $tenantId): array`

- [ ] **Step 1: Write test for FeatureService**
- [ ] **Step 2: Implement FeatureService** (<= 100 lines)
- [ ] **Step 3: Implement FeatureController** (<= 100 lines)
- [ ] **Step 4: Register route in routes/web.php**

---

### Task 3: BillingService & InvoiceController for Payment Methods and Automated Invoices

**Files:**
- Create: `app/Services/BillingService.php`
- Create: `app/Controllers/InvoiceController.php`
- Create: `app/Views/invoices/show.php` (Nota Pembayaran view)
- Create: `app/Views/invoices/partials/receipt_card.php`
- Modify: `routes/web.php`
- Test: `tests/billing_service_test.php`

**Interfaces:**
- `BillingService::getPaymentMethods(): array`
- `BillingService::createInvoice(string $tenantId, int $amount, string $planId, string $methodId, string $status = 'paid'): array`
- `BillingService::getInvoice(string $id): ?array`

- [ ] **Step 1: Write test for BillingService**
- [ ] **Step 2: Implement BillingService** (<= 100 lines)
- [ ] **Step 3: Implement InvoiceController** (<= 100 lines)
- [ ] **Step 4: Implement Invoice / Nota View & Partial** (each <= 100 lines)

---

### Task 4: ClientService & ClientController Updates (Delete, Detailed Create, Auto Invoice)

**Files:**
- Modify: `app/Services/ClientService.php`
- Modify: `app/Controllers/ClientController.php`
- Modify: `routes/web.php`
- Test: `tests/client_management_test.php`

**Interfaces:**
- `ClientService::delete(string $id): bool`
- `ClientService::create(array $data): string` (supports message_limit, device_limit, subscription_ends_at, role, features array, auto invoice)

- [ ] **Step 1: Write test for delete client & extended create client**
- [ ] **Step 2: Update ClientService** (keep <= 100 lines)
- [ ] **Step 3: Update ClientController** (add delete action & pass features/payment methods to index, keep <= 100 lines)

---

### Task 5: UI Components: Modal "Tambahkan Pengguna" (Sesuai Gambar), Modal Hapus Klien, & Modal Tambah Fitur

**Files:**
- Modify: `app/Views/clients/partials/modal_create.php` (replicate exact UI of the user's uploaded image with 3-column features grid, <= 100 lines)
- Create: `app/Views/clients/partials/modal_create_features.php` (features checkboxes grid partial, <= 100 lines)
- Create: `app/Views/clients/partials/modal_delete.php` (delete confirmation modal, <= 100 lines)
- Create: `app/Views/clients/partials/modal_new_feature.php` (admin modal to add new feature, <= 100 lines)
- Modify: `app/Views/clients/partials/header.php` (add "Kelola Fitur" button, <= 100 lines)
- Modify: `app/Views/clients/partials/table.php` (add delete button and invoice button, <= 100 lines)
- Modify: `app/Views/clients/index.php` (include new partials, <= 100 lines)

- [ ] **Step 1: Build modal_create & modal_create_features**
- [ ] **Step 2: Build modal_delete & modal_new_feature**
- [ ] **Step 3: Update table.php & header.php with action triggers**

---

### Task 6: End-to-End Verification & Line Count Checks

**Files:**
- Run: `tests/auth_security_test.php`
- Run: `tests/feature_billing_migration_test.php`
- Run: `tests/billing_service_test.php`
- Run: `tests/client_management_test.php`
- Run: `tests/check_line_counts.php`

- [ ] **Step 1: Execute all unit and integration test suites**
- [ ] **Step 2: Verify all files are <= 100 lines**
- [ ] **Step 3: Confirm full functionality**
