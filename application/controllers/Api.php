<?php
header("Access-Control-Allow-Origin: *");
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController
{
    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('M_api');
    }
    
    /**
     * ambil daftar riwayat permainan
     *
     * @return array
     */
    public function history_get()
    {
        // ambil riwayat permainan
        $riwayat = $this->M_api->get_history();

        // cek apakah terdapat riwayat permainan
        if (!empty($riwayat)) {
            // Set the response and exit
            $this->response([
                'status' => true,
                'data' => $riwayat
            ], 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'Tidak ada dapat menemukan riwayat permainan'
            ], 404);
        }

    }
    
    /**
     * simpan riwayat permainanz
     *
     * @return void
     */
    public function save_post()
    {

        // get data post
        $params = $this->post();

        if(!is_array($params)){
            $this->response([
                'status' => false,
                'message' => 'Params is invalid'
            ], 422);

        }
        
        foreach ($params as $key => $val):
            $params = str_replace('"', '', $key);
            break;
        endforeach;
        
        
        $params = json_decode(str_replace("'", '"', $params), true);
        
        // ej($params['nama']);

        // cek and get data user
        $user = $this->M_api->cek_user($params);

        // build array save riwayat
        $data = [
            'user' => [
                'user_id' => $user['data']['user_id'],
                'nama' => $user['data']['nama'],
            ],
            'riwayat' => [
                'user_id' => $user['data']['user_id'],
                'benar' => $params['benar'],
                'salah' => $params['salah'],
                'created_at' => time()
            ]
        ];

        // unset array user jika user sudah ada
        if($user['status'] == true){
            unset($data['user']);
        }
        
        // simpan riwayat permainan kedatabase
        $res = $this->M_api->simpan_riwayat($data);

        // cek status response
        if ($res == true) {
            $this->response([
                'status' => true,
                'message' => 'Berhasil menyimpan riwayat permainan'
            ],  200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gagal menyimpan riwayat permainan'
            ],  200);
        }

    }
}
