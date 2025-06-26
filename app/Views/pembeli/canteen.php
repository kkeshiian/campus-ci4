<?php $id_pembeli = $id_pembeli ?? null; ?>
<?php $activePage = $activePage ?? 'canteen'; ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
    <title>Welcome to CampusEats</title>

  </head>
  <body class="min-h-screen flex flex-col">
  <?= view('partial/navbar-pembeli') ?>

    
    <!-- main content --> 
    <h2 class="mx-auto text-2xl font-bold m-4" data-aos="fade-up" data-aos-duration="1000">
      Where do You want to eat today?
    </h2> 

    <!-- card -->
    <div
      id="card-container"
      class="grid grid-cols-2 md:grid-cols-5 gap-4 w-[90%] mx-auto"
      data-aos="fade-up" data-aos-duration="1000"
    >
      <?php
        if (!empty($result)) {
          foreach ($result as $kantin)  {
            if ($kantin['gambar'] == null || $kantin['gambar'] == '') {
              $kantin['gambar'] = "../../assets/img/default-canteen.jpg";
            }
            echo '
              <div class="flex flex-col justify-between h-full bg-white rounded-lg shadow-lg border border-black p-4">
                <div>
                  <img src="/campuseats/' . htmlspecialchars(str_replace('\\', '/', $kantin["gambar"])) . '" alt="Kantin Image" class="rounded-t-lg w-full h-36 object-cover" />
                  <div class="pt-4 pb-4">
                    <h2 class="text-xl font-semibold">' . htmlspecialchars($kantin["nama"]) . '</h2>
                    <p class="text-gray-600">Fakultas ' . htmlspecialchars($kantin["fakultas"]) . '</p>
                  </div>
                </div>
                <div>
                  <a href="menu?id_kantin=' . urlencode($kantin["id"]) . '&id_pembeli=' . urlencode($id_per_pembeli) . '" class="btn bg-kuning text-black rounded-lg px-4 py-2 hover:bg-yellow-600 w-full text-center">View Menu</a>
                </div>
              </div>';
          }
        } else {
          echo "<p class='col-span-full text-center'>No canteen data found.</p>";
          echo"<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
        }
        ?>
  
  </div>
  <?= view('partial/footer') ?>
  <script>
      AOS.init({
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>

<?php $nama_user = $nama_user ?? ''; ?>

<script>
  const notyf = new Notyf({
    duration: 3000,
    position: { x: 'right', y: 'top' },
    types: [
      {
        type: 'success',
        background: '#FFB43B',
        icon: { className: 'notyf__icon--success', tagName: 'i' }
      },
      {
        type: 'error',
        background: '#d63031',
        icon: { className: 'notyf__icon--error', tagName: 'i' }
      }
    ]
  });

  const urlParams = new URLSearchParams(window.location.search);
  const userName = <?=json_encode($nama_user)?>;
  if (urlParams.get('success') === '1') {
    notyf.success(`Successfully logged in! Welcome to Campuseats ${userName}`);
    // Hapus parameter agar toast tidak muncul lagi saat reload
    window.history.replaceState({}, document.title, window.location.pathname + window.location.search.replace(/([&?])success=1/, '').replace(/([&?])$/, ''));
  }
</script>
  </body>
</html>
