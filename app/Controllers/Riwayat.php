<?php

class Riwayat extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->operating_data();
   }

   public function index()
   {
      $layout = ['title' => 'Riwayat Pesanan'];
      $data['ref'] = $this->db($this->book)->get_where('ref', "step <> 0 AND tgl = '" . date("Y-m-d") . "'", 'id');

      $order = [];
      $total = [];
      $pay = [];
      foreach ($data['ref'] as $key => $r) {
         $order[$key] = $this->db($this->book)->get_where('pesanan', "ref = '" . $key . "'");
         $pay[$key] = $this->db($this->book)->get_where_row('kas', "ref = '" . $key . "'");
         $total[$key] = 0;
         foreach ($order[$key] as $dk) {
            $subTotal = ($dk['harga'] * $dk['qty']) - $dk['diskon'];
            $total[$key] += $subTotal;
         }
      }

      $data['pay'] = $pay;
      $data['order'] = $order;
      $data['total'] = $total;

      $this->view('layout', $layout);
      $this->view(__CLASS__ . "/main", $data);
   }
}
