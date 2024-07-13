<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;

class Berkas extends BaseController
{
    public function __construct()
    {
        $this->base_model   = model('Berkas');
        $this->base_name    = 'berkas';
        $this->upload_path  = 'assets/uploads/' . $this->base_name . '/';
    }

    public function getData()
    {
        $total_rows = $this->base_model->countAll();
        $limit = $this->request->getVar('length') ?? $total_rows;
        $offset = $this->request->getVar('start') ?? 0;

        if ($this->user_session['id_role'] == 1) {
            $data = $this->base_model->orderBy('created_at DESC')->findAll($limit, $offset);
        } else {
            $data = $this->base_model
                    ->where('npwp_dipotong', $this->user_session['id'])
                    ->orderBy('created_at DESC')
                    ->findAll($limit, $offset);
        }

        $search = $this->request->getVar('search')['value'];
        if ($search) {
            $data = $this->base_model->like('npwp_dipotong', $search)->findAll($limit, $offset);
            $total_rows   = $this->base_model->like('npwp_dipotong', $search)->countAllResults();
        }

        foreach ($data as $key => $v) {
            $data[$key]['no_urut'] = $offset + $key + 1;
            $data[$key]['id'] = encode($v['id']);
            $data[$key]['created_at'] = date('d-m-Y H:i:s', strtotime($v['created_at']));
        }

        return $this->response->setJSON([
            'recordsTotal'    => $this->base_model->countAll(),
            'recordsFiltered' => $total_rows,
            'data'            => $data,
        ]);
    }

    public function index()
    {
        $data = [
            'id_role'    => $this->user_session['id_role'],
            'get_data'   => $this->base_route . '/get-data',
            'base_route' => $this->base_route,
            'title'      => ucwords(str_replace('_', ' ', $this->base_name)),
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/main', $data);
        return view('dashboard/header', $view);
    }

    public function importExcel()
    {
        $rules = [
            'excel' => 'uploaded[excel]|max_size[excel,1024]|ext_in[excel,xlsx,xls,csv]',
        ];
        if (! $this->validate($rules)) {
            $error = str_replace('excel,', '', service('validation')->getError('excel'));
            return redirect()->to($this->base_route)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'error',
                title: '$error',
                })
            </script>");
        } else {
            $excel = $this->request->getFile('excel');
            $spreadsheet = IOFactory::load($excel->getTempName());
            $sheetData = $spreadsheet->getActiveSheet()->toArray('', true, true, true);
            $total_data = [];
            foreach (array_slice($sheetData, 1) as $row) {
                $data = [
                    'no_bukti'      => str_replace(' ', '', $row['E']),
                    'tanggal_bukti' => date('Y-m-d', strtotime($row['F'])),
                    'npwp_dipotong' => substr($row['A'], 0, 12),
                    'nama'          => $row['B'],
                ];
                // dd($data);
                $this->base_model->insert($data);
                $total_data[] = $total_data;
            }
            $total_data = count($total_data);

            return redirect()->to($this->base_route)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'success',
                title: '$total_data data ditambahkan',
                })
            </script>");
        }
    }

    public function delete($id_encode = null)
    {
        $id = decode($id_encode);
        $find_data = $this->base_model->find($id);

        $this->base_model->delete($id);
        return redirect()->to($this->base_route)
        ->with('message',
        "<script>
            Swal.fire({
            icon: 'success',
            title: 'Data berhasil dihapus',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            })
        </script>");
    }
}
