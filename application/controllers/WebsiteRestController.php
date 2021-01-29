<?php
defined('BASEPATH') OR exit ('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){ 
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit;
}

require (APPPATH . '/libraries/REST_Controller.php');
require APPPATH . 'libraries/Format.php';

use Restserver\Libraries\REST_Controller;

class WebsiteRestController extends REST_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('website_model', 'wm');
    }

    function websites_get(){
        $websites    =   $this->wm->get_website_list();
        if ($websites){
            $this->response($websites, 200);
        } else {
            $this->response(array(), 200);
        }
    }

    function website_get(){
        if(!$this->get('id')){
            $this->response(NULL, 400);
        }
        $website    =   $this->wm->get_website($this->get('id'));

        if($website){
            $this->response($website, 200);
        } else {
            $this->response(array(), 500);
        }
    }

    function add_website_post(){
        $website_title  =   $this->post('title');
        $website_url    =   $this->post('url');

        var_dump($website_title);die;

        $result =   $this->wm->add_website($website_title, $website_url);
        if($result === false){
            $this->response(array('status' => 'failed'));
        } else {
            $this->response(array('status' => 'success'));
        }
    }

    function update_website_put(){
        $wesbite_id     =   $this->put('id');
        $website_title  =   $this->put('title');
        $website_url    =   $this->put('url');
        
        $result =   $this->wm->update_website($wesbite_id, $website_title, $website_url);

        if($result === FALSE){
            $this->response(array('status' => 'failed'));
        } else {
            $this->response(array('status' => 'success'));
        }
    }
}