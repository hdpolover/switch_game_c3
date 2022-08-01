<?php
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
        $users = $this->M_api->get_history();

        // cek apakah terdapat riwayat permainan
        if (!empty($users)) {
            // Set the response and exit
            $this->response($users, 200);
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
