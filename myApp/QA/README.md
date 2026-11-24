# QA — Modern Bakery (Penjualan Toko Roti)

Folder ini berisi seluruh output pengujian QA berbasis skill `website-qa-automation-architect`.

## Struktur Folder

```
QA/
├── results/
│   ├── test-results.json        — Ringkasan hasil eksekusi test
│   └── bug-report.json          — Laporan bug yang ditemukan
├── reports/
│   └── QA_Report.md             — Laporan QA lengkap (Markdown)
├── screenshots/                 — Folder untuk screenshot (browser test)
├── logs/                        — Log eksekusi
└── README.md                    — File ini
```

## Informasi Pengujian

| Item | Detail |
|---|---|
| Aplikasi | Modern Bakery — Penjualan Toko Roti |
| Framework | Laravel 13.31.0 |
| PHP | 8.3.16 |
| Test Runner | PHPUnit 12.5.35 |
| Database Test | SQLite in-memory |
| Tanggal Eksekusi | 2026-11-24 |
| Skill QA | website-qa-automation-architect |

## Ringkasan Hasil

| Metrik | Nilai |
|---|---|
| Total Test Case | 82 |
| PASS | 81 |
| FAIL | 1 |
| Pass Rate | **98.78%** |
| Modul Diuji | 9 Modul |
| Bug Ditemukan | 1 (BUG-001, Severity: Medium) |

## File Utama

- [QA Report](reports/QA_Report.md)
- [Laporan Verifikasi Detail Produk](reports/Product_Detail_Verification_Report.md)
- [Test Results](results/test-results.json)
- [Bug Report](results/bug-report.json)
- [Test Source](../tests/Feature/QA_ComprehensiveTest.php)
- [Dedicated Detail Product Test Source](../tests/Feature/ProductDetailTest.php)
