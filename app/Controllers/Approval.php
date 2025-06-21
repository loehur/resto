<?php

class Approval extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->operating_data();
   }

   public function index()
   {
      $layout = ['title' => 'Approval'];
      $data['pengeluaran'] = $this->db($this->book)->count_where('kas', "status_mutasi = 0 AND jenis_transaksi = 4 AND jenis_mutasi = 2");

      $this->view('layout', $layout);
      $this->view(__CLASS__ . "/main", $data);
   }

   public function cek_pengeluaran()
   {
      $data['pengeluaran'] = $this->db($this->book)->get_where('kas', "status_mutasi = 0 AND jenis_transaksi = 4 AND jenis_mutasi = 2", 'id');
      $viewData = __CLASS__ . '/pengeluaran';
      $this->view($viewData, $data);
   }

   function pengeluaran_verivy()
   {
      $p = $_POST;

      $up =  $this->db($this->book)->update('kas', "status_mutasi = " . $p['v'], "id = " . $p['id']);
      if ($up['errno'] == 0) {
         echo $this->db($this->book)->count_where('kas', "status_mutasi = 0 AND jenis_transaksi = 4 AND jenis_mutasi = 2");
      } else {
         echo $up['error'];
      }
   }
}
