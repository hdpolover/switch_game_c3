<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_home extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get riwayat permainan
     *
     * @return array
     */
    public function get_history(){
        $this->db->select('*');
        $this->db->from('tb_riwayat a');
        $this->db->join('tb_user b', 'a.user_id = b.user_id', 'left');
        $this->db->order_by('a.id DESC');
        return $this->db->get()->result();
    }
    
    /**
     * cek user berdasarkan nama
     *
     * @param  array $params
     * 
     * @return array
     */
    public function cek_user($params = []){
        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->like('nama', $params['nama']);

        $user = $this->db->get()->row();

        if($user){
            return [
                'status' => true,
                'data' => $user
            ];
        }else{

            $user_id = $this->db->get('tb_user')->num_rows();
            
            $user_id = $user_id+1;

            $user = [
                'user_id' => $user_id,
                'nama' => $params['nama']
            ];

            return [
                'status' => false,
                'data' => $user
            ];
        }
    }
        
    /**
     * simpan riwayat permainan
     *
     * @param  array $params
     * 
     * @return boolean
     */
    public function simpan_riwayat($params = []){

        // jika user baru, maka insert ke tabel user terlebih dahulu
        if(isset($params['user'])){
            $data = [
                'user_id' => $params['user']['user_id'],
                'nama' => $params['user']['nama']
            ];

            $this->db->insert('tb_riwayat', $data);
        }
        
        // inser ke tabel riwayat
        $data = [
            'user_id' => $params['riwayat']['user_id'],
            'benar' => $params['riwayat']['benar'],
            'salah' => $params['riwayat']['salah'],
        ];

        $this->db->insert('tb_riwayat', $data);
        return (($this->db->affected_rows() != 1) ? false : true);
    }
}
