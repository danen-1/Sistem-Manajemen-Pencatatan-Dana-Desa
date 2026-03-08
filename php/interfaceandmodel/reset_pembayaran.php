<?php

/* interface untuk reset pembayaran bulanan */
interface ResetInterface
{
    public function resetBulanan();
}

/* class untuk pembayaran bulanan */
class Pembayaran
{

    protected $conn;
    protected $bulan;
    protected $tahun;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->bulan = date("F");
        $this->tahun = date("Y");
    }
}

/* inheritance */

class ResetPembayaran extends Pembayaran implements ResetInterface
{

    public function resetBulanan()
    {

        $cek = mysqli_query($this->conn, "
        SELECT * FROM pembayaran
        WHERE bulan='$this->bulan'
        AND tahun='$this->tahun'
        ");

        /* jika belum ada data bulan ini */

        if (mysqli_num_rows($cek) == 0) {

            $keluarga = mysqli_query($this->conn, "
            SELECT * FROM keluarga
            ");

            /* looping semua keluarga */

            while ($row = mysqli_fetch_assoc($keluarga)) {

                $id = $row['id_keluarga'];

                mysqli_query($this->conn, "
                INSERT INTO pembayaran
                (id_keluarga,bulan,tahun,jumlah,status)
                VALUES
                ('$id','$this->bulan','$this->tahun','50000','Belum Lunas')
                ");
            }
        }
    }
}

?>