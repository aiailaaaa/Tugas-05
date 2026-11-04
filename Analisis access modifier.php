<?php
declare(strict_types=1);
class Produk {
    public string $nama;
    protected string $kategori;
    private int $harga;

    public function __construct(string $nama, string $kategori, int $harga) {
        $this->nama = $nama;
        $this->kategori = $kategori;
        $this->harga = $harga;
    }
    public function getHarga(): int { return $this->harga; }
}

class ProdukDigital extends Produk {
    public function infoKategori(): string { return $this->kategori; } // protected
    public function cobaHarga() { return $this->harga; }               // private induk
}

$p = new Produk('Buku PHP', 'Buku', 75000);
echo $p->nama;       
echo $p->kategori;   
echo $p->harga;      
echo $p->getHarga(); 

$d = new ProdukDigital('E-Book PHP', 'Digital', 50000);
echo $d->infoKategori(); 
echo $d->cobaHarga();    