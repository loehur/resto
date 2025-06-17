<?php

class WA_Status extends Controller
{
   function __construct()
   {
      $this->session_cek();
      $this->operating_data();
   }

   function index()
   {
      $layout = ['title' => __CLASS__];
      $this->view('layout', $layout);
      $this->view(__CLASS__ . '/loader');
   }

   function content()
   {
      $res = $this->model('WA_Local')->cek_status();
      $this->view(__CLASS__ . '/content', $res);
   }
}
