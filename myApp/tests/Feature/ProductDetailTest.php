<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::factory()->create([
            'nama'     => 'Admin Test',
            'username' => 'admin_test',
            'password' => 'password',
            'role'     => 'admin_kasir',
        ]);
    }

    private function makeProduct(array $attributes = [], int $stock = 10, string $satuan = 'pcs', ?string $keterangan = 'Stok segar'): Product
    {
        $product = Product::create(array_merge([
            'nama_produk' => 'Roti Manis Cokelat',
            'harga'       => 12500,
            'kategori'    => 'Roti Manis',
            'deskripsi'   => 'Roti lembut dengan isian cokelat lumer.',
        ], $attributes));

        Stock::create([
            'product_id' => $product->id,
            'jumlah'     => $stock,
            'satuan'     => $satuan,
            'keterangan' => $keterangan,
        ]);

        return $product;
    }

    /** 1. Halaman detail produk mengembalikan status HTTP 200 untuk admin */
    public function test_admin_can_access_product_detail_page(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct();

        $res = $this->actingAs($admin)->get(route('admin.products.show', $product));

        $res->assertOk();
    }

    /** 2. Halaman menampilkan data produk lengkap (nama, harga terformat, kategori, deskripsi) */
    public function test_product_detail_displays_product_information(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct([
            'nama_produk' => 'Bolu Gulung Pandan',
            'harga'       => 35000,
            'kategori'    => 'Kue Basah',
            'deskripsi'   => 'Bolu gulung aroma pandan dengan krim keju.',
        ]);

        $res = $this->actingAs($admin)->get(route('admin.products.show', $product));

        $res->assertOk();
        $res->assertSee('Bolu Gulung Pandan');
        $res->assertSee('Rp35.000');
        $res->assertSee('Kue Basah');
        $res->assertSee('Bolu gulung aroma pandan dengan krim keju.');
    }

    /** 3. Halaman menampilkan informasi stok (jumlah dan satuan) */
    public function test_product_detail_displays_stock_data(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct([], 24, 'box', 'Diproduksi pagi ini');

        $res = $this->actingAs($admin)->get(route('admin.products.show', $product));

        $res->assertOk();
        $res->assertSee('24');
        $res->assertSee('box');
        $res->assertSee('Diproduksi pagi ini');
        $res->assertSee('Tersedia'); // stok > 5
    }

    /** 4. Status stok "Stok Menipis" jika stok <= 5 */
    public function test_product_detail_displays_low_stock_status(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct([], 3, 'pcs');

        $res = $this->actingAs($admin)->get(route('admin.products.show', $product));

        $res->assertOk();
        $res->assertSee('Stok Menipis');
    }

    /** 5. Status stok "Habis" jika stok = 0 */
    public function test_product_detail_displays_empty_stock_status(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct([], 0, 'pcs');

        $res = $this->actingAs($admin)->get(route('admin.products.show', $product));

        $res->assertOk();
        $res->assertSee('Habis');
    }

    /** 6. Halaman menampilkan placeholder jika produk belum memiliki foto */
    public function test_product_detail_shows_placeholder_when_no_photo(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct(['foto_produk' => null]);

        $res = $this->actingAs($admin)->get(route('admin.products.show', $product));

        $res->assertOk();
        $res->assertSee('Belum ada foto produk');
    }

    /** 7. Halaman menampilkan gambar foto jika produk memiliki foto */
    public function test_product_detail_shows_image_tag_when_photo_exists(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct(['foto_produk' => 'products/sample.jpg']);

        $res = $this->actingAs($admin)->get(route('admin.products.show', $product));

        $res->assertOk();
        $res->assertSee('storage/products/sample.jpg');
    }

    /** 8. Tombol hapus produk muncul jika belum pernah digunakan dalam transaksi */
    public function test_delete_button_present_when_product_has_no_sales(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct();

        $res = $this->actingAs($admin)->get(route('admin.products.show', $product));

        $res->assertOk();
        $res->assertSee('Hapus Produk');
    }

    /** 9. Tombol hapus produk tidak muncul jika sudah pernah ada transaksi */
    public function test_delete_button_hidden_when_product_used_in_sales(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct();

        $sale = Sale::create([
            'user_id'      => $admin->id,
            'tanggal'      => now(),
            'total'        => 12500,
            'metode_bayar' => 'Cash',
            'status'       => 'Selesai',
        ]);

        SaleDetail::create([
            'sale_id'    => $sale->id,
            'product_id' => $product->id,
            'jumlah'     => 1,
            'harga'      => 12500,
            'subtotal'   => 12500,
        ]);

        $res = $this->actingAs($admin)->get(route('admin.products.show', $product));

        $res->assertOk();
        $res->assertDontSee('Hapus Produk');
    }

    /** 10. Navigasi link kembali dan tombol edit tersedia */
    public function test_product_detail_contains_navigation_links(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct();

        $res = $this->actingAs($admin)->get(route('admin.products.show', $product));

        $res->assertOk();
        $res->assertSee(route('admin.products.index'));
        $res->assertSee(route('admin.products.edit', $product));
    }

    /** 11. Halaman daftar produk (index) memuat tombol 'Detail' yang mengarah ke show */
    public function test_product_index_has_link_to_product_detail(): void
    {
        $admin = $this->makeAdmin();
        $product = $this->makeProduct();

        $res = $this->actingAs($admin)->get(route('admin.products.index'));

        $res->assertOk();
        $res->assertSee('Detail');
        $res->assertSee(route('admin.products.show', $product));
    }

    /** 12. Mengembalikan 404 jika ID produk tidak ada */
    public function test_product_detail_returns_404_for_nonexistent_product(): void
    {
        $admin = $this->makeAdmin();

        $res = $this->actingAs($admin)->get('/admin/produk/99999');

        $res->assertNotFound();
    }

    /** 13. Guest diarahkan ke halaman login */
    public function test_guest_is_redirected_to_login(): void
    {
        $product = $this->makeProduct();

        $res = $this->get(route('admin.products.show', $product));

        $res->assertRedirect(route('login'));
    }

    /** 14. Role Owner dilarang akses (403 Forbidden) */
    public function test_owner_is_forbidden_from_admin_product_detail(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $product = $this->makeProduct();

        $res = $this->actingAs($owner)->get(route('admin.products.show', $product));

        $res->assertForbidden();
    }
}
