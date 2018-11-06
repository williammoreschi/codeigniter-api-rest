<?
defined('BASEPATH') OR exit('No direct script access allowed');
class Pedidos_model extends CI_Model {

    public function GetAll($id=NULL){
        $this->db->select("*");
        if(!empty($id)){
            $this->db->where('id',$id);
        }
        $this->db->from('pedido');
        $this->db->order_by('id','DESC');
        return $this->db->get()->result_array();
    }

    public function GetById($id){
        return $this->GetAll($id);
    }

    public function Insert($dados) {

        $status = true;
        $mensagem = NULL;
        $novo_pedido = array();
        $descricao_personaliza = null;
        $preparo_personaliza = 0;
        $valor_personaliza = 0;
        $id_pedido = NULL;

        if (!isset($dados)) {
            $status = false;
            $mensagem .= "Dados não informados.";
        } else {
            $tamanho[0] = array("id"=>"1","descricao"=>"Pequena","valor"=>"20.00","preparo"=>"15");
            $tamanho[1] = array("id"=>"2","descricao"=>"Média","valor"=>"30.00","preparo"=>"20");
            $tamanho[2] = array("id"=>"3","descricao"=>"Grande","valor"=>"40.00","preparo"=>"25");

            $sabor[0] = array("id"=>"1","descricao"=>"Calabresa","preparo"=>"0");
            $sabor[1] = array("id"=>"2","descricao"=>"Marguerita","preparo"=>"0");
            $sabor[2] = array("id"=>"3","descricao"=>"Portuguesa","preparo"=>"5");

            $personalizacao[0] = array("id"=>1,"descricao"=>"Extra Bacon","valor"=>"3.00","preparo"=>"0");
            $personalizacao[1] = array("id"=>2,"descricao"=>"Sem Cebola","valor"=>"0.00","preparo"=>"0");
            $personalizacao[2] = array("id"=>3,"descricao"=>"Borda Recheada","valor"=>"5.00","preparo"=>"5");


            if(!empty($dados['tamanho']) && array_search($dados['tamanho'], array_column($tamanho, 'id')) !== false){
                $ponteiro = array_search($dados['tamanho'], array_column($tamanho, 'id'));
                $novo_pedido = array(
                    "tamanho"=>$tamanho[$ponteiro]['descricao'],
                    "total"=>$tamanho[$ponteiro]['valor'],
                    "preparo"=>$tamanho[$ponteiro]['preparo']
                );

                $novo_pedido['tamanho'] = $tamanho[$ponteiro]['descricao'];
                $novo_pedido['total'] = $tamanho[$ponteiro]['valor'];
                $novo_pedido['preparo'] = $tamanho[$ponteiro]['preparo'];


            }else{
                $status = false;
                $mensagem .= "O tamanho da pizza não informado, ou não está disponivel no momento";
            }

            if(!empty($status)){
                if(!empty($dados['sabor']) && array_search($dados['sabor'], array_column($sabor, 'id')) !== false){
                    $ponteiro = array_search($dados['sabor'], array_column($sabor, 'id'));
                    $preparo = $novo_pedido['preparo']+$sabor[$ponteiro]['preparo'];

                    $novo_pedido['sabor']   = $sabor[$ponteiro]['descricao'];
                    $novo_pedido['preparo'] = $preparo;
                }else{
                    $status = false;
                    $mensagem .= "O sabor da pizza não informado, ou não está disponivel no momento";
                }
            }

            if(!empty($status)){
                if(!empty($dados['personaliza'])){
                    if(is_array($dados['personaliza'])){
                        foreach ($dados['personaliza'] as $key => $value) {
                            if(!empty($value) && array_search($value, array_column($personalizacao, 'id')) !== false){
                                $ponteiro = array_search($value, array_column($personalizacao, 'id'));
                                $descricao_personaliza .= $personalizacao[$ponteiro]['descricao']." - R$".$personalizacao[$ponteiro]['valor']."\n";
                                $preparo_personaliza += $personalizacao[$ponteiro]['preparo'];
                                $valor_personaliza += $personalizacao[$ponteiro]['valor'];
                            }else{
                                $status = false;
                                $mensagem .= "Uma ou mais personalização não existe.";
                                break;
                            }
                        }
                        if(!empty($status)){

                            $preparo = $novo_pedido['preparo']+$preparo_personaliza;
                            $total = $novo_pedido['total']+$valor_personaliza;

                            $novo_pedido['personalizacao'] = $descricao_personaliza;
                            $novo_pedido['total'] = $total;
                            $novo_pedido['preparo'] = $preparo;
                        }
                    }else{
                        $status = false;
                        $mensagem .= "Uma ou mais personalização não existe...";
                    }
                }
            }

            if(!empty($status)){

                $this->db->insert('pedido',$novo_pedido);

                if ($this->db->affected_rows()){
                    $mensagem   = "Pedido criado com sucesso.";
                    $id_pedido  = $this->db->insert_id();
                }else{
                    $status = false;
                    $mensagem = $mensagem;
                    $id_pedido = NULL;
                }

            }
        }

        $response['status'] = $status;
        $response['mensagem'] = $mensagem;
        if(!empty($id_pedido)){
            $response['id_pedido'] = $id_pedido;
        }
        return $response;
    }

    public function Update($id,$dados){
        $response['status'] = false;
        $response['mensagem'] = "O método não foi implementado";
        return $response;
    }

    public function Delete($id){

        $pedido = $this->GetAll($id);

        if(!empty($pedido)){
            $this->db->where("id", $id)->delete('pedido');
            if ($this->db->affected_rows()){
                $status = true;
                $mensagem   = "Pedido removido com sucesso.";
            }else{
                $status = false;
                $mensagem = "Ouve um erro ao tentar remover o pedido.";
            }
        }else{
            $status = false;
            $mensagem = "O pedido ja tinha sido removido.";
        }

        $response['status'] = $status;
        $response['mensagem'] = $mensagem;
        return $response;
    }
}