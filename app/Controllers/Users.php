<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function __construct()
    {
        $this->base_model   = model('Users');
        $this->base_name    = 'users';
        $this->upload_path  = 'assets/uploads/' . $this->base_name . '/';
    }

    public function getData()
    {
        $total_rows = $this->base_model->countAll();
        $limit = $this->request->getVar('length') ?? $total_rows;
        $offset = $this->request->getVar('start') ?? 0;
        
        $data = $this->base_model->findAll($limit, $offset);

        $search = $this->request->getVar('search')['value'];
        if ($search) {
            $data = $this->base_model->like('username', $search)->findAll($limit, $offset);
            $total_rows   = $this->base_model->like('username', $search)->countAllResults();
        }

        foreach ($data as $key => $v) {
            $data[$key]['no_urut'] = $offset + $key + 1;
            $data[$key]['id'] = encode($v['id']);
            $data[$key]['id_decode'] = $v['id'];
            $data[$key]['nama_role'] = model('Role')->select(['id', 'nama'])->where('id', $v['id_role'])->first()['nama'];
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
        $search = '';
        $role = $this->request->getVar('role', $this->filter);
        if ($role) $search = '?role=' . $role;

        $data = [
            'get_data'    => $this->base_route . '/get-data' . $search,
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => ucwords(str_replace('_', ' ', $this->base_name)),
        ];

        $view['content'] = view($this->base_name . '/main', $data);
        $view['sidebar'] = view('dashboard/sidebar', $data);
        return view('dashboard/header', $view);
    }

    public function new()
    {
        $data = [
            'base_route' => $this->base_route,
            'title'      => 'Add User',
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/new', $data);
        return view('dashboard/header', $view);
    }

    public function create()
    {
        $rules = [
            'id_user'   => "required|numeric|min_length[12]|max_length[12]|is_unique[$this->base_name.id]",
            'password'  => 'required',
            'passconf'  => 'required|matches[password]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }else {
            $password = $this->request->getVar('password');
            $data = [
                'id_role'   => 2,
                'id'        => $this->request->getVar('id_user', $this->filter),
                'password'  => $this->base_model->password_hash($password),
            ];

            $this->base_model->insert($data);
            return redirect()->to($this->base_route)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'success',
                title: 'Data berhasil ditambahkan',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        }
    }

    public function edit($id_encode = null)
    {
        $id = decode($id_encode);

        $data = [
            'data'        => $this->base_model->find($id),
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Edit User',
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
            'id_user'   => "required|numeric|min_length[12]|max_length[12]|is_unique[$this->base_name.id,id,$id]",
            'passconf'  => 'permit_empty|required|matches[password]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $password = $this->request->getVar('password');
            $data = [
                'id'        => $this->request->getVar('id_user', $this->filter),
                'password'  => $this->base_model->password_hash($password),
            ];

            $this->base_model->update($id, $data);
            return redirect()->to($this->base_route)
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
