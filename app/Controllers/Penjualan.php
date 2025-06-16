<?php

class Penjualan extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->operating_data();
   }

   public function index()
   {
      $layout = ['title' => 'Buka Order'];
      $data['kat'] =  $_SESSION['kat'];
      $data['order_0'] = $this->db($this->book)->get_where('ref', "step = 0 AND mode = 0", "nomor");
      $data['order_1'] = $this->db($this->book)->get_where('ref', "step = 0 AND mode = 1", "nomor");
      $this->view('layout', $layout);
      $this->view(__CLASS__ . "/main", $data);
   }

   public function cart($mode = 0, $nomor = 0)
   {
      $viewData = __CLASS__ . '/cart';
      $data['mode'] = $mode;
      $data['nomor'] = $nomor;

      $cek = $this->db($this->book)->get_where_row('ref', "mode = " . $mode . " AND nomor = " . $nomor . " AND step = 0");
      if (count($cek) > 0) {
         $data['menu'] = $_SESSION['menu'];
         $data['order'] = $this->db($this->book)->get_where('pesanan', "ref = '" . $cek['id'] . "'", "id_menu");
      } else {
         $data['order'] = [];
      }
      $this->view($viewData, $data);
   }

   public function menu($id_kat = 0, $mode = 0, $nomor = 0)
   {
      $viewData = __CLASS__ . '/menu';
      if ($id_kat == 0) {
         $data['menu'] = $_SESSION['menu'];
      } else {
         $menu_byKat =  $_SESSION['menu_byKat'];
         $data['menu'] = isset($menu_byKat[$id_kat]) ? $menu_byKat[$id_kat] : [];
      }

      $cek = $this->db($this->book)->get_where_row('ref', "mode = " . $mode . " AND nomor = " . $nomor . " AND step = 0");
      if (count($cek) > 0) {
         $data['order'] = $this->db($this->book)->get_where('pesanan', "ref = '" . $cek['id'] . "'", "id_menu");
      } else {
         $data['order'] = [];
      }

      $this->view($viewData, $data);
   }

   public function ubah($mode = 0, $nomor = 0)
   {
      $viewData = __CLASS__ . '/ubah';
      $data['menu'] = $this->db(0)->get_where('menu_item', $this->wCabang . " ORDER BY freq DESC", 'id');

      $cek = $this->db($this->book)->get_where_row('ref', "mode = " . $mode . " AND nomor = " . $nomor . " AND step = 0");
      if (count($cek) > 0) {
         $data['order'] = $this->db($this->book)->get_where('pesanan', "ref = '" . $cek['id'] . "'", "id_menu");
      } else {
         $data['order'] = [];
      }

      $this->view($viewData, $data);
   }

   public function bayar()
   {
      $mode = $_POST['mode'];
      $nomor = $_POST['nomor'];
      $dibayar = $_POST['dibayar'];
      $metode = $_POST['metode'];

      if ($metode == 1) {
         $st_mutasi = 1;
      } else {
         $st_mutasi = 0;
      }

      $cek = $this->db($this->book)->get_where_row('ref', "mode = " . $mode . " AND nomor = " . $nomor . " AND step = 0");
      if (count($cek) > 0) {
         $order = $this->db($this->book)->get_where('pesanan', "ref = '" . $cek['id'] . "'", "id_menu");
      } else {
         $order = [];
      }

      $total = 0;
      foreach ($order as $dk) {
         $subTotal = ($dk['harga'] * $dk['qty']) - $dk['diskon'];
         $total += $subTotal;
      }

      if ($total > 0) {
         $kembali = $dibayar - $total;
         $cols = "id_cabang, jenis_mutasi, jenis_transaksi, ref, metode_mutasi, status_mutasi, jumlah, id_user, dibayar, kembali";
         $vals = $this->id_cabang . ",1,1,'" . $cek['id'] . "'," . $metode . "," . $st_mutasi . "," . $total . "," . $this->id_user . "," . $dibayar . "," . $kembali;
         $in = $this->db($this->book)->insertCols("kas", $cols, $vals);
         if ($in['errno'] == 0) {
            $up = $this->db($this->book)->update('ref', "step = 1", "id = '" . $cek['id'] . "'");
            echo $up['errno'] == 0 ? 0 : $up['error'];
         } else {
            echo $in['error'];
         }
      }
   }

   public function piutang()
   {
      $mode = $_POST['mode'];
      $nomor = $_POST['nomor'];
      $pelanggan = $_POST['pelanggan'];

      if ($pelanggan <= 0) {
         echo "Pelanggan tidak ditemukan";
         exit();
      }

      $cek = $this->db($this->book)->get_where_row('ref', "mode = " . $mode . " AND nomor = " . $nomor . " AND step = 0");
      if (count($cek) > 0) {
         $order = $this->db($this->book)->get_where('pesanan', "ref = '" . $cek['id'] . "'", "id_menu");
      } else {
         $order = [];
      }

      $total = 0;
      foreach ($order as $dk) {
         $subTotal = ($dk['harga'] * $dk['qty']) - $dk['diskon'];
         $total += $subTotal;
      }

      if ($total > 0) {
         $up = $this->db($this->book)->update('ref', "step = 3, pelanggan = " . $pelanggan, "id = '" . $cek['id'] . "'");
         echo $up['errno'] == 0 ? 0 : $up['error'];
      }
   }

   public function cek_bayar($mode = 0, $nomor = 0)
   {
      $viewData = __CLASS__ . '/bayar';

      $data['mode'] = $mode;
      $data['nomor'] = $nomor;

      $cek = $this->db($this->book)->get_where_row('ref', "mode = " . $mode . " AND nomor = " . $nomor . " AND step = 0");
      if (count($cek) > 0) {
         $data['order'] = $this->db($this->book)->get_where('pesanan', "ref = '" . $cek['id'] . "'", "id_menu");
      } else {
         $data['order'] = [];
      }

      $this->view($viewData, $data);
   }

   public function cek_piutang($mode = 0, $nomor = 0)
   {
      $viewData = __CLASS__ . '/piutang';

      $data['mode'] = $mode;
      $data['nomor'] = $nomor;

      $cek = $this->db($this->book)->get_where_row('ref', "mode = " . $mode . " AND nomor = " . $nomor . " AND step = 0");
      if (count($cek) > 0) {
         $data['order'] = $this->db($this->book)->get_where('pesanan', "ref = '" . $cek['id'] . "'", "id_menu");
      } else {
         $data['order'] = [];
      }

      $data['pelanggan'] = $this->db(0)->get("pelanggan");
      $this->view($viewData, $data);
   }

   function add($mode, $nomor)
   {

      $cek = $this->db($this->book)->get_where_row("ref", "mode = " . $mode . " AND nomor = " . $nomor . " AND step = 0");
      if (count($cek) > 0) {
         $p = $_POST;

         $where = "id_menu = " . $p['id'] . " AND ref = '" . $cek['id'] . "'";
         $cek_menu = $this->db($this->book)->get_where_row("pesanan", $where);
         if (count($cek_menu) > 0) {
            if ($cek_menu['qty'] == 1 && $p['add'] == -1) {
               $del = $this->db($this->book)->delete_where("pesanan", $where);
               if ($del['errno'] == 0) {
                  $hitung_menu = $this->db($this->book)->count_where("pesanan", "ref = '" . $cek_menu['ref'] . "'");
                  if ($hitung_menu == 0) {
                     //update freq
                     $this->db(0)->update("menu_item", "freq = freq + " . $p['add'], "id = " . $p['id']);
                     $this->db(0)->update("menu_kategori", "freq = freq + " . $p['add'], "id = " . $p['id_kat']);

                     $del = $this->db($this->book)->delete_where("ref", "id = '" . $cek_menu['ref'] . "'");
                     echo $del['errno'] == 0 ? 1 : $del['error'];
                  } else {
                     echo 0;
                  }
               } else {
                  echo $del['error'];
               }
            } else {
               $up = $this->db($this->book)->update("pesanan", "qty = qty + " . $p['add'], $where);
               //update freq
               $this->db(0)->update("menu_item", "freq = freq + " . $p['add'], "id = " . $p['id']);
               $this->db(0)->update("menu_kategori", "freq = freq + " . $p['add'], "id = " . $p['id_kat']);
               echo $up['errno'] == 0 ? 0 : $up['error'];
            }
         } else {
            $p = $_POST;
            $cols = "ref, id_menu, qty, harga";
            $vals = "'" . $cek['id'] . "'," . $p['id'] . ",1," . $p['harga'];
            $in = $this->db($this->book)->insertCols("pesanan", $cols, $vals);
            //update freq
            $this->db(0)->update("menu_item", "freq = freq + " . $p['add'], "id = " . $p['id']);
            $this->db(0)->update("menu_kategori", "freq = freq + " . $p['add'], "id = " . $p['id_kat']);
            echo $in['errno'] == 0 ? 0 : $in['error'];
         }
      } else {
         $ref = date('mdHis') . $this->id_cabang;
         $cols = "id, mode, nomor, tgl, jam, id_cabang";
         $vals = "'" . $ref . "'," . $mode . "," . $nomor . ",'" . date('Y-m-d') . "','" . date("H:i") . "'," . $this->id_cabang;
         $in = $this->db($this->book)->insertCols("ref", $cols, $vals);
         if ($in['errno'] == 0) {
            $p = $_POST;
            $cols = "ref, id_menu, qty, harga";
            $vals = "'" . $ref . "'," . $p['id'] . ",1," . $p['harga'];
            $in = $this->db($this->book)->insertCols("pesanan", $cols, $vals);
            //update freq
            $this->db(0)->update("menu_item", "freq = freq + " . $p['add'], "id = " . $p['id']);
            $this->db(0)->update("menu_kategori", "freq = freq + " . $p['add'], "id = " . $p['id_kat']);
            echo $in['errno'] == 0 ? 0 : $in['error'];
         } else {
            echo $in['error'];
         }
      }
   }

   function set_diskon()
   {
      $p = $_POST;
      $where = "id = " . $p['id'];
      $cek_menu = $this->db($this->book)->get_where_row("pesanan", $where);
      $max_diskon = $cek_menu['harga'] * $cek_menu['qty'];
      if ($p['diskon'] > $max_diskon) {
         echo "Dikon melebihi Total";
         exit();
      }
      $up = $this->db($this->book)->update("pesanan", "diskon = " . $p['diskon'], $where);
      echo $up['errno'] == 0 ? 0 : $up['error'];
   }
}
