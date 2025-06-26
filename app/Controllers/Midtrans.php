<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Midtrans as MidtransConfig;
use Midtrans\Snap;
use Midtrans\Config as MidtransCoreConfig;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PembayaranModel;

class Midtrans extends Controller
{
    public function __construct()
    {
        MidtransCoreConfig::$serverKey = MidtransConfig::$serverKey;
        MidtransCoreConfig::$isProduction = MidtransConfig::$isProduction;
        MidtransCoreConfig::$isSanitized = MidtransConfig::$isSanitized;
        MidtransCoreConfig::$is3ds = MidtransConfig::$is3ds;
    }

    public function getToken()
    {
        $request = service('request');
        $data = $request->getJSON(true);

        if (!isset($data['order_id'], $data['gross_amount'], $data['items'])) {
            return $this->response->setJSON(['error' => 'Invalid request'])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $data['order_id'],
                'gross_amount' => $data['gross_amount'],
            ],
            'item_details' => [],
            'customer_details' => [
                'first_name' => 'Pembeli',
                'email' => 'pembeli@email.com',
            ]
        ];

        foreach ($data['items'] as $item) {
            $params['item_details'][] = [
                'id' => $item['id'] ?? 'item',
                'price' => (int)$item['harga'],
                'quantity' => (int)$item['quantity'],
                'name' => $item['nama_menu'],
            ];
        }

        try {
            $snapToken = Snap::getSnapToken($params);
            return $this->response->setJSON(['token' => $snapToken]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function callback()
    {
        $db = \Config\Database::connect();
        $notif = json_decode(file_get_contents("php://input"));

        $order_id = $notif->order_id ?? null;
        $transaction_status = $notif->transaction_status ?? null;

        if ($transaction_status === 'settlement' && $order_id) {
            $db->query("UPDATE pembayaran SET status='dibayar' WHERE id_pesanan = ?", [$order_id]);

            $query = $db->query("
                SELECT dp.id_menu, m.id_penjual, dp.jumlah, dp.subtotal
                FROM detail_penjualan dp
                JOIN menu m ON dp.id_menu = m.id_menu
                WHERE dp.id_pesanan = ?
            ", [$order_id]);

            $penjual_data = [];

            foreach ($query->getResultArray() as $row) {
                $id_penjual = $row['id_penjual'];
                if (!isset($penjual_data[$id_penjual])) {
                    $penjual_data[$id_penjual] = [
                        'jumlah_menu' => 0,
                        'jumlah_pesanan' => 0
                    ];
                }
                $penjual_data[$id_penjual]['jumlah_menu'] += $row['jumlah'];
                $penjual_data[$id_penjual]['jumlah_pesanan'] += $row['subtotal'];
            }

            foreach ($penjual_data as $id_penjual => $data) {
                $tanggal = date('Y-m-d H:i:s');
                $db->query("
                    INSERT INTO laporan_penjualan (id_penjual, jumlah_pesanan, jumlah_menu, tanggal_laporan)
                    VALUES (?, ?, ?, ?)
                ", [$id_penjual, $data['jumlah_pesanan'], $data['jumlah_menu'], $tanggal]);

                $id_laporan = $db->insertID();

                $db->query("
                    UPDATE detail_penjualan 
                    JOIN menu ON detail_penjualan.id_menu = menu.id_menu
                    SET id_laporan = ?
                    WHERE id_pesanan = ? AND menu.id_penjual = ?
                ", [$id_laporan, $order_id, $id_penjual]);

                $db->query("
                    UPDATE pesanan SET id_laporan = ? WHERE id_pesanan = ?
                ", [$id_laporan, $order_id]);
            }

            return $this->response->setJSON(['status' => 'callback processed']);
        }

        return $this->response->setJSON(['error' => 'Invalid or unsupported status'])->setStatusCode(400);
    }
}
