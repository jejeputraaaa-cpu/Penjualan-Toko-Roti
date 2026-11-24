<?php

/**
 * ============================================================
 * QA COMPREHENSIVE TEST — Modern Bakery (Penjualan Toko Roti)
 * ============================================================
 * Skill: website-qa-automation-architect
 * Dibuat: 2026-11-24
 * Lingkup: Functional Testing berbasis source code analysis
 *          + Laravel HTTP test (tanpa browser)
 * ============================================================
 */

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\StoreProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QA_ComprehensiveTest extends TestCase
{
    use RefreshDatabase;

    // ─── Helper ──────────────────────────────────────────────────────────────

    private function makeOwner(): User
    {
        return User::factory()->create([
            'nama'     => 'Owner Test',
            'username' => 'owner_test',
            'password' => 'password',
            'role'     => 'owner',
        ]);
    }

    private function makeAdmin(): User
    {
        return User::factory()->create([
            'nama'     => 'Admin Test',
            'username' => 'admin_test',
            'password' => 'password',
            'role'     => 'admin_kasir',
        ]);
    }

    private function makeProductWithStock(int $stok = 50): Product
    {
        $product = Product::create([
            'nama_produk' => 'Roti Tawar',
            'harga'       => 15000,
            'kategori'    => 'Roti',
            'deskripsi'   => 'Roti tawar lembut',
        ]);
        Stock::create([
            'product_id' => $product->id,
            'jumlah'     => $stok,
            'satuan'     => 'pcs',
        ]);
        return $product;
    }

    // =========================================================================
    // MODULE: AUTHENTICATION (TC001–TC010)
    // =========================================================================

    /** TC001 — Halaman landing dapat diakses publik */
    public function test_TC001_landing_page_accessible_by_guest(): void
    {
        $res = $this->get(route('home'));
        $res->assertStatus(200);
    }

    /** TC002 — Halaman login dapat diakses guest */
    public function test_TC002_login_page_accessible_by_guest(): void
    {
        $res = $this->get(route('login'));
        $res->assertStatus(200);
        $res->assertSee('username', false);
        $res->assertSee('password', false);
    }

    /** TC003 — Owner berhasil login dan diarahkan ke owner dashboard */
    public function test_TC003_owner_login_redirects_to_owner_dashboard(): void
    {
        $owner = $this->makeOwner();
        $res = $this->post(route('login.process'), [
            'username' => 'owner_test',
            'password' => 'password',
        ]);
        $res->assertRedirect(route('owner.dashboard'));
        $this->assertAuthenticatedAs($owner);
    }

    /** TC004 — Admin/kasir berhasil login dan diarahkan ke admin dashboard */
    public function test_TC004_admin_login_redirects_to_admin_dashboard(): void
    {
        $admin = $this->makeAdmin();
        $res = $this->post(route('login.process'), [
            'username' => 'admin_test',
            'password' => 'password',
        ]);
        $res->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    /** TC005 — Login dengan password salah ditolak */
    public function test_TC005_login_with_wrong_password_is_rejected(): void
    {
        $this->makeOwner();
        $res = $this->post(route('login.process'), [
            'username' => 'owner_test',
            'password' => 'salah_password',
        ]);
        $res->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    /** TC006 — Login dengan username tidak ada ditolak */
    public function test_TC006_login_with_nonexistent_username_rejected(): void
    {
        $res = $this->post(route('login.process'), [
            'username' => 'userTidakAda',
            'password' => 'password',
        ]);
        $res->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    /** TC007 — Logout berhasil membersihkan sesi */
    public function test_TC007_logout_clears_session(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->post(route('logout'))
            ->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /** TC008 — Guest diarahkan login saat akses admin dashboard */
    public function test_TC008_guest_redirected_to_login_from_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    /** TC009 — Guest diarahkan login saat akses owner dashboard */
    public function test_TC009_guest_redirected_to_login_from_owner_dashboard(): void
    {
        $this->get(route('owner.dashboard'))->assertRedirect(route('login'));
    }

    /** TC010 — Field username dan password wajib diisi */
    public function test_TC010_login_requires_username_and_password(): void
    {
        $res = $this->post(route('login.process'), []);
        $res->assertSessionHasErrors(['username', 'password']);
    }

    // =========================================================================
    // MODULE: ROLE-BASED ACCESS CONTROL (TC011–TC020)
    // =========================================================================

    /** TC011 — Admin tidak bisa akses owner dashboard */
    public function test_TC011_admin_cannot_access_owner_dashboard(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get(route('owner.dashboard'))->assertForbidden();
    }

    /** TC012 — Owner tidak bisa akses admin dashboard */
    public function test_TC012_owner_cannot_access_admin_dashboard(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->get(route('admin.dashboard'))->assertForbidden();
    }

    /** TC013 — Admin tidak bisa akses manajemen pengguna (owner only) */
    public function test_TC013_admin_cannot_access_user_management(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get(route('owner.users'))->assertForbidden();
    }

    /** TC014 — Owner tidak bisa akses fitur kasir */
    public function test_TC014_owner_cannot_access_cashier_feature(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->get(route('admin.sales.create'))->assertForbidden();
    }

    /** TC015 — Admin dengan role admin bisa akses admin dashboard */
    public function test_TC015_admin_role_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    }

    /** TC016 — Kasir bisa akses admin dashboard */
    public function test_TC016_kasir_role_can_access_admin_dashboard(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);
        $this->actingAs($kasir)->get(route('admin.dashboard'))->assertOk();
    }

    /** TC017 — Owner bisa akses laporan penjualan (owner route) */
    public function test_TC017_owner_can_access_sales_report(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->get(route('owner.reports'))->assertOk();
    }

    /** TC018 — Admin bisa akses laporan penjualan (admin route) */
    public function test_TC018_admin_can_access_sales_report(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get(route('admin.reports'))->assertOk();
    }

    /** TC019 — Owner bisa akses profil toko */
    public function test_TC019_owner_can_access_store_profile(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->get(route('owner.profile'))->assertOk();
    }

    /** TC020 — Admin tidak bisa akses profil toko */
    public function test_TC020_admin_cannot_access_store_profile(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get(route('owner.profile'))->assertForbidden();
    }

    // =========================================================================
    // MODULE: MANAJEMEN PRODUK (TC021–TC035)
    // =========================================================================

    /** TC021 — Admin bisa melihat daftar produk */
    public function test_TC021_admin_can_view_product_list(): void
    {
        $admin = $this->makeAdmin();
        $this->makeProductWithStock();
        $this->actingAs($admin)->get(route('admin.products.index'))->assertOk();
    }

    /** TC022 — Admin bisa akses form tambah produk */
    public function test_TC022_admin_can_access_product_create_form(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get(route('admin.products.create'))->assertOk();
    }

    /** TC023 — Admin berhasil menambah produk baru dengan data valid */
    public function test_TC023_admin_can_create_product_with_valid_data(): void
    {
        Storage::fake('public');
        $admin = $this->makeAdmin();

        $res = $this->actingAs($admin)->post(route('admin.products.store'), [
            'nama_produk'    => 'Croissant',
            'harga'          => 12000,
            'kategori'       => 'Pastry',
            'deskripsi'      => 'Croissant mentega',
            'jumlah_stok'    => 30,
            'satuan'         => 'pcs',
            'keterangan_stok' => 'Stok awal',
        ]);

        $res->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'nama_produk' => 'Croissant',
            'harga'       => 12000,
            'kategori'    => 'Pastry',
        ]);
        $this->assertDatabaseHas('stocks', [
            'jumlah' => 30,
            'satuan' => 'pcs',
        ]);
    }

    /** TC024 — Tambah produk gagal jika nama kosong */
    public function test_TC024_product_creation_fails_without_name(): void
    {
        $admin = $this->makeAdmin();
        $res = $this->actingAs($admin)->post(route('admin.products.store'), [
            'harga'       => 10000,
            'kategori'    => 'Roti',
            'jumlah_stok' => 10,
            'satuan'      => 'pcs',
        ]);
        $res->assertSessionHasErrors('nama_produk');
    }

    /** TC025 — Tambah produk gagal jika harga negatif */
    public function test_TC025_product_creation_fails_with_negative_price(): void
    {
        $admin = $this->makeAdmin();
        $res = $this->actingAs($admin)->post(route('admin.products.store'), [
            'nama_produk' => 'Roti Bakar',
            'harga'       => -5000,
            'kategori'    => 'Roti',
            'jumlah_stok' => 10,
            'satuan'      => 'pcs',
        ]);
        $res->assertSessionHasErrors('harga');
    }

    /** TC026 — Tambah produk gagal jika stok negatif */
    public function test_TC026_product_creation_fails_with_negative_stock(): void
    {
        $admin = $this->makeAdmin();
        $res = $this->actingAs($admin)->post(route('admin.products.store'), [
            'nama_produk' => 'Roti Bakar',
            'harga'       => 5000,
            'kategori'    => 'Roti',
            'jumlah_stok' => -1,
            'satuan'      => 'pcs',
        ]);
        $res->assertSessionHasErrors('jumlah_stok');
    }

    /** TC027 — Admin bisa melihat detail produk */
    public function test_TC027_admin_can_view_product_detail(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock();
        $this->actingAs($admin)
            ->get(route('admin.products.show', $product))
            ->assertOk();
    }

    /** TC028 — Admin bisa mengakses form edit produk */
    public function test_TC028_admin_can_access_product_edit_form(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock();
        $this->actingAs($admin)
            ->get(route('admin.products.edit', $product))
            ->assertOk();
    }

    /** TC029 — Admin berhasil update produk */
    public function test_TC029_admin_can_update_product(): void
    {
        Storage::fake('public');
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(10);

        $res = $this->actingAs($admin)->put(route('admin.products.update', $product), [
            'nama_produk' => 'Roti Tawar Gandum',
            'harga'       => 18000,
            'kategori'    => 'Roti Sehat',
            'jumlah_stok' => 25,
            'satuan'      => 'pcs',
        ]);

        $res->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'id'          => $product->id,
            'nama_produk' => 'Roti Tawar Gandum',
            'harga'       => 18000,
        ]);
        $this->assertDatabaseHas('stocks', [
            'product_id' => $product->id,
            'jumlah'     => 25,
        ]);
    }

    /** TC030 — Update produk gagal jika nama kosong */
    public function test_TC030_product_update_fails_without_name(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock();
        $res = $this->actingAs($admin)->put(route('admin.products.update', $product), [
            'harga'       => 15000,
            'kategori'    => 'Roti',
            'jumlah_stok' => 10,
            'satuan'      => 'pcs',
        ]);
        $res->assertSessionHasErrors('nama_produk');
    }

    /** TC031 — Admin berhasil menghapus produk yang belum pernah digunakan */
    public function test_TC031_admin_can_delete_unused_product(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock();

        $res = $this->actingAs($admin)->delete(route('admin.products.destroy', $product));
        $res->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** TC032 — Produk tidak bisa dihapus jika sudah ada di transaksi */
    public function test_TC032_product_cannot_be_deleted_if_used_in_sale(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock();

        // Buat transaksi yang mereferensikan produk
        $sale = Sale::create([
            'user_id'      => $admin->id,
            'tanggal'      => now(),
            'total'        => 15000,
            'metode_bayar' => 'Cash',
            'status'       => 'Selesai',
        ]);
        SaleDetail::create([
            'sale_id'    => $sale->id,
            'product_id' => $product->id,
            'jumlah'     => 1,
            'harga'      => 15000,
            'subtotal'   => 15000,
        ]);

        $res = $this->actingAs($admin)->delete(route('admin.products.destroy', $product));
        $res->assertRedirect(route('admin.products.index'));
        $res->assertSessionHas('error');
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    /** TC033 — Upload foto produk dengan format tidak valid ditolak */
    public function test_TC033_product_photo_upload_rejects_invalid_format(): void
    {
        Storage::fake('public');
        $admin = $this->makeAdmin();
        $fakeFile = UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf');

        $res = $this->actingAs($admin)->post(route('admin.products.store'), [
            'nama_produk' => 'Roti Test',
            'harga'       => 10000,
            'kategori'    => 'Roti',
            'jumlah_stok' => 5,
            'satuan'      => 'pcs',
            'foto_produk' => $fakeFile,
        ]);
        $res->assertSessionHasErrors('foto_produk');
    }

    /** TC034 — Upload foto produk valid berhasil tersimpan */
    public function test_TC034_product_photo_upload_accepts_valid_image(): void
    {
        Storage::fake('public');
        $admin    = $this->makeAdmin();
        $fakeImg  = UploadedFile::fake()->image('roti.jpg', 300, 200);

        $res = $this->actingAs($admin)->post(route('admin.products.store'), [
            'nama_produk' => 'Roti Foto',
            'harga'       => 10000,
            'kategori'    => 'Roti',
            'jumlah_stok' => 5,
            'satuan'      => 'pcs',
            'foto_produk' => $fakeImg,
        ]);
        $res->assertRedirect(route('admin.products.index'));
        $product = Product::where('nama_produk', 'Roti Foto')->first();
        $this->assertNotNull($product->foto_produk);
    }

    /** TC035 — Kategori produk wajib diisi */
    public function test_TC035_product_creation_fails_without_category(): void
    {
        $admin = $this->makeAdmin();
        $res = $this->actingAs($admin)->post(route('admin.products.store'), [
            'nama_produk' => 'Roti Kategori',
            'harga'       => 10000,
            'jumlah_stok' => 5,
            'satuan'      => 'pcs',
        ]);
        $res->assertSessionHasErrors('kategori');
    }

    // =========================================================================
    // MODULE: KASIR / PENJUALAN (TC036–TC050)
    // =========================================================================

    /** TC036 — Admin bisa akses halaman kasir */
    public function test_TC036_admin_can_access_cashier_page(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get(route('admin.sales.create'))->assertOk();
    }

    /** TC037 — Transaksi berhasil disimpan dengan data valid (Cash) */
    public function test_TC037_transaction_stored_successfully_with_cash(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(20);

        $res = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'    => [$product->id],
            'jumlah'        => [3],
            'metode_bayar'  => 'Cash',
            'jumlah_bayar'  => 50000,
        ]);

        $res->assertRedirect();
        $res->assertSessionHasNoErrors();

        $sale = Sale::first();
        $this->assertNotNull($sale);
        $this->assertEquals(45000, $sale->total); // 3 × 15000
        $this->assertEquals('Selesai', $sale->status);
    }

    /** TC038 — Stok berkurang otomatis setelah transaksi */
    public function test_TC038_stock_decremented_after_sale(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(20);

        $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'   => [$product->id],
            'jumlah'       => [5],
            'metode_bayar' => 'Cash',
            'jumlah_bayar' => 100000,
        ]);

        $this->assertDatabaseHas('stocks', [
            'product_id' => $product->id,
            'jumlah'     => 15, // 20 - 5
        ]);
    }

    /** TC039 — Transaksi gagal jika stok tidak cukup */
    public function test_TC039_transaction_fails_if_stock_insufficient(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(2);

        $res = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'   => [$product->id],
            'jumlah'       => [10],
            'metode_bayar' => 'Cash',
            'jumlah_bayar' => 200000,
        ]);
        $res->assertSessionHasErrors('transaksi');
    }

    /** TC040 — Transaksi gagal jika uang bayar kurang (metode Cash) */
    public function test_TC040_transaction_fails_if_cash_payment_insufficient(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(10);

        $res = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'   => [$product->id],
            'jumlah'       => [5],
            'metode_bayar' => 'Cash',
            'jumlah_bayar' => 10000, // total 75000, bayar hanya 10000
        ]);
        $res->assertSessionHasErrors('transaksi');
    }

    /** TC041 — Transaksi berhasil dengan metode QRIS */
    public function test_TC041_transaction_success_with_qris(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(10);

        $res = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'   => [$product->id],
            'jumlah'       => [2],
            'metode_bayar' => 'QRIS',
            'jumlah_bayar' => 0,
        ]);
        $res->assertSessionHasNoErrors();
        $this->assertDatabaseHas('sales', ['metode_bayar' => 'QRIS']);
    }

    /** TC042 — Transaksi berhasil dengan metode Transfer */
    public function test_TC042_transaction_success_with_transfer(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(10);

        $res = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'   => [$product->id],
            'jumlah'       => [1],
            'metode_bayar' => 'Transfer',
            'jumlah_bayar' => 0,
        ]);
        $res->assertSessionHasNoErrors();
        $this->assertDatabaseHas('sales', ['metode_bayar' => 'Transfer']);
    }

    /** TC043 — Transaksi gagal jika metode pembayaran tidak valid */
    public function test_TC043_transaction_fails_with_invalid_payment_method(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(10);

        $res = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'   => [$product->id],
            'jumlah'       => [1],
            'metode_bayar' => 'BitCoin',
            'jumlah_bayar' => 20000,
        ]);
        $res->assertSessionHasErrors('metode_bayar');
    }

    /** TC044 — Transaksi gagal jika tidak ada produk dipilih */
    public function test_TC044_transaction_fails_without_product(): void
    {
        $admin = $this->makeAdmin();
        $res   = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'   => [],
            'jumlah'       => [],
            'metode_bayar' => 'Cash',
            'jumlah_bayar' => 10000,
        ]);
        $res->assertSessionHasErrors('product_id');
    }

    /** TC045 — Jumlah beli 0 diabaikan (tidak masuk transaksi) */
    public function test_TC045_zero_quantity_items_are_skipped(): void
    {
        $admin    = $this->makeAdmin();
        $product1 = $this->makeProductWithStock(10);
        $product2 = Product::create([
            'nama_produk' => 'Donat',
            'harga'       => 8000,
            'kategori'    => 'Pastry',
        ]);
        Stock::create(['product_id' => $product2->id, 'jumlah' => 10, 'satuan' => 'pcs']);

        $res = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'   => [$product1->id, $product2->id],
            'jumlah'       => [2, 0], // product2 jumlah 0, diabaikan
            'metode_bayar' => 'Cash',
            'jumlah_bayar' => 50000,
        ]);
        $res->assertSessionHasNoErrors();
        // Total hanya dari product1: 2 × 15000 = 30000
        $this->assertDatabaseHas('sales', ['total' => 30000]);
    }

    /** TC046 — Admin bisa melihat riwayat penjualan */
    public function test_TC046_admin_can_view_sales_history(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get(route('admin.sales.history'))->assertOk();
    }

    /** TC047 — Admin bisa melihat detail transaksi */
    public function test_TC047_admin_can_view_sale_detail(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(10);
        $sale    = Sale::create([
            'user_id'      => $admin->id,
            'tanggal'      => now(),
            'total'        => 15000,
            'metode_bayar' => 'Cash',
            'status'       => 'Selesai',
        ]);
        SaleDetail::create([
            'sale_id'    => $sale->id,
            'product_id' => $product->id,
            'jumlah'     => 1,
            'harga'      => 15000,
            'subtotal'   => 15000,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.sales.show', $sale))
            ->assertOk();
    }

    /** TC048 — Admin bisa melihat struk transaksi */
    public function test_TC048_admin_can_view_receipt(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(10);
        $sale    = Sale::create([
            'user_id'      => $admin->id,
            'tanggal'      => now(),
            'total'        => 15000,
            'metode_bayar' => 'Cash',
            'status'       => 'Selesai',
        ]);
        SaleDetail::create([
            'sale_id'    => $sale->id,
            'product_id' => $product->id,
            'jumlah'     => 1,
            'harga'      => 15000,
            'subtotal'   => 15000,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.sales.receipt', $sale))
            ->assertOk();
    }

    /** TC049 — Transaksi gagal jika product_id tidak ada di database */
    public function test_TC049_transaction_fails_with_nonexistent_product(): void
    {
        $admin = $this->makeAdmin();
        $res   = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'   => [99999],
            'jumlah'       => [1],
            'metode_bayar' => 'Cash',
            'jumlah_bayar' => 20000,
        ]);
        $res->assertSessionHasErrors('product_id.0');
    }

    /** TC050 — Jumlah bayar wajib diisi */
    public function test_TC050_transaction_fails_without_payment_amount(): void
    {
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(10);
        $res     = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'product_id'  => [$product->id],
            'jumlah'      => [1],
            'metode_bayar' => 'Cash',
        ]);
        $res->assertSessionHasErrors('jumlah_bayar');
    }

    // =========================================================================
    // MODULE: LAPORAN PENJUALAN (TC051–TC058)
    // =========================================================================

    /** TC051 — Owner melihat laporan tanpa filter */
    public function test_TC051_owner_can_view_sales_report_without_filter(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->get(route('owner.reports'))->assertOk();
    }

    /** TC052 — Owner melihat laporan dengan filter tanggal valid */
    public function test_TC052_owner_can_filter_sales_report_by_date(): void
    {
        $owner = $this->makeOwner();
        $res   = $this->actingAs($owner)->get(route('owner.reports', [
            'tanggal_mulai' => '2026-01-01',
            'tanggal_akhir' => '2026-12-31',
        ]));
        $res->assertOk();
    }

    /** TC053 — Filter tanggal ditolak jika akhir sebelum mulai */
    public function test_TC053_sales_report_filter_rejects_invalid_date_range(): void
    {
        $owner = $this->makeOwner();
        $res   = $this->actingAs($owner)->get(route('owner.reports', [
            'tanggal_mulai' => '2026-12-31',
            'tanggal_akhir' => '2026-01-01',
        ]));
        $res->assertSessionHasErrors('tanggal_akhir');
    }

    /** TC054 — Admin bisa akses laporan penjualan (admin route) */
    public function test_TC054_admin_can_access_sales_report(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get(route('admin.reports'))->assertOk();
    }

    /** TC055 — Laporan menampilkan total omzet yang benar */
    public function test_TC055_sales_report_shows_correct_total(): void
    {
        $owner   = $this->makeOwner();
        $admin   = $this->makeAdmin();
        $product = $this->makeProductWithStock(50);

        // Buat 2 penjualan
        $sale1 = Sale::create([
            'user_id' => $admin->id, 'tanggal' => now(),
            'total' => 30000, 'metode_bayar' => 'Cash', 'status' => 'Selesai',
        ]);
        $sale2 = Sale::create([
            'user_id' => $admin->id, 'tanggal' => now(),
            'total' => 45000, 'metode_bayar' => 'QRIS', 'status' => 'Selesai',
        ]);

        $res = $this->actingAs($owner)->get(route('owner.reports'));
        $res->assertOk();
        $res->assertSeeText('75.000'); // total omzet 75000 diformat
    }

    /** TC056 — Admin laporan filter tanggal valid */
    public function test_TC056_admin_can_filter_sales_report_by_date(): void
    {
        $admin = $this->makeAdmin();
        $res   = $this->actingAs($admin)->get(route('admin.reports', [
            'tanggal_mulai' => '2026-01-01',
            'tanggal_akhir' => '2026-11-30',
        ]));
        $res->assertOk();
    }

    /** TC057 — Filter tanggal tidak valid (bukan tanggal) ditolak */
    public function test_TC057_sales_report_rejects_invalid_date_format(): void
    {
        $owner = $this->makeOwner();
        $res   = $this->actingAs($owner)->get(route('owner.reports', [
            'tanggal_mulai' => 'bukan-tanggal',
        ]));
        $res->assertSessionHasErrors('tanggal_mulai');
    }

    /** TC058 — Laporan menampilkan jumlah transaksi yang benar */
    public function test_TC058_sales_report_shows_correct_transaction_count(): void
    {
        $owner = $this->makeOwner();
        $admin = $this->makeAdmin();

        for ($i = 0; $i < 3; $i++) {
            Sale::create([
                'user_id' => $admin->id, 'tanggal' => now(),
                'total' => 10000, 'metode_bayar' => 'Cash', 'status' => 'Selesai',
            ]);
        }

        $res = $this->actingAs($owner)->get(route('owner.reports'));
        $res->assertOk();
        $res->assertSeeText('3');
    }

    // =========================================================================
    // MODULE: MANAJEMEN PENGGUNA — OWNER (TC059–TC070)
    // =========================================================================

    /** TC059 — Owner bisa melihat daftar pengguna */
    public function test_TC059_owner_can_view_user_list(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->get(route('owner.users'))->assertOk();
    }

    /** TC060 — Owner bisa akses form tambah pengguna */
    public function test_TC060_owner_can_access_user_create_form(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->get(route('owner.users.create'))->assertOk();
    }

    /** TC061 — Owner berhasil tambah akun kasir */
    public function test_TC061_owner_can_create_kasir_account(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->post(route('owner.users.store'), [
            'nama'                  => 'Kasir Baru',
            'username'              => 'kasir_baru',
            'role'                  => 'kasir',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('owner.users'));

        $this->assertDatabaseHas('users', [
            'username' => 'kasir_baru',
            'role'     => 'kasir',
        ]);
    }

    /** TC062 — Owner berhasil tambah akun admin */
    public function test_TC062_owner_can_create_admin_account(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->post(route('owner.users.store'), [
            'nama'                  => 'Admin Baru',
            'username'              => 'admin_baru',
            'role'                  => 'admin',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('owner.users'));

        $this->assertDatabaseHas('users', ['username' => 'admin_baru', 'role' => 'admin']);
    }

    /** TC063 — Owner tidak bisa buat akun dengan role owner */
    public function test_TC063_owner_cannot_create_another_owner_account(): void
    {
        $owner = $this->makeOwner();
        $res   = $this->actingAs($owner)->post(route('owner.users.store'), [
            'nama'                  => 'Owner Baru',
            'username'              => 'owner_baru',
            'role'                  => 'owner',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $res->assertSessionHasErrors('role');
    }

    /** TC064 — Username harus unik */
    public function test_TC064_username_must_be_unique(): void
    {
        $owner = $this->makeOwner();
        User::factory()->create(['username' => 'kasir_duplikat', 'role' => 'kasir']);

        $res = $this->actingAs($owner)->post(route('owner.users.store'), [
            'nama'                  => 'Kasir Lain',
            'username'              => 'kasir_duplikat',
            'role'                  => 'kasir',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $res->assertSessionHasErrors('username');
    }

    /** TC065 — Password minimal 8 karakter */
    public function test_TC065_password_must_be_at_least_8_characters(): void
    {
        $owner = $this->makeOwner();
        $res   = $this->actingAs($owner)->post(route('owner.users.store'), [
            'nama'                  => 'Kasir',
            'username'              => 'kasir_pass',
            'role'                  => 'kasir',
            'password'              => '1234',
            'password_confirmation' => '1234',
        ]);
        $res->assertSessionHasErrors('password');
    }

    /** TC066 — Password konfirmasi harus cocok */
    public function test_TC066_password_confirmation_must_match(): void
    {
        $owner = $this->makeOwner();
        $res   = $this->actingAs($owner)->post(route('owner.users.store'), [
            'nama'                  => 'Kasir',
            'username'              => 'kasir_conf',
            'role'                  => 'kasir',
            'password'              => 'password123',
            'password_confirmation' => 'berbeda123',
        ]);
        $res->assertSessionHasErrors('password');
    }

    /** TC067 — Owner bisa edit akun kasir */
    public function test_TC067_owner_can_edit_kasir_account(): void
    {
        $owner = $this->makeOwner();
        $kasir = User::factory()->create(['role' => 'kasir']);

        $this->actingAs($owner)->get(route('owner.users.edit', $kasir))->assertOk();
    }

    /** TC068 — Owner berhasil update nama kasir */
    public function test_TC068_owner_can_update_kasir_name(): void
    {
        $owner = $this->makeOwner();
        $kasir = User::factory()->create(['role' => 'kasir', 'username' => 'kasir_update']);

        $this->actingAs($owner)->put(route('owner.users.update', $kasir), [
            'nama'     => 'Kasir Updated',
            'username' => 'kasir_update',
            'role'     => 'kasir',
        ])->assertRedirect(route('owner.users'));

        $this->assertDatabaseHas('users', ['id' => $kasir->id, 'nama' => 'Kasir Updated']);
    }

    /** TC069 — Owner berhasil hapus akun kasir */
    public function test_TC069_owner_can_delete_kasir_account(): void
    {
        $owner = $this->makeOwner();
        $kasir = User::factory()->create(['role' => 'kasir']);

        $this->actingAs($owner)->delete(route('owner.users.destroy', $kasir))
            ->assertRedirect(route('owner.users'));

        $this->assertDatabaseMissing('users', ['id' => $kasir->id]);
    }

    /** TC070 — Owner tidak bisa edit/hapus akun owner */
    public function test_TC070_owner_cannot_edit_another_owner_account(): void
    {
        $owner  = $this->makeOwner();
        $owner2 = User::factory()->create(['role' => 'owner']);

        $this->actingAs($owner)->get(route('owner.users.edit', $owner2))->assertNotFound();
    }

    // =========================================================================
    // MODULE: PROFIL TOKO — OWNER (TC071–TC076)
    // =========================================================================

    /** TC071 — Owner bisa akses halaman profil toko */
    public function test_TC071_owner_can_access_store_profile_page(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->get(route('owner.profile'))->assertOk();
    }

    /** TC072 — Owner berhasil update profil toko */
    public function test_TC072_owner_can_update_store_profile(): void
    {
        $owner = $this->makeOwner();
        $res   = $this->actingAs($owner)->put(route('owner.profile.update'), [
            'nama_toko'  => 'Modern Bakery Menganto',
            'alamat'     => 'Jl. Raya Menganto No. 1',
            'no_telepon' => '08123456789',
        ]);
        $res->assertRedirect(route('owner.profile'));
        $this->assertDatabaseHas('store_profiles', [
            'nama_toko'  => 'Modern Bakery Menganto',
            'no_telepon' => '08123456789',
        ]);
    }

    /** TC073 — Update profil gagal jika nama toko kosong */
    public function test_TC073_store_profile_update_fails_without_name(): void
    {
        $owner = $this->makeOwner();
        $res   = $this->actingAs($owner)->put(route('owner.profile.update'), [
            'alamat'     => 'Jl. Test',
            'no_telepon' => '08123456789',
        ]);
        $res->assertSessionHasErrors('nama_toko');
    }

    /** TC074 — Update profil gagal jika alamat kosong */
    public function test_TC074_store_profile_update_fails_without_address(): void
    {
        $owner = $this->makeOwner();
        $res   = $this->actingAs($owner)->put(route('owner.profile.update'), [
            'nama_toko'  => 'Toko Test',
            'no_telepon' => '08123456789',
        ]);
        $res->assertSessionHasErrors('alamat');
    }

    /** TC075 — Update profil gagal jika nomor telepon kosong */
    public function test_TC075_store_profile_update_fails_without_phone(): void
    {
        $owner = $this->makeOwner();
        $res   = $this->actingAs($owner)->put(route('owner.profile.update'), [
            'nama_toko' => 'Toko Test',
            'alamat'    => 'Jl. Test',
        ]);
        $res->assertSessionHasErrors('no_telepon');
    }

    /** TC076 — Update profil berhasil membuat record baru jika belum ada */
    public function test_TC076_store_profile_created_if_not_exists(): void
    {
        $owner = $this->makeOwner();
        $this->assertDatabaseCount('store_profiles', 0);

        $this->actingAs($owner)->put(route('owner.profile.update'), [
            'nama_toko'  => 'Bakery Baru',
            'alamat'     => 'Jl. Baru No. 99',
            'no_telepon' => '0812999',
        ]);

        $this->assertDatabaseCount('store_profiles', 1);
    }

    // =========================================================================
    // MODULE: PROFIL ADMIN (TC077–TC079)
    // =========================================================================

    /** TC077 — Admin bisa akses halaman profil sendiri */
    public function test_TC077_admin_can_view_own_profile(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get(route('admin.profile'))->assertOk();
    }

    /** TC078 — Owner tidak bisa akses profil admin */
    public function test_TC078_owner_cannot_access_admin_profile_route(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->get(route('admin.profile'))->assertForbidden();
    }

    /** TC079 — Guest tidak bisa akses halaman profil */
    public function test_TC079_guest_cannot_access_profile(): void
    {
        $this->get(route('admin.profile'))->assertRedirect(route('login'));
    }

    // =========================================================================
    // MODULE: HALAMAN PUBLIK (TC080–TC082)
    // =========================================================================

    /** TC080 — Halaman utama (/) accessible untuk publik */
    public function test_TC080_home_route_accessible_for_public(): void
    {
        $this->get(route('home'))->assertOk();
    }

    /** TC081 — Owner yang sudah login diarahkan ke owner dashboard dari root */
    public function test_TC081_logged_in_owner_redirected_from_home(): void
    {
        $owner = $this->makeOwner();
        $this->actingAs($owner)->get(route('home'))
            ->assertRedirect(route('owner.dashboard'));
    }

    /** TC082 — Admin yang sudah login diarahkan ke admin dashboard dari root */
    public function test_TC082_logged_in_admin_redirected_from_home(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get(route('home'))
            ->assertRedirect(route('admin.dashboard'));
    }
}
