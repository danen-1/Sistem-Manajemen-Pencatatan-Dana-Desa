<?php

namespace SistemIuran; // namespace untuk mengelompokkan class


// interface: menentukan method yang wajib dimiliki class lain

interface HitungDana
{

    public function hitungSaldo(); // method wajib

}


/* parent class*/

class DanaDesa
{

    // properties: variabel dalam class untuk menyimpan data
    protected $pemasukan;
    protected $pengeluaran;

    // constructor: dijalankan saat object dibuat
    public function __construct($pemasukan = 0, $pengeluaran = 0)
    {
        $this->pemasukan = $pemasukan;
        $this->pengeluaran = $pengeluaran;
    }

    // overloading: method bisa dipanggil dengan parameter berbeda
    public function setDana($pemasukan, $pengeluaran = 0)
    {
        $this->pemasukan = $pemasukan;
        $this->pengeluaran = $pengeluaran;
    }
}


/* child class */

// inheritance: class ini mewarisi class DanaDesa
// implements: menggunakan interface HitungDana

class SaldoDana extends DanaDesa implements HitungDana
{

    // polymorphism: method hitungSaldo memiliki perilaku sendiri
    public function hitungSaldo()
    {
        return $this->pemasukan - $this->pengeluaran;
    }
}


/* polymorphism */

class SaldoDanaCadangan extends DanaDesa implements HitungDana
{

    // polymorphism: method sama tetapi cara perhitungan berbeda
    public function hitungSaldo()
    {
        $saldo = $this->pemasukan - $this->pengeluaran;


        return $saldo * 0.9;
    }
}

?>