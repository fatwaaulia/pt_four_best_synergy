<?php

namespace App\Controllers;

class Landingpage extends BaseController
{
    public function beranda()
    {
        if (strpos($_SERVER['HTTP_HOST'], 'www.') === 0) {
            $url = 'http://' . substr($_SERVER['HTTP_HOST'], 4) . $_SERVER['REQUEST_URI'];
            header('Location: ' . $url);
            exit();
        }

        $view['navbar'] = view('landingpage/navbar');
        $view['content'] = view('landingpage/beranda');
        $view['footer'] = view('landingpage/footer');
        return view('landingpage/header', $view);
    }

    public function berita()
    {
        $model_berita = model('Berita');
        if (isset($_GET['s'])) {
            $berita = $model_berita->like('judul', $_GET['s'])->findAll();
        } else {
            $berita = $model_berita->orderBy('created_at', 'DESC')->findAll();
        }

        $data = [
            'berita' => $berita,
            'berita_rekomendasi' => $model_berita->orderBy('created_at', 'RANDOM')->findAll(4),
            'title' => 'Berita',
        ];
        
        $view['navbar'] = view('landingpage/navbar');
        $view['content'] = view('landingpage/berita', $data);
        $view['footer'] = view('landingpage/footer');
        return view('landingpage/header', $view);
    }

    public function isiBerita($slug)
    {
        $model_berita = model('Berita');
        $berita = $model_berita->where('slug', $slug)->first();

        $data = [
            'berita' => $berita,
            'berita_rekomendasi' => $model_berita->orderBy('created_at', 'RANDOM')->findAll(4),
            'title' => $berita['judul'],
        ];

        $model_berita->update($berita['id'], ['viewed' => (int)$berita['viewed'] + 1]);

        $view['navbar'] = view('landingpage/navbar');
        $view['content'] = view('landingpage/isi_berita', $data);
        $view['footer'] = view('landingpage/footer');
        return view('landingpage/header', $view);
    }
}
