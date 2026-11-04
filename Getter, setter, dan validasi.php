<?php
declare(strict_types=1);
header('Content-Type: text/plain; charset=utf-8');
 
class Buku {
    private string $kodeBuku; // hanya dapat dibaca
    private string $judul;
    private int $stok;
 
    public function __construct(string $kodeBuku, string $judul, int $stok) {
        $kodeBuku = trim($kodeBuku);
        if ($kodeBuku === '') throw new InvalidArgumentException('Kode buku wajib diisi');
        $this->kodeBuku = $kodeBuku;
        $this->setJudul($judul);
        if ($stok < 0) throw new InvalidArgumentException('Stok tidak boleh negatif');
        $this->stok = $stok;
    }
    public function getKodeBuku(): string { return $this->kodeBuku; }
    public function getJudul(): string { return $this->judul; }
    public function getStok(): int { return $this->stok; }
 
    public function setJudul(string $judul): void {
        $judul = trim($judul);
        if ($judul === '') throw new InvalidArgumentException('Judul wajib diisi');
        $this->judul = $judul;
    }
    public function tambahStok(int $jumlah): void {
        if ($jumlah <= 0) throw new InvalidArgumentException('Jumlah tambah harus positif');
        $this->stok += $jumlah;
    }
    public function kurangiStok(int $jumlah): void {
        if ($jumlah <= 0) throw new InvalidArgumentException('Jumlah kurang harus positif');
        if ($jumlah > $this->stok) throw new InvalidArgumentException('Stok tidak mencukupi');
        $this->stok -= $jumlah;
    }
}
 
function uji(string $label, callable $fn): void {
    try { echo "[$label] OK     : " . $fn() . PHP_EOL; }
    catch (Throwable $e) { echo "[$label] DITOLAK: " . $e->getMessage() . PHP_EOL; }
}
 
echo "=== INPUT VALID ===\n";
$b = new Buku('BK-001', 'Pemrograman PHP', 10);
uji('V1 buat objek',   fn() => $b->getKodeBuku() . ' | ' . $b->getJudul() . ' | stok ' . $b->getStok());
uji('V2 tambahStok(5)', function () use ($b) { $b->tambahStok(5); return 'stok ' . $b->getStok(); });
uji('V3 kurangiStok(3)', function () use ($b) { $b->kurangiStok(3); return 'stok ' . $b->getStok(); });
uji('V4 setJudul',     function () use ($b) { $b->setJudul('  PHP OOP  '); return $b->getJudul(); });
 
echo "\n=== INPUT TIDAK VALID ===\n";
uji('X1 judul kosong',      fn() => (new Buku('BK-002', '   ', 5))->getJudul());
uji('X2 stok awal -5',      fn() => (string)(new Buku('BK-003', 'Basis Data', -5))->getStok());
uji('X3 kurangiStok(100)',  function () use ($b) { $b->kurangiStok(100); return 'stok ' . $b->getStok(); });
uji('X4 tambahStok(-2)',    function () use ($b) { $b->tambahStok(-2); return 'stok ' . $b->getStok(); });
uji('X5 kode buku kosong',  fn() => (new Buku('', 'Jaringan', 1))->getJudul());
echo 'Stok akhir tetap konsisten: ' . $b->getStok() . PHP_EOL;
 
echo "\n=== AKSES LANGSUNG ===\n";
uji('A1 $b->stok = 999',    function () use ($b) { $b->stok = 999; return 'berubah'; });
uji('A2 $b->kodeBuku',      fn() => $b->kodeBuku);