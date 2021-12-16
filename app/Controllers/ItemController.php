<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ItemModel;
use phpDocumentor\Reflection\PseudoTypes\True_;

class ItemController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        //get all item
        $model = new ItemModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $model = new ItemModel();
        $data = $model->getWhere(['id' => $id])->getResult();
        if($data == True){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Data Tidak Ditemukan Berdasarkan Id yang dipilih'. $id);
        }
    }

    public function create()
    {
        $model = new ItemModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'status' > $this->request->getPost('status')
        ];
        $data = json_decode(file_get_contents("php::/input"));

        $model->insert($data);
        $respone = [
            'status'    => 201,
            'error'     => null,
            'message'   => [
                'success' => 'Data Saved'
            ]
            ];
            return $this->respondCreated($data, 201);
    }

    public function update($id = null)
    {
        $model = new ItemModel();
        $json = $this->request->getJSON();
        if($json == True){
            $data = [
                'nama' =>$json->nama,
                'deskripsi' =>$json->deskripsi,
                'harga' =>$json->harga,
                'status' =>$json->status
            ];
        }else{
            $input = $this->request->getRawInput();
            $data = [
                'nama' =>$json->nama,
                'deskripsi' =>$json->deskripsi,
                'harga' =>$json->harga,
                'status' =>$json->status
            ];
        }

        //insert database
        $model->update($id, $data);
        $respone = [
            'status'   => 200,
            'error'    => null,
            'message'  => [
                    'success' => 'Data Berhasil di Update'
            ]
            ];
            return $this->respond($respone);
    }

    public function delete($id = null)
    {
        $model = new ItemModel();
        $data = $model->find($id);
        if($data == True)
        {
            $model->delete($id);
            $respone = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data Berhasil Di Hapus'
                ]
                ];

                return $this->respondDeleted($respone);
        }else{
            return $this->failNotFound('Data Not Found With Id' .$id);
        }
    }
}
