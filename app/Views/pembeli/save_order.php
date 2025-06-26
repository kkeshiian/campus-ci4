<?php

include "../../database/koneksi.php";
include "../../database/model.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit;
}

$order_id = trim($data['order_id'] ?? '');
$id_pembeli = trim($data['id_pembeli'] ?? '');
$cart = $data['cart'] ?? [];

if (empty($order_id) || empty($id_pembeli) || !is_array($cart) || count($cart) === 0) {
    echo json_encode(['success' => false, 'message' => 'Missing or invalid order_id, id_pembeli, or cart']);
    exit;
}

$created_at = $data['created_at'] ?? null;

$allowed_tipe = ['cash', 'cashless'];
$allowed_status = ['paid', 'pending'];

$tipe = in_array($data['tipe'] ?? '', $allowed_tipe) ? $data['tipe'] : 'cashless';
$status_pembayaran = in_array($data['status_pembayaran'] ?? '', $allowed_status) ? $data['status_pembayaran'] : (($tipe === 'cash') ? 'pending' : 'paid');

$result = saveOrderSimple($koneksi, $order_id, $id_pembeli, $cart, $created_at, $tipe, $status_pembayaran);

echo json_encode($result);
