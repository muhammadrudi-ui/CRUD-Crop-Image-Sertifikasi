<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Peserta</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Cropper.js library -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

  <style>
    .image-preview {
      width: 160px;
      height: 80px;
      object-fit: cover;
      margin-top: 10px;
    }
  </style>

</head>

<body>

  <div class="container mt-5">
    <h2>Edit Peserta</h2>

    <form action="/mengupdate/<?= $peserta['id'] ?>" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $peserta['nama'] ?>" required>
      </div>
      <div class="mb-3">
        <label for="nim" class="form-label">NIM</label>
        <input type="text" class="form-control" id="nim" name="nim" value="<?= $peserta['nim'] ?>" required>
      </div>
      <div class="mb-3">
        <label for="domisili" class="form-label">Domisili</label>
        <input type="text" class="form-control" id="domisili" name="domisili" value="<?= $peserta['domisili'] ?>"
          required>
      </div>
      <div class="mb-3">
        <label for="ktm" class="form-label">Upload KTM</label>
        <input type="file" class="form-control" id="ktm" name="ktm">
        <img id="preview" class="image-preview" src="<?= base_url('uploads/' . $peserta['ktm']) ?>" alt="Current Image">
      </div>
      <div class="mb-3">
        <label for="ktm2" class="form-label">Upload KTM Bisa Crop</label>
        <input type="file" class="form-control" id="ktm2" name="ktm2">
        <img id="croppedPreview" class="image-preview" src="<?= base_url('uploads/' . $peserta['ktm2']) ?>"
          alt="Current Image">
        <div>
          <button type="button" id="cropButton" class="btn btn-success mt-3">Crop Image</button>
        </div>
        <!-- Hidden input to store cropped image data -->
        <input type="hidden" id="croppedImageData" name="croppedImageData">
        <!-- Preview for cropped image -->
        <div class="mt-3">
          <h5>Preview Hasil Cropping</h5>
          <img id="croppedResult" class="image-preview" src="#" alt="Cropped Result">
        </div>
      </div>
      <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Update</button>
      <a href="/view" class="btn btn-secondary">Kembali</a>
    </form>
  </div>

  <script>
    document.getElementById('ktm').onchange = function (event) {
      const [file] = event.target.files;
      if (file) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
      }
    };

    document.getElementById('ktm2').onchange = function (event) {
      const [file] = event.target.files;
      if (file) {
        const preview = document.getElementById('croppedPreview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';

        // Initialize Cropper.js
        const cropper = new Cropper(preview, {
          aspectRatio: 2.25, // Aspect ratio for 180x80px
          viewMode: 2,
        });

        // Crop button event
        document.getElementById('cropButton').onclick = function () {
          const canvas = cropper.getCroppedCanvas({
            width: 180,
            height: 80,
          });
          if (canvas) {
            canvas.toBlob(function (blob) {
              const croppedFile = new File([blob], file.name);
              const reader = new FileReader();
              reader.onload = function (e) {
                // Show cropped image preview
                const croppedPreview = document.getElementById('croppedResult');
                croppedPreview.src = e.target.result;
                croppedPreview.style.display = 'block';

                // Update hidden input with cropped image data
                const hiddenInput = document.getElementById('croppedImageData');
                hiddenInput.value = canvas.toDataURL(); // Store base64 data in hidden input
              };
              reader.readAsDataURL(croppedFile);
            });
          }
        };
      }
    };
  </script>

</body>

</html>