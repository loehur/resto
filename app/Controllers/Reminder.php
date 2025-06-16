<?php

class Reminder extends Controller
{
   public function cek()
   {
      $where = "DATE(NOW()) >= (next_date - INTERVAL 7 DAY)";
      $data = $this->db(0)->get_where('reminder', $where);
      foreach ($data as $d) {
         $t1 = strtotime($d['next_date']);
         $t2 = strtotime(date("Y-m-d H:i:s"));
         $diff = $t1 - $t2;
         $dates = floor(($diff / (60 * 60)) / 24);

         if ($dates > 0) {
            $text_count = $dates . " Hari Lagi";
         } elseif ($dates < 0) {
            $text_count = "Terlewat " . $dates * -1 . " Hari";
         } else {
            $text_count = "Hari Ini";
         }

         $link = "";
         if ($d['link'] <> "") {
            $link = "\n" . $d['link'];
         }

         $ops_link = $this->HOST_URL . "/I/r/" . $d['id'];
         $hp = $d['notif_number'];
         $text = "*" . $d['name'] . "* " . $link . " \n" . $text_count . " \n" . $ops_link;
         echo $d['name'] . " " . $text_count . " \n";

         $res = $this->model(URL::WA_API[0])->send($hp, $text, URL::WA_TOKEN[0]);
         if ($res['forward']) {
            //ALTERNATIF WHATSAPP
            $res = $this->model(URL::WA_API[1])->send($hp, $text, URL::WA_TOKEN[1]);
         }
      }
   }

   function update()
   {
      $id = $_POST['id'];
      $where = "id = " . $id;
      $data = $this->db(0)->get_where_row('reminder', $where);
      $cycle = $data['cycle'];

      $t1 = strtotime($data['next_date']);
      $t2 = strtotime(date("Y-m-d H:i:s"));
      $diff = $t1 - $t2;
      $dates = floor(($diff / (60 * 60)) / 24);

      if ($dates <= 7) {
         $next_date = date("Y-m-d", strtotime($data['next_date'] . " +" . $cycle . " month"));
         $up = $this->db(0)->update('reminder', "next_date = '" . $next_date . "'", $where);
         if ($up['errno'] == 0) {
            echo 0;
         } else {
            echo "Error Updating, Hubungi Admin";
         }
      }
   }

   function cek_kas_cabang()
   {
      $hp = URL::WA_MANAGER;
      $cabangs = $this->db(0)->get("cabang", "id_cabang");
      $data = $this->data('Saldo')->kasCabang();
      $text = "";
      foreach ($data as $key => $s) {
         if ($s >= 1000000) {
            if (strlen($text) == 0) {
               $text = "*" . $cabangs[$key]['kode_cabang'] . "* Rp" . number_format($s);
            } else {
               $text .= "\n*" . $cabangs[$key]['kode_cabang'] . "* Rp" . number_format($s);
            }

            $text_log = $cabangs[$key]['kode_cabang'] . " Rp" . number_format($s);
            echo $text_log . " \n";
         }
      }

      if (strlen($text) > 0) {
         $res = $this->model(URL::WA_API[0])->send($hp, $text, URL::WA_TOKEN[0]);
         if ($res['forward']) {
            //ALTERNATIF WHATSAPP
            $res = $this->model(URL::WA_API[1])->send($hp, $text, URL::WA_TOKEN[1]);
         }
      } else {
         echo "ALL CASH UNDER 1.000.000 \n";
      }
   }
}
