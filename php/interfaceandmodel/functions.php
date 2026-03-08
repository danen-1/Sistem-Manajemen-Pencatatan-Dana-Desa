<?php

namespace SistemHelper; // namespace help

/* fungsi untuk format rupiah dan status pembayaran */
function formatRupiah($angka)
{

    return "Rp " . number_format($angka, 0, ",", ".");
}

/* fungsi untuk menampilkan status pembayaran dengan badge */
function statusPembayaran($status)
{

    if ($status == "Lunas") {
        return '<span class="badge bg-success">Lunas</span>';
    } else {
        return '<span class="badge bg-danger">Belum Lunas</span>';
    }
}

?>