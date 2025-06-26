<?php

namespace App\Controllers;

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
            ->orderBy('nama_kantin')
            ->orderBy('tanggal')
            ->get();

        $riwayat = $query->getResultArray();

        return view('pembeli/history', [
            'id_pembeli' => $id_pembeli,
            'riwayat' => $riwayat,
            'activePage' => 'history'
        ]);
        return view('pembeli/history');
    }

    public function invoice()
    {
        return view('pembeli/invoice');
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
        
        $db = \Config\Database::connect();

        $id_kantin = $this->request->getGet('id_kantin');
        $id_pembeli = $this->request->getGet('id_pembeli');

        $penjualQuery = $db->query("SELECT id_penjual, nama_kantin, gambar, link FROM penjual WHERE id_penjual = ?", [$id_kantin]);
        $penjual = $penjualQuery->getRowArray();

        $menuQuery = $db->query("SELECT * FROM menu WHERE id_penjual = ?", [$id_kantin]);
        $menus = $menuQuery->getResultArray(); // array berisi banyak menu

        return view('pembeli/menu', [
            'penjual' => $penjual,
            'menus' => $menus,
            'id_per_pembeli' => $id_pembeli
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
