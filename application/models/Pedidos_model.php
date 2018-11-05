<?
defined('BASEPATH') OR exit('No direct script access allowed');
class Pedidos_model extends CI_Model {
    
    public function GetAll($id=NULL){
        $this->db->select("i.id_pedido as pedido, i.id as item, i.tamanho,i.sabor, ps.descricao as adicional");
        $this->db->select("(SELECT SUM(COALESCE(it.tamanho_tempo, 0) + COALESCE(it.sabor_tempo, 0) + COALESCE(psl.tempo, 0) ) FROM item it LEFT JOIN personalizacao psl on psl.id_item = it.id WHERE i.id = it.id GROUP BY psl.id_item) as tempo_preparo");
        $this->db->select("(SELECT SUM(COALESCE(it.tamanho_valor, 0) + COALESCE(it.sabor_valor, 0) + COALESCE(psl.valor, 0) ) FROM item it LEFT JOIN personalizacao psl on psl.id_item = it.id WHERE i.id = it.id GROUP BY psl.id_item) as valor");
        if(!empty($id)){
        	$this->db->where('i.id_pedido',$id);
        }
        $this->db->from('item i');
        $this->db->join('pedido p','i.id_pedido = p.id');
        $this->db->join('personalizacao ps','ps.id_item = i.id','left');
        $this->db->order_by('i.data','DESC');
        $this->db->order_by('i.id_pedido','DESC');
        return $this->db->get()->result_array();
    }

    public function GetById($id){
        return $this->GetAll($id);
    }

    public function Insert($dados) {
        if (!isset($dados)) {
            $response['status'] = false;
            $response['message'] = "Dados não informados.";
        } else {
 			$personalizacao = false;
            
            $this->form_validation->set_data($dados);
            
            $this->form_validation->set_rules('tamanho','','required',array('required' => 'Você deve selecionar o tamanho.'));
            $this->form_validation->set_rules('tamanho_tempo','','required',array('required' => 'O tamanho não disponível no momento.'));
            $this->form_validation->set_rules('tamanho_valor','','required',array('required' => 'O tamanho não disponível no momento.'));
            $this->form_validation->set_rules('sabor','','required',array('required' => 'Você deve selecionar um sabor.'));
            $this->form_validation->set_rules('sabor_tempo','','required',array('required' => 'O sabor selecionado não está disponível no momento.'));
            $this->form_validation->set_rules('sabor_valor','','required',array('required' => 'O sabor selecionado não está disponível no momento.'));
            
            if(!empty($dados['personalizacao_descricao'])){
            	$this->form_validation->set_rules('personalizacao_valor','','required',array('required' => 'A personalizacao escolhida não é permitida.'));
            	$this->form_validation->set_rules('personalizacao_tempo','','required',array('required' => 'A personalizacao escolhida não é permitida.'));            	
	 			$personalizacao = true;
            }

            if ($this->form_validation->run() === false) {
                $response['status'] = false;
                $response['message'] = validation_errors();
            } else {

                $pedido_existe = false;
            	if(!empty($dados['id_pedido'])){
                    $p = $this->GetAll($dados['id_pedido']);
                    if(!empty($p)){
                        $pedido_existe = true;
                    }
                }
                
                $this->db->trans_begin();
                if(empty($pedido_existe)){
                    $this->db->insert('pedido',array('data'=>date('Y-m-d h:i:s')));
                    $dados['id_pedido'] = $this->db->insert_id();  
                }

            	if($personalizacao == true){
        			$dados_personalizacao['descricao'] 	= $dados['personalizacao_descricao'];
        			$dados_personalizacao['valor'] 		= $dados['personalizacao_valor'];
        			$dados_personalizacao['tempo'] 		= $dados['personalizacao_tempo'];
            		unset($dados['personalizacao_descricao']);
            		unset($dados['personalizacao_valor']);
            		unset($dados['personalizacao_tempo']);
            	}

                $this->db->insert('item',$dados);
               
                if(!empty($personalizacao)){
                	$dados_personalizacao['id_item'] = $this->db->insert_id();  
               		$this->db->insert('personalizacao',$dados_personalizacao);
                }

            
                if ($this->db->trans_status() === TRUE){
                    $response['status'] = true;
                    $response['message'] = "Pedido criado com sucesso.";
                    $response['id_pedido'] = $dados['id_pedido'];
                    $this->db->trans_commit();
                }else{
                	$response['status'] = false;
                    $response['message'] = $this->db->error_message();
                    $response['id_pedido'] = NULL;
                	$this->db->trans_rollback();
                }

            }
        }

        return $response;
    }


    public function Update($id, $dados)
    {
        if (!isset($dados)) {
            $response['status'] = false;
            $response['message'] = "Dados não informados.";
        } else {
            
            $this->form_validation->set_data($dados);
            
            $this->form_validation->set_rules('quantidade','','required',array('required' => 'Quantidade não informada.'));

            if ($this->form_validation->run() === false) {
                $response['status'] = false;
                $response['message'] = validation_errors();

            } else {
            	$this->db->trans_begin();
                $this->db->where("id",$id)->update('item', $dados);

                 if ($this->db->trans_status() === TRUE){
                    $response['status'] = true;
                    $response['message'] = "Pedido atualizado com sucesso.";
                    $this->db->trans_commit();
                } else {
                    $response['status'] = false;
                    $response['message'] = $this->db->error_message();
                    $this->db->trans_rollback();
                }
            }
        }
       
        return $response;
    }


    public function Delete($id){

        	$this->db->trans_begin();
            $this->db->where("id", $id)->delete('pedido');

            if ($this->db->trans_status() === TRUE){
                $response['status'] = true;
                $response['message'] = "Pedido removido com sucesso.";
                $this->db->trans_commit();
            } else {
                $response['status'] = false;
                $response['message'] = $this->db->error_message();
                $this->db->trans_rollback();
            }
        
        return $response;
    }
}