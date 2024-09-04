<?php

namespace App\Controllers;

use App\Models\PesertaModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CRUDController extends BaseController
{
    // Menampilkan
    public function index()
    {
        $model = new PesertaModel();
        $data['peserta'] = $model->findAll();
        return view('items/view', $data);
    }

    // Menambahkan
    public function create()
    {
        return view('items/tambah');
    }

    public function store()
    {
        $model = new PesertaModel();

        // Upload KTM pertama
        $ktmFile = $this->request->getFile('ktm');
        $ktmName = $ktmFile->getRandomName();
        $ktmFile->move('uploads', $ktmName);

        // Upload KTM kedua
        $ktmFile2 = $this->request->getFile('ktm2');
        $ktmName2 = $ktmFile2->getRandomName();


        // Handle cropped image for ktm2 (if using Cropper.js)
        $croppedImageData = $this->request->getPost('croppedImageData');
        if (!empty($croppedImageData)) {
            $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $croppedImageData));
            $croppedImageName = 'cropped_' . $ktmName2; // Generate a unique name for cropped image
            file_put_contents('uploads/' . $croppedImageName, $croppedImage);
            // Simpan $croppedImageName ke dalam database
            $data['ktm2'] = $croppedImageName; // Misalnya, simpan nama file hasil crop ke dalam array $data
        } else {
            // Jika tidak ada gambar yang dipotong, tetap simpan nama file asli
            $data['ktm2'] = $ktmName2;
        }

        // Siapkan data untuk disimpan ke database
        $data = [
            'nama' => $this->request->getPost('nama'),
            'nim' => $this->request->getPost('nim'),
            'domisili' => $this->request->getPost('domisili'),
            'ktm' => $ktmName,
            'ktm2' => $data['ktm2'], // Gunakan nama file yang sudah disesuaikan sesuai dengan kondisi di atas
        ];

        // Simpan data peserta baru
        if ($model->insert($data)) {
            return redirect()->to('/view');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data peserta.');
        }
    }

    // Mengupdate
    public function edit($id)
    {
        $model = new PesertaModel();
        $data['peserta'] = $model->find($id);
        return view('items/edit', $data);
    }

    public function update($id)
    {
        $model = new PesertaModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'nim' => $this->request->getPost('nim'),
            'domisili' => $this->request->getPost('domisili'),
        ];

        if ($ktmFile = $this->request->getFile('ktm')) {
            if ($ktmFile->isValid() && !$ktmFile->hasMoved()) {
                $ktmName = $ktmFile->getRandomName();
                $ktmFile->move('uploads', $ktmName);
                $data['ktm'] = $ktmName;
            }
        }

        if ($ktmFile2 = $this->request->getFile('ktm2')) {
            if ($ktmFile2->isValid() && !$ktmFile2->hasMoved()) {
                $ktmName2 = $ktmFile->getRandomName();
                $data['ktm2'] = $ktmName2;
            }
        }

        // Handle cropped image for ktm2
        $croppedImageData = $this->request->getPost('croppedImageData');
        if (!empty($croppedImageData)) {
            $croppedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $croppedImageData));
            $croppedImageName = 'cropped_' . $ktmName2; // Generate a unique name for cropped image
            file_put_contents('uploads/' . $croppedImageName, $croppedImage);
            $data['ktm2'] = $croppedImageName; // Use the cropped image name
        }

        if ($model->update($id, $data)) {
            return redirect()->to('/view');
        } else {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
    }

    // Menghapus
    public function delete($id)
    {
        $model = new PesertaModel();
        
        $peserta = $model->find($id);
        $namaFile = $peserta['ktm'];
        $namaFile2 = $peserta['ktm2'];
        
        $path1 = 'uploads/' . $namaFile;
        if (file_exists($path1)) {
            unlink($path1);
        }
        
        $path2 = 'uploads/' . $namaFile2;
        if (file_exists($path2)) {
            unlink($path2);
        }
        
        $model->delete($id);
        return redirect()->to('/view');
    }
}