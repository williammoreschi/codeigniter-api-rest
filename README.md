# codeigniter-api-rest
Projeto de api usando Biblioteca - restful server (https://github.com/chriskacerguis/codeigniter-restserver)


Listar todos os pedidos GET - http://url-onde-o-projeto-esta/pedidos

Listar um pedido GET - http://url-onde-o-projeto-esta/pedidos/id_pedido

Cadastrar um pedido POST - http://url-onde-o-projeto-esta/pedidos

{"tamanho":"1","sabor":1}

{"tamanho":"1","sabor":2}

{"tamanho":"1","sabor":3}

{"tamanho":"2","sabor":1}

{"tamanho":"2","sabor":2}

{"tamanho":"2","sabor":3}

{"tamanho":"3","sabor":1}

{"tamanho":"3","sabor":2}

{"tamanho":"3","sabor":3}

{"tamanho":"1","sabor":3,"personaliza":{"0":1}}

{"tamanho":"1","sabor":3,"personaliza":{"0":1,"1":2}}

{"tamanho":"1","sabor":3,"personaliza":{"0":1,"1":2,"2":3}}


Remover pedido DELETE - http://url-onde-o-projeto-esta/id_pedido

Configurar banco de dados
\pasta-do-projeto\application\config\database.php

Pasta onde o arquivo do banco está
\pasta-do-projeto\db
