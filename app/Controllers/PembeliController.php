<?php

namespace App\Controllers;
require_once ROOTPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;


class PembeliController extends BaseController
{

    public function aboutUs()
    {
        return view('pembeli/about_us');
    }

    public function canteen()
    {
        $db = \Config\Database::connect();

        $result = $db->query("SELECT 
                                penjual.id_penjual AS id,
                                penjual.nama_kantin AS nama,
                                penjual.gambar AS gambar,
                                fakultas.nama_fakultas AS fakultas
                                FROM 
                                penjual
                                JOIN 
                                fakultas ON penjual.id_fakultas = fakultas.id_fakultas")->getResultArray();

        $id_pembeli = $this->request->getGet('id_pembeli');

        $nama_user = '';
        if ($id_pembeli) {
            $namaQuery = $db->query("SELECT nama FROM pembeli WHERE id_pembeli = ?", [$id_pembeli]);
            $row = $namaQuery->getRowArray();
            $nama_user = $row['nama'] ?? '';
        }

        return view('pembeli/canteen', [
            'result' => $result,
            'id_per_pembeli' => $id_pembeli,
            'nama_user' => $nama_user
        ]);
    }



    public function cart()
    {
        $session = session();

        // Pastikan user pembeli login dan punya id_pembeli
        if (!$session->has('id_pembeli')) {
            return redirect()->to('/logout');
        }

        $data = [
            'id_pembeli' => $session->get('id_pembeli'),
            'activePage' => 'cart'
        ];

        return view('pembeli/cart', $data);
    }

    public function checkout()
    {
        return view('pembeli/checkout');
    }

    public function history()
    {
        $db = \Config\Database::connect();
        $session = session();
        $id_pembeli = $session->get('id_pembeli');

        if (!$id_pembeli) {
            return redirect()->to('/login');
        }

        $query = $db->table('riwayat_pembelian')
            ->where('id_pembeli', $id_pembeli)
            ->orderBy('order_id')
            ->orderBy('tanggal', 'DESC')
            ->get();

        $riwayat = $query->getResultArray();

        return view('pembeli/history', [
            'id_pembeli' => $id_pembeli,
            'riwayat' => $riwayat,
            'activePage' => 'history'
        ]);
    }

    public function downloadInvoice($order_id)
    {
        $riwayatModel = new \App\Models\RiwayatPembelianModel();
        $mpdf = new \Mpdf\Mpdf();

        $data = $riwayatModel
            ->where('order_id', $order_id)
            ->findAll();

        if (!$data) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }

        // Buat isi invoice (bisa pakai view atau langsung string)
        $html = view('pembeli/invoice_template', ['data' => $data]);

        // Simpan ke file PDF (pakai dompdf)
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Download langsung
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment;filename=invoice_' . $order_id . '.pdf')
            ->setBody($dompdf->output());
    }

    public function invoicePdf($order_id)
    {
        $db = \Config\Database::connect();

        // Ambil data pesanan dari database
        $query = $db->query("
            SELECT 
                riwayat_pembelian.*, 
                user.nama AS nama, 
                penjual.id_fakultas, 
                fakultas.nama_fakultas
            FROM riwayat_pembelian
            JOIN pembeli ON riwayat_pembelian.id_pembeli = pembeli.id_pembeli
            JOIN user ON pembeli.id_user = user.id_user
            JOIN penjual ON riwayat_pembelian.nama_kantin = penjual.nama_kantin
            JOIN fakultas ON penjual.id_fakultas = fakultas.id_fakultas
            WHERE riwayat_pembelian.order_id = ?
        ", [$order_id]);

        $data['order'] = $query->getRow();

        if (!$data['order']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Order tidak ditemukan");
        }

        // Kirim order_id ke view
        $data['order_id']           = $order_id;
        $data['tanggal']            = $data['order']->tanggal;
        $data['nama_pembeli']       = $data['order']->nama;
        $data['nama_kantin']        = $data['order']->nama_kantin;
        $data['nama_fakultas']      = $data['order']->nama_fakultas;
        $data['menu']               = $data['order']->menu;
        $data['quantity']           = $data['order']->quantity;
        $data['harga']              = $data['order']->harga;
        $data['notes']              = $data['order']->notes;
        $data['status']             = $data['order']->status;
        $data['tipe']               = $data['order']->tipe;
        $data['status_pembayaran'] = $data['order']->status_pembayaran;
        $data['total']              = $data['order']->total;

        // Render view invoice ke dalam HTML
        $html = view('pembeli/invoice_template', $data);

        // Siapkan dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        $html = view('pembeli/invoice_template', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output PDF dengan nama file dan force download
        $dompdf->stream("invoice_$order_id.pdf", [
            "Attachment" => true  // true = download, false = buka di tab
        ]);
    }





    public function menu()
    {
        $id_kantin = $this->request->getGet('id_kantin');
        $id_pembeli = $this->request->getGet('id_pembeli');

        if (!$id_kantin || !$id_pembeli) {
            return redirect()->to('/auth/logout');
        }

        $db = \Config\Database::connect();

        $penjualQuery = $db->query("SELECT id_penjual, nama_kantin, gambar, link FROM penjual WHERE id_penjual = ?", [$id_kantin]);
        $penjual = $penjualQuery->getRowArray();

        $menuQuery = $db->query("SELECT * FROM menu WHERE id_penjual = ?", [$id_kantin]);
        $menus = $menuQuery->getResultArray();

        return view('pembeli/menu', [
            'penjual' => $penjual,
            'menus' => $menus,
            'id_pembeli' => $id_pembeli
        ]);
    }

    public function orderSuccess()
    {
        $order_id = $this->request->getGet('order_id');
        $id_pembeli = $this->request->getGet('id_pembeli');

        return view('/pembeli/order-success', [
            'order_id' => $order_id,
            'id_pembeli' => $id_pembeli
        ]);
    }

    public function profile()
    {
        return view('pembeli/profile');
    }

// File: app/Controllers/PembeliController.php

    public function saveOrder()
    {
        $request = service('request');
        $data = $request->getJSON(true);

        if (
            !isset($data['order_id'], $data['id_pembeli'], $data['cart'], $data['tipe'], $data['status_pembayaran'])
        ) {
            return $this->response->setJSON(['error' => 'Incomplete data'])->setStatusCode(400);
        }

        $db = \Config\Database::connect();
        $builderRiwayat = $db->table('riwayat_pembelian');

        foreach ($data['cart'] as $item) {
            $subtotal = $item['harga'] * $item['quantity'];

            $builderRiwayat->insert([
                'id_pembeli' => $data['id_pembeli'],
                'order_id' => $data['order_id'],
                'nama_kantin' => $item['nama_kantin'] ?? 'N/A',
                'menu' => $item['nama_menu'] ?? 'N/A',
                'quantity' => $item['quantity'],
                'harga' => $item['harga'],
                'notes' => $item['notes'] ?? '',
                'tipe' => $data['tipe'],
                'status_pembayaran' => $data['status_pembayaran'],
                'total' => $subtotal,
                'tanggal' => date('Y-m-d H:i:s'),
                'status' => 'diproses'
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }



    public function prosesKelolaProfile()
    {
        // Logic update profile pembeli
    }
}
