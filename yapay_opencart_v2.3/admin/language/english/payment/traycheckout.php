<?php
// Heading
$_['heading_title']       		= 'Yapay Intermediador';

// Text
$_['text_payment']        		= 'Pagamento';
$_['text_success']        		= 'Módulo Yapay Intermediador atualizado com sucesso!';
$_['text_traycheckout'] 		= '<a onclick="window.open(\'http://www.traycheckout.com.br/\');"><img src="view/image/payment/traycheckout.gif" alt="Yapay Intermediador" title="Yapay Intermediador" style="border: 1px solid #EEEEEE;" /></a>';

// Entry
$_['entry_token']         		= 'Token:';
$_['entry_suffix']         		= 'Sufixo para o número do pedido:';
$_['entry_order_pending'] 		= 'Status Aguardando Pagamento:';
$_['entry_order_processing'] 	= 'Status Processando:';
$_['entry_order_cancel'] 		= 'Status Cancelado:';
$_['entry_order_failed'] 		= 'Status Não Aprovado:';
$_['entry_order_processed'] 	= 'Status Processado (APROVADO):';
$_['entry_order_process_alert'] = '<br /><b>Atenção ao selecionar o status "Processado", pois é a partir dele que o Yapay Intermediador confirma o pagamento da transação e o produto/serviço pode ser enviado ao cliente.</b>';
$_['entry_geo_zone']      		= 'Região geográfica:';
$_['entry_status']        		= 'Habilitar módulo Yapay Intermediador:';
$_['entry_sort_order']    		= 'Ordenação:';
$_['entry_update_status_alert'] = 'Notificar alteração de status:';
$_['entry_sandbox_attention'] 	= '<h2>Atenção ao Habilitar o Ambiente de Teste (SANDBOX) </h2>';
$_['entry_sandbox'] 			= 'Habilitar Ambiente de Teste (SANDBOX):';

// Help
$_['help_token']         		= 'Chave de acesso ou token utilizado para identificar a loja';
$_['help_suffix']         		= 'Utilizar quando existir várias lojas na mesma conta Yapay Intermediador, com este campo é possível evitar conflito de pedidos com o mesmo número.';
$_['help_order_pending'] 		= 'Status quando a loja aguarda o primeiro retorno da confirmação da transação pelo Yapay Intermediador';
$_['help_order_processing'] 	= 'O Yapay Intermediador recebeu a transação e está aguardando o pagamento (boleto) ou analisando o pagamento realizado.';
$_['help_order_cancel'] 		= 'A transação foi cancelada no Yapay Intermediador, pode ser por pagamento estornado, negado ou por causa de chargeback.';
$_['help_order_failed'] 		= 'Por qualquer motivo a transação não foi aprovada.';
$_['help_order_processed'] 	    = 'A transação foi processada com sucesso, passou por análise e o pagamento foi aprovado.';
$_['help_order_process_alert']  = 'Atenção ao selecionar o status "Processado", pois é a partir dele que o Yapay Intermediador confirma o pagamento da transação e o produto/serviço pode ser enviado ao cliente.';
$_['help_update_status_alert']  = 'Notifica o cliente por email sobre as alterações no status do pedido.';
$_['help_sandbox_attention'] 	= 'Você ainda não poderá aceitar pagamentos. Será necessário criar uma conta no site sandbox Yapay Intermediador (<a href="https://sandbox.traycheckout.com.br" target="_blank">https://sandbox.traycheckout.com.br</a>). Será necessário voltar à página do módulo Yapay Intermediador para configurar com os dados corretos antes de disponibilizar sua loja no ar.';
$_['help_sandbox'] 		    	= 'Atenção! Ativar esta opção apenas na fase de testes de sua loja.';

// Error
$_['error_permission']    		= 'Atenção: Você não possui permissão para modificar o pagamento Yapay Intermediador!';
$_['error_token']         		= 'Digite a Chave de Acesso';
$_['error_email']         		= 'Digite o e-mail cadastrado no Yapay Intermediador';
?>