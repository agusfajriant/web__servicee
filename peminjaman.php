<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class peminjaman extends REST_Controller {
	
	function __construct($config = 'rest') {
		parent::__Construct($config);
	}
	
	//Menampilkan data
	public function index_get() {
		
		$id = $this->get('id');
		if ($id == '') {
			$data = $this->db->get('peminjaman')->result();
		} else {
			$this->db->where('id_peminjaman', $id);
			$data = $this->db->get('peminjaman')->result();
		}
		$result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
				   "code"=>200,
				   "message"=>"Response successfully",
				   "data"=>$data];
		$this->response($result, 200);
	    }


   //Menambah data 
   public function index_post() {
    $data = array(
        'id_peminjaman'  => $this->post('id_peminjaman'),
        'tanggal_pinjam' => $this->post('tanggal_pinjam'),
        'tanggal_kembali'  => $this->post('tanggal_kembali'),
        'id_buku'  => $this->post('id_buku'),
        'id_anggota'  => $this->post('id_anggota'),
        'id_petugas'  => $this->post('id_petugas'));
    $insert = $this->db->insert('peminjaman', $data);
    if ($insert) {
        //$this->response($data, 200);
        $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
            "Code"=>201,
            "message"=>"Data has successfully added",
            "data"=>$data];
        $this->response($result, 201);
    } else {
        $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
            "code"=>502,
            "message"=>"Failed adding data",
            "data"=>null];
        $this->response($result, 502);  
        }
    }

     //Memperbarui data yang telah ada
     public function index_put() {
        $id = $this->put('id');
        $data = array (
        'id_peminjaman'  => $this->post('id_peminjaman'),
        'tanggal_pinjam' => $this->post('tanggal_pinjam'),
        'tanggal_kembali'  => $this->post('tanggal_kembali'),
        'id_buku'  => $this->post('id_buku'),
        'id_anggota'  => $this->post('id_anggota'),
        'id_petugas'  => $this->post('id_petugas'));

        $this->db->where('id_peminjaman', $id);
        $update = $this->db->db->update('peminjaman', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
     }

    //Menghapus data anggota
    public function index_delete() {
        $id = $this->delete('id');
        $this->db->where('id_peminjaman', $id);
        $delete = $this->db->delete('peminjaman');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
  
}
?>