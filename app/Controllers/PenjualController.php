<?php
namespace App\Controllers;

use App\Models\PenjualModel;      
use App\Models\FakultasModel;    
use App\Models\RiwayatPembelianModel;    
use CodeIgniter\Controller;

class PenjualController extends BaseController
{
    public function dashboard()
    {
            $session = session();
            $id_penjual = $session->get('id_penjual');

            $penjualModel = new PenjualModel();
            $penjual = $penjualModel->find($id_penjual);

            $fakultasModel = new FakultasModel();
            $fakultas = $fakultasModel->find($penjual['id_fakultas']);

            $nama_kantin = $penjual['nama_kantin'];
            $tanggal_hari_ini = date('Y-m-d');

            $riwayatModel = new RiwayatPembelianModel();
            $semuaPesanan = $riwayatModel
                ->where('nama_kantin', $nama_kantin)
                ->orderBy('tanggal', 'DESC')
                ->findAll();

            $daftar_pesanan_hari_ini = [];
            $total_keseluruhan = 0;
            $total_orderan = 0;

            foreach ($semuaPesanan as $pesanan) {
                if (date('Y-m-d', strtotime($pesanan['tanggal'])) === $tanggal_hari_ini) {
                    $daftar_pesanan_hari_ini[] = $pesanan;
                    $total_keseluruhan += $pesanan['total'];
                    $total_orderan += $pesanan['quantity'];
                }
            }

            // 3. Pendapatan 7 hari terakhir
            $mingguan = $riwayatModel->select('SUM(quantity) AS qty, SUM(total) AS total')
                ->where('nama_kantin', $nama_kantin)
                ->where('status', 'Done')
                ->where('tanggal >=', date('Y-m-d', strtotime('-6 days')))
                ->first();

            return view('penjual/dashboard', [
                'id_penjual' => $id_penjual,
                'nama_kantin' => $nama_kantin,
                'nama_fakultas' => $fakultas['nama_fakultas'],
                'riwayat' => $daftar_pesanan_hari_ini,
                'total_orderan' => $total_orderan,
                'total_pendapatan' => $mingguan['total'] ?? 0,
            ]);
    }
    

    public function kelolaMenu()
    {
        $session = session();
        $id_penjual = $session->get('id_penjual');

        $menuModel = new \App\Models\MenuModel();
        $daftar_menu = $menuModel->where('id_penjual', $id_penjual)->findAll();

        return view('penjual/kelola_menu', [
            'id_penjual' => $id_penjual,
            'daftar_menu' => $daftar_menu,
        ]);
    }

    public function editMenu()
    {
        $session = session();
        $id_penjual = $session->get('id_penjual');
        $request = $this->request;

        // Kalau GET → tampilkan form edit
        if ($request->getMethod() === 'get') {
            $id_menu = $request->getGet('id_menu'); // ambil dari URL ?id_menu=...

            $menuModel = new \App\Models\MenuModel();
            $menu = $menuModel->getMenu($id_menu);

            if (!$menu || $menu['id_penjual'] != $id_penjual) {
                return redirect()->to('/penjual/kelola-menu')->with('error', 'Access denied.');
            }

            return view('penjual/edit-menu', [
                'menu' => $menu,
                'id_penjual' => $id_penjual,
            ]);
        }

        // Kalau POST → proses simpan perubahan
        if ($request->getMethod() === 'post') {
            $id_menu = $request->getPost('id_menu');
            $nama_menu = $request->getPost('nama');
            $harga = $request->getPost('harga');
            $gambar = $request->getFile('gambar');

            $menuModel = new \App\Models\MenuModel();
            $menu = $menuModel->getMenu($id_menu);

            if (!$menu || $menu['id_penjual'] != $id_penjual) {
                return redirect()->back()->with('error', 'Unauthorized.');
            }

            $updateData = [
                'nama_menu' => $nama_menu,
                'harga' => $harga
            ];

            // Jika user upload gambar baru
            if ($gambar->isValid() && !$gambar->hasMoved()) {
                $namaBaru = $gambar->getRandomName();
                $gambar->move('uploads/menu/', $namaBaru);
                $updateData['gambar'] = 'uploads/menu/' . $namaBaru;
            }

            $menuModel->updateMenu($id_menu, $updateData);
            return redirect()->to('/penjual/kelola-menu')->with('success', 'Menu updated successfully!');
        }
    }

    public function prosesEditMenu()
    {
        // Logic edit menu
    }

    public function prosesHapusMenu($id_menu)
    {
        $session = session();
        $id_penjual = $session->get('id_penjual');

        if (!$id_penjual || !$id_menu) {
            return redirect()->to('/penjual/kelola-menu')->with('error', 'hapus');
        }

        $menuModel = new \App\Models\MenuModel();

        // Cek apakah menu milik penjual
        $menu = $menuModel->find($id_menu);
        if (!$menu || $menu['id_penjual'] != $id_penjual) {
            return redirect()->to('/penjual/kelola-menu')->with('error', 'hapus');
        }

        // Hapus file gambar jika ada
        if (!empty($menu['gambar']) && file_exists(FCPATH . $menu['gambar'])) {
            unlink(FCPATH . $menu['gambar']);
        }

        // Hapus data menu dari database
        $menuModel->delete($id_menu);

        return redirect()->to('/penjual/kelola-menu')->with('success', 'hapus');
    }


    public function kelolaKantin()
    {
        $session = session();
        $id_penjual = $session->get('id_penjual');

        $penjualModel = new \App\Models\PenjualModel();
        $fakultasModel = new \App\Models\FakultasModel();

        $penjual = $penjualModel->find($id_penjual);
        $fakultas = $fakultasModel->findAll();

        return view('penjual/kelola_kantin', [
            'id_penjual' => $id_penjual,
            'penjual' => $penjual,
            'fakultas' => $fakultas,
        ]);
    }

    public function laporanPenjualan()
    {
        helper('date');
        $penjualId = session()->get('id_penjual');

        if (!$penjualId) {
            return redirect()->to(base_url('auth/logout'));
        }

        $penjualModel = new \App\Models\PenjualModel();
        $riwayatModel = new \App\Models\RiwayatPembelianModel();

        $penjual = $penjualModel->find($penjualId);
        if (!$penjual) {
            return redirect()->to(base_url('auth/logout'));
        }

        $namaKantin = $penjual['nama_kantin'];

        // Data tanggal
        $tanggalAkhir = date('d M Y');
        $tanggalAwal = date('d M Y', strtotime('-6 days'));

        // Total transaksi 7 hari terakhir
        $ringkasan = $riwayatModel
            ->select('SUM(quantity) as qty, SUM(total) as total')
            ->where('nama_kantin', $namaKantin)
            ->where('tanggal >=', date('Y-m-d', strtotime('-6 days')))
            ->where('status', 'Done')
            ->first();

        // Best day
        $bestDay = $riwayatModel
            ->select("DAYNAME(tanggal) AS hari, SUM(total) AS total_hari")
            ->where('nama_kantin', $namaKantin)
            ->where('tanggal >=', date('Y-m-d', strtotime('-6 days')))
            ->where('status', 'Done')
            ->groupBy('hari')
            ->orderBy('total_hari', 'DESC')
            ->first();

        // Data chart 7 hari terakhir
        $labels = [];
        $sales = [];
        for ($i = 6; $i >= 0; $i--) {
            $dateObj = new \DateTime("-$i days", new \DateTimeZone('Asia/Makassar'));
            $date = $dateObj->format('Y-m-d');
            $dayLabel = $dateObj->format('D');
            $labels[] = $dayLabel;

            $total = $riwayatModel
                ->select('SUM(total) as total')
                ->where('nama_kantin', $namaKantin)
                ->where("DATE(tanggal)", $date)
                ->where('status', 'Done')
                ->first();

            $sales[] = (int)($total['total'] ?? 0);
        }

        return view('penjual/laporan_penjualan', [
            'ringkasan' => $ringkasan,
            'best_day' => $bestDay,
            'tanggal_awal' => $tanggalAwal,
            'tanggal_akhir' => $tanggalAkhir,
            'labels' => $labels,
            'sales' => $sales,
        ]);
    }


    public function prosesReport()
    {
        // Logic kirim report pembeli
    }

    public function reportProblem()
    {
        return view('penjual/report_problem');
    }
    public function updateStatusPesanan()
    {
        $request = $this->request;
        $orderId = $request->getPost('id');
        $menu = $request->getPost('menu');
        $newStatus = $request->getPost('status');

        if (!$orderId || !$menu || !$newStatus) {
            return redirect()->back()->with('error', 'Invalid request.');
        }

        $riwayatModel = new \App\Models\RiwayatPembelianModel();
        $riwayatModel->where([
            'order_id' => $orderId,
            'menu' => $menu
        ])->set(['status' => $newStatus])->update();

        return redirect()->back()->with('success', 'Order status updated.');
    }
    public function tambahMenu()
    {
        $session = session();
        $id_penjual = $session->get('id_penjual');

        return view('penjual/tambah-menu', [
            'id_penjual' => $id_penjual
        ]);
    }

    public function prosesTambahMenu()
    {
        $session = session();
        $menuModel = new \App\Models\MenuModel();

        $id_penjual = $this->request->getPost('id_penjual');
        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $gambar = $this->request->getFile('gambar');

        if (!$nama || !$harga || !$gambar->isValid()) {
            return redirect()->back()->with('error', 'Please fill in all fields!');
        }

        // Upload gambar
        $gambarName = $gambar->getRandomName();
        $gambar->move('uploads/menu', $gambarName); // Folder: public/uploads/menu

        $menuModel->tambahMenu([
            'id_penjual' => $id_penjual,
            'nama_menu' => $nama,
            'harga' => $harga,
            'gambar' => 'uploads/menu/' . $gambarName
        ]);

        return redirect()->to(base_url('penjual/kelola-menu'))->with('success', 'Menu added successfully!');
    }

    public function prosesKelolaKantin()
    {
        $request = $this->request;
        $id_penjual = $request->getPost('id_penjual');

        $penjualModel = new \App\Models\PenjualModel();

        $data = [
            'nama_kantin' => $request->getPost('nama_kantin'),
            'id_fakultas' => $request->getPost('id_fakultas'),
            'link' => $request->getPost('link')
        ];

        // Jika ada gambar baru
        $gambar = $this->request->getFile('foto_kantin');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaBaru = $gambar->getRandomName();
            $gambar->move('uploads/kantin/', $namaBaru);
            $data['gambar'] = 'uploads/kantin/' . $namaBaru;
        }

        $penjualModel->update($id_penjual, $data);

        return redirect()->to(base_url('penjual/kelola-kantin'))->with('success', 'Changes saved successfully!');
    }

    

}
