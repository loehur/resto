<?php

class Piutang extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->operating_data();
   }

   public function index()
   {
      $layout = ['title' => 'Piutang'];
      $data['ref'] = [];
      $data['ref'] = $this->db($this->book)->get_where('ref', "step = 3", 'id');
      $data['pelanggan'] = $this->db(0)->get("pelanggan", "id");

      $order = [];
      $data_ = [];

      foreach ($data['ref'] as $key => $r) {
         $order[$key] = $this->db($this->book)->get_where('pesanan', "ref = '" . $key . "'");
         foreach ($order[$key] as $dk) {
            $subTotal = ($dk['harga'] * $dk['qty']) - $dk['diskon'];
            if (isset($data_[$r['pelanggan']])) {
               $data_[$r['pelanggan']] += $subTotal;
            } else {
               $data_[$r['pelanggan']] = $subTotal;
            }
         }
      }

      $data['order'] = $order;
      $data['data'] = $data_;

      $this->view('layout', $layout);
      $this->view(__CLASS__ . "/main", $data);
   }

   public function cart($pelanggan = 0)
   {
      $viewData = __CLASS__ . '/cart';
      $data['order'] = $this->db($this->book)->get_where('ref', "pelanggan = " . $pelanggan . " AND step = 3", "tgl", 1);
      $data['order_ref'] = $this->db($this->book)->get_where('ref', "pelanggan = " . $pelanggan . " AND step = 3", "id");

      foreach ($data['order_ref'] as $key => $r) {
         $order[$key] = $this->db($this->book)->get_where('pesanan', "ref = '" . $key . "'");
         foreach ($order[$key] as $dk) {
            $subTotal = ($dk['harga'] * $dk['qty']) - $dk['diskon'];
            if (isset($total[$r['tgl']])) {
               $total[$r['tgl']] += $subTotal;
            } else {
               $total[$r['tgl']] = $subTotal;
            }
         }
      }

      $data['total'] = $total;
      $data['pelanggan'] = $pelanggan;
      $this->view($viewData, $data);
   }

   public function cart2($pelanggan, $tgl)
   {
      $viewData = __CLASS__ . '/cart2';
      $data['menu'] = $_SESSION['resto_menu'];
      $data['ref'] = $this->db($this->book)->get_where('ref', "pelanggan = " . $pelanggan . " AND tgl = '" . $tgl . "'", 'id');
      foreach ($data['ref'] as $key => $d) {
         $data['order'][$key] = $this->db($this->book)->get_where('pesanan', "ref = '" . $key . "'", "id_menu");
      }
      $this->view($viewData, $data);
   }
}
