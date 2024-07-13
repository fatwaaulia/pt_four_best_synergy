<?php

namespace App\Controllers;

class AppSettings extends BaseController
{
    public function __construct()
    {
        $this->base_model   = model('AppSettings');
        $this->base_name    = 'app_settings';
        $this->upload_path  = 'assets/uploads/' . $this->base_name . '/';
    }

    public function index()
    {
        $id = 1;
        $data = [
            'data'        => $this->base_model->find($id),
            'base_route'  => $this->base_route,
            'upload_path' => $this->upload_path,
            'title'       => ucwords(str_replace('_', ' ', $this->base_name)),
        ];
        
        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/edit', $data);
        return view('dashboard/header', $view);
    }

    public function update($id_encode = null)
    {
        $id = decode($id_encode);
        $find_data = $this->base_model->find($id);

        $rules = [
            'nama_aplikasi'   => 'required',
            'nama_perusahaan' => 'required',
            'deskripsi'       => 'required',
            'no_hp'           => 'required',
            'logo'            => 'max_size[logo,1024]|ext_in[logo,png,jpg,jpeg]',
            'favicon'         => 'max_size[favicon,1024]|ext_in[favicon,png,jpg,jpeg]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }else {
            $logo = $this->request->getFile('logo');
            if ($logo != '') {
                $file = $this->upload_path . $find_data['logo'];
                if (is_file($file)) unlink($file);
                $logo_name = 'logo.' . $logo->guessExtension();
                $this->image->withFile($logo)->save($this->upload_path . $logo_name, 60);
            } else {
                $logo_name = $find_data['logo'];
            }

            $favicon = $this->request->getFile('favicon');
            if ($favicon != '') {
                $file = $this->upload_path . $find_data['favicon'];
                if (is_file($file)) unlink($file);
                $favicon_name = 'favicon.' . $favicon->guessExtension();
                $this->image->withFile($favicon)->save($this->upload_path . $favicon_name, 60);
            } else {
                $favicon_name = $find_data['favicon'];
            }

            $data = [
                'nama_aplikasi'     => $this->request->getVar('nama_aplikasi', $this->filter),
                'nama_perusahaan'   => $this->request->getVar('nama_perusahaan', $this->filter),
                'no_hp'             => $this->request->getVar('no_hp', $this->filter),
                'deskripsi'         => $this->request->getVar('deskripsi', $this->filter),
                'logo'              => $logo_name,
                'favicon'           => $favicon_name,
                'alamat'            => $this->request->getVar('alamat', $this->filter),
                'maps'              => $this->request->getVar('maps', $this->filter),
            ];

            $this->base_model->update($id, $data);
            return redirect()->to($this->base_route . '?menu=edit')
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'success',
                title: 'Perubahan disimpan',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        }
    }
}
