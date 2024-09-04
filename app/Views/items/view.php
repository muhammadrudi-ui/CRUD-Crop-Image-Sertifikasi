<!DOCTYPE html>
<html lang="en">
<head>
  <title>CRUD ELECOMP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    .table {
      text-align: center;
    }
    .table th,
    .table td {
      vertical-align: middle;
    }
    .table img {
      display: block;
      margin: 0 auto;
      width: 160px;
      height: 80px;
      object-fit: cover;
      filter: blur(8px);
      transition: filter 0.15s ease;
    }
    .table img.lazyloaded {
      filter: blur(0);
    }
  </style>

</head>
<body>

<div class="container mt-5">
  <h2 style="text-align: center; margin-bottom: 30px;">PENDAFTARAN SERTIFIKASI BNSP POLIWANGI</h2>
  
  <div class="d-flex justify-content-start mb-3">
    <a href="/tambah" class="btn btn-success">Tambah</a>
  </div>
  
  <table class="table">
    <thead class="table-dark">
      <tr>
        <th>Nama</th>
        <th>NIM</th>
        <th>Domisili</th>
        <th>KTM</th>
        <th>KTM2</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($peserta as $p) : ?>
      <tr>
        <td><?= $p['nama'] ?></td>
        <td><?= $p['nim'] ?></td>
        <td><?= $p['domisili'] ?></td>
        <td><img data-src="<?= base_url('uploads/' . $p['ktm']) ?>" alt="Image 1" class="lazy"></td>
        <td><img data-src="<?= base_url('uploads/' . $p['ktm2']) ?>" alt="Image 2" class="lazy"></td>
        <td>
          <a href="/edit/<?= $p['id'] ?>" class="btn btn-warning" style="margin-right: 10px;">Edit</a>
          <a href="/delete/<?= $p['id'] ?>" class="btn btn-danger">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    let lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

    if ("IntersectionObserver" in window) {
      let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            let lazyImage = entry.target;
            lazyImage.src = lazyImage.dataset.src;
            lazyImage.classList.remove("lazy");
            lazyImage.classList.add("lazyloaded");
            lazyImageObserver.unobserve(lazyImage);
          }
        });
      });

      lazyImages.forEach(function(lazyImage) {
        lazyImageObserver.observe(lazyImage);
      });
    } else {
      // Fallback for older browsers
      let lazyLoadThrottleTimeout;
      function lazyLoad() {
        if (lazyLoadThrottleTimeout) {
          clearTimeout(lazyLoadThrottleTimeout);
        }

        lazyLoadThrottleTimeout = setTimeout(function() {
          let scrollTop = window.pageYOffset;
          lazyImages.forEach(function(img) {
            if (img.offsetTop < window.innerHeight + scrollTop) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
              img.classList.add('lazyloaded');
            }
          });
          if (lazyImages.length == 0) {
            document.removeEventListener("scroll", lazyLoad);
            window.removeEventListener("resize", lazyLoad);
            window.removeEventListener("orientationChange", lazyLoad);
          }
        }, 20);
      }

      document.addEventListener("scroll", lazyLoad);
      window.addEventListener("resize", lazyLoad);
      window.addEventListener("orientationChange", lazyLoad);
    }
  });
</script>

</body>
</html>
