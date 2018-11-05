# codeigniter-api-rest
Projeto de api usando restful server 


Listar todos os pedidos GET - http://url-onde-o-projeto-esta/pedidos

Listar um pedido GET - http://url-onde-o-projeto-esta/pedidos/id_pedido

Cadastrar um pedido POST - http://url-onde-o-projeto-esta/pedidos

json: {	
"tamanho":"Grande",
"tamanho_tempo":"10",
"sabor":"Marguerita",
"sabor_tempo":"0",
"sabor_valor":"0",
"tamanho_valor":"40,50",
"personalizacao_descricao":"Extra Bacon",
"personalizacao_valor":"3,00",
"personalizacao_tempo":"5"
}

Alterar quantidade do item no pedido PUT - http://url-onde-o-projeto-esta/pedidos/id_item 
json: { "quantidade":"2" }

Remover pedido DELETE - http://url-onde-o-projeto-esta/id_pedido

Configurar banco de dados
\pasta-do-projeto\application\config\database.php

Pasta onde o arquivo do banco está
\pasta-do-projeto\db
