<?
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed'); 

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pedidos extends REST_Controller {
    function __construct() { 
        parent::__construct(); 
        $this->load->model('Pedidos_model','model_pedido');

    }

    public function index_get(){
        $id = (int) $this->uri->segment(2);
        if ($id <= 0){
            $pedidos = $this->model_pedido->GetAll();
        }else{
            $pedidos = $this->model_pedido->GetById($id);
        }
        
        if($pedidos){
            $response['data'] = $pedidos;
            $this->response($response, REST_Controller::HTTP_OK);
        }else{
            $this->response(null,REST_Controller::HTTP_NO_CONTENT);
        }
        

    }

    public function index_post(){
        $pedido = $this->post();

        $response = $this->model_pedido->Insert($pedido);

        if ($response['status']) {
            $response['data'] =  $this->model_pedido->GetById($response['id_pedido']);
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    


    public function index_put(){
        $dados = $this->put();
        $pedido_id = $this->uri->segment(2);
        
        if ($pedido_id <= 0){
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->model_pedido->Update($pedido_id,$dados);
        
        if ($response['status']) {
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    

    

    public function index_delete(){
        $pedido_id = (int) $this->uri->segment(2);
        if ($pedido_id <= 0){
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->model_pedido->Delete($pedido_id);
        
        if ($response['status']) {
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }
    }



}
