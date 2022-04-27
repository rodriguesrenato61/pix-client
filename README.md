# pix-client
### Aplicação cliente para o módulo pix que estou a desenvolver.

Para utilização do módulo pix envie um email para rodriguesrenato61@gmail.com solicitando a criação de um usuário de acesso ao módulo e caso apresente algum erro, problema ou bug na aplicação.
Para realização de testes clique no menu Api e realize o cadastro das credenciais de acesso a api pix, por enquanto só funciona com a Gerencianet.

![credenciais](https://github.com/rodriguesrenato61/pix-client/blob/main/prints/tela_credenciais.png)

O webhook só vai funcionar se as credenciais cadastradas forem do ambiente de produção.
Logo após o cadastro das credenciais é necessário o cadastro de uma aplicação, para isso vá no menu Aplicações depois clique em novo, ao cadastrar marque os recebedores aptos a criar transações nessa aplicação e guarde seu id (número que antecede o nome do recebedor). Além disso guarde o nome, código api e chave api cadastrados.

![cadastro_aplicacao](https://github.com/rodriguesrenato61/pix-client/blob/main/prints/cadastrar_aplicacao.png)

Para testar a criação de um pix, clique no menu Teste e realize a criação de um pix, o pix só poderá ser pago se as credenciais cadastradas forem credenciais de produção, recomendo criar pix com valores baixos de 1, 2 ou 3 centavos, caso algum erro aconteça enviar um email informando.

![cria_pix_teste](https://github.com/rodriguesrenato61/pix-client/blob/main/prints/cria_pix_teste.png)

Após pagar o pix clique em Consultar Pix para verificar se ele está pago, ou pegar o seu txid pelo console do navegador e realizar a sua pesquisa no menu Home, depois em filtros e filtrar pelo txid. Status ATIVA(não pago) e CONCLUIDA(pago).

![cria_pix_teste_2](https://github.com/rodriguesrenato61/pix-client/blob/main/prints/cria_pix_teste_2.png)

![transacoes](https://github.com/rodriguesrenato61/pix-client/blob/main/prints/transacoes.png)

### Para instalação do pix-client siga os passos

1 - Necessita de autoload para funcionamento dos namespaces, utilize o cmd na pasta do projeto e coloque o seguinte comando para que o composer baixe as dependências: composer dump-autoload -o

2 - Instale o banco que está no arquivo banco.sql, é necessário cadastrar o nome, código api e chave api da aplicação criada no módulo na tabela pix_aplicacao com o id 1. Além disso também cadastrar o id e nome do recebedor habilitado na tabela pix_recebedores.  

3 - No arquivo config.php encontra-se as variáveis de ambiente da aplicação, faça as modificações de acordo com a instalação feita na sua máquina.

![config](https://github.com/rodriguesrenato61/pix-client/blob/main/prints/config.png)

![cria_pix_1](https://github.com/rodriguesrenato61/pix-client/blob/main/prints/cria-pix_1.png)

![cria_pix_2](https://github.com/rodriguesrenato61/pix-client/blob/main/prints/cria_pix_2.png)


