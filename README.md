# OpenCart


Para disponibilizar a Yapay como facilitador de pagamento na plataforma OpenCart, basta baixar o pacote disponível no site institucional da Yapay, extrair a pasta com o módulo e enviar para sua loja.

Fique atento que sua versão de instalação OpenCart deve ser compatível com o módulo Yapay. As versões compatíveis são mostradas na pagina de download do módulo.

> Nosso módulo do OpenCart está disponível apenas até a versão 2.3.X

> 1- Instalação do Módulo OpenCart

Para instalar o módulo é necessário baixar o pacote através do link:

<a href="http://integracao.traycheckout.com.br/documentacao/download/yapay/opencart/yapay_opencart_v2.1.zip" class="btnMagento"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i>OpenCart</a>

Descompacte o arquivo baixado e copie a pasta para o diretório raiz de sua instalação OpenCart, caso o sistema exiba a mensagem de mesclagem ou substituição de arquivos, clique em sim para todos.

Passos para instalação via FTP, utilizando o Filezilla:

1. Enviar o conteúdo da pasta extraída para o servidor da loja virtual, utilizando um software FTP (neste exemplo utilizamos o Filezilla)

2. Ao efetuar a conexão no FTP, no lado direito serão mostradas as pastas que estão dentro do servidor, acesse a pasta que está sua loja OpenCart

3. Enviar as pastas extraídas (**admin** e **catalog**) do módulo Yapay para a pasta opencart, ou na raiz caso a instalação de sua loja esteja no webroot

Cuidado para não arrastar em cima de uma pasta, se isso acontecer você terá uma pasta dentro da outra e então este módulo não funcionará.

![OpenCart, instalação](https://intermediador.dev.yapay.com.br//images/opencart/install_opencart_1.png "OpenCart, instalação")

Segue a visualização dos diretórios da instalação OpenCart:

![OpenCart, instalação](https://intermediador.dev.yapay.com.br//images/opencart/install_opencart_2.png "OpenCart, instalação")

Após a conclusão do envio do módulo Yapay, acesse a administração do Opencart e entre na seção de “Formas de Pagamento” do menu Extensões.

Procurar pelo módulo “Yapay”, ele já deverá ser listado na consulta em Extension

![OpenCart, instalação](https://intermediador.dev.yapay.com.br//images/opencart/opencart_install(extension).png "OpenCart, instalação")

Será mostrado o módulo conforme a imagem abaixo. Clicar no botão **install** ou **instalar** (caso sua loja já esteja traduzida) no lado direito da listagem:

![OpenCart, instalação](https://intermediador.dev.yapay.com.br//images/opencart/opencart_install(install2).png "OpenCart, instalação")

Após a instalação, será necessário habilitar e inserir dados de cadastro de sua conta para liberar os pagamentos em sua conta Yapay.

> 2- Configuração os campos necessários do Checkout do OpenCart

Está disponivel na versão 2.x criar campos customizados para o checkout. Nesse caso você precisará criar o campo `CPF`, `numero` e `complemento`.

Acessando o seu painel administrador do OpenCart, selecione a opção `Customer > Custom Fields`, clique para adicionar um novo campo customizável.

**CPF**

| Nome do Campo     |  Valor Recomendado |
|-------------------|--------------------|
| Custom Field Name | CPF (Obrigatório)  |
| Location          | Account            |
| Type              | Text               |
| Customer Group    | Default            |
| Required          | Default            |
| Status            | Enabled            |
| Sort Order        | 3                  |


**NÚMERO**

| Nome do Campo     |  Valor Recomendado   |
|-------------------|----------------------|
| Custom Field Name | Número (Obrigatório) |
| Location          | Address            |
| Type              | Text               |
| Customer Group    | Default            |
| Required          | Opcional           |
| Status            | Opcional           |
| Sort Order        | 2                  |


**COMPLEMENTO**

| Nome do Campo     |  Valor Recomendado   |
|-------------------|----------------------|
| Custom Field Name | Complemento          |
| Location          | Address            |
| Type              | Text               |
| Customer Group    | Default            |
| Required          | Opcional           |
| Status            | Opcional           |
| Sort Order        | 3                  |


> 3- Configuração do Módulo OpenCart


Na página de **Formas de Pagamento**, clique em **Edit (Editar)** para acessar o módulo Yapay.

Será carregada a página do módulo com as opções de configuração abaixo:

![OpenCart, instalação](https://intermediador.dev.yapay.com.br//images/opencart/opencart-config.png "OpenCart, instalação")


> Opções de configuração Yapay:


**Token:** campo obrigatório gerado no painel de administração Yapay

**Sufixo para o nº do pedido:** campo opcional, utilizado para concatenar com o número do pedido da loja ao integrar com a Yapay

**Habilitar módulo Yapay:** opção para habilitar/desabilitar o módulo na loja

**Ambiente de Teste (Sandbox):** ambiente utilizado pela loja para realizar testes de integração com o Yapay – muita atenção para não manter este ambiente habilitado quando a loja estiver efetivamente vendendo

**Notificar alteração de status:** campo utilizado para ativar/desativar a notificação de email para o cliente sobre as alterações de status

**Região geográfica:** restrição a regiões configuradas para sua loja OpenCart

**Ordenação:** opção para ordenar os módulos de pagamento habilitados

Por padrão, a OpenCart tem vários status para os pedidos, para trabalhar com o Yapay existem 5 que deverão ser selecionados conforme abaixo:

**Status Processando:** status posterior ao “aguardando pagamento”, indica que Yapay já recebeu o pedido e está processando

**Status Processado:** status que indica a aprovação do pedido, a partir deste status o produto/serviço deve ser enviado ou liberado para o cliente. É a confirmação do pagamento. Muita atenção para não trocar com o status PROCESSANDO

**Status Cancelado:** status que indica o cancelamento, reprovação ou não pagamento da transação no Yapay

**Status Não Aprovado:** status que indica que o pedido não obteve êxito no pagamento, por exemplo, um cartão expirado ou inválido
