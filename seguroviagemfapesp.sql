-- Adminer 4.8.1 MySQL 8.0.34 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `app_autoridade`;
CREATE TABLE `app_autoridade` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `numero` varchar(100) NOT NULL,
  `label` varchar(300) NOT NULL,
  `icone` varchar(100) DEFAULT 'fa-shield-alt',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `order_by` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_autoridade` (`id`, `numero`, `label`, `icone`, `status`, `order_by`) VALUES
(1,	'+10 anos',	'atendendo bolsistas FAPESP, CAPES e CNPq',	'fa-calendar-check',	1,	1),
(2,	'100%',	'de aprovação nas prestações de contas (0 apólices recusadas)',	'fa-check-circle',	1,	1),
(3,	'SUSEP',	'Corretor licenciado - Superintendência de Seguros Privados',	'fa-shield-alt',	1,	1);

DROP TABLE IF EXISTS `app_banners`;
CREATE TABLE `app_banners` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `subtitle` text,
  `cta_text` varchar(200) DEFAULT 'Falar com especialista',
  `cta_link` varchar(500) DEFAULT NULL,
  `cta_secondary_text` varchar(200) DEFAULT 'Entender o que a FAPESP exige',
  `cta_secondary_link` varchar(500) DEFAULT '#requisitos',
  `image` varchar(255) DEFAULT NULL,
  `image_mobile` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `order_by` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_banners` (`id`, `title`, `subtitle`, `cta_text`, `cta_link`, `cta_secondary_text`, `cta_secondary_link`, `image`, `image_mobile`, `status`, `order_by`, `created_at`) VALUES
(1,	'Seguro Viagem FAPESP',	'Especialistas no seguro obrigatório para bolsistas FAPESP.\r\nSua apólice correta, do embarque à prestação de contas.',	'Falar com especialista',	'#whatsapp',	'Entender o que a FAPESP exige',	'#requisitos',	'81bccc452f1b828d476669d81856a1b1.png',	'def52b5da13ab53eeeee18242fdedf4c.png',	1,	1,	'2026-03-21 11:53:42');

DROP TABLE IF EXISTS `app_configuracoes`;
CREATE TABLE `app_configuracoes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `chave` varchar(100) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `valor` text,
  `tipo` enum('text','textarea','image','html') DEFAULT 'text',
  `grupo` varchar(100) DEFAULT 'geral',
  `order_by` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `chave` (`chave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_configuracoes` (`id`, `chave`, `titulo`, `valor`, `tipo`, `grupo`, `order_by`) VALUES
(1,	'hero_titulo',	'Título do Hero (H1)',	'Seguro Viagem FAPESP',	'text',	'hero',	1),
(2,	'hero_subtitulo',	'Subtítulo do Hero',	'Especialistas no seguro obrigatório para bolsistas FAPESP.\nSua apólice correta, do embarque à prestação de contas.',	'textarea',	'hero',	2),
(3,	'hero_selo_1',	'Selo Hero 1',	'Corretor SUSEP',	'text',	'hero',	3),
(4,	'hero_selo_2',	'Selo Hero 2',	'+10 anos',	'text',	'hero',	4),
(5,	'hero_selo_3',	'Selo Hero 3',	'100% aprovação',	'text',	'hero',	5),
(6,	'secao3_titulo',	'Título Seção Requisitos',	'O que a FAPESP Realmente Exige do Seu Seguro Viagem',	'text',	'secao3',	10),
(7,	'secao3_texto',	'Texto Seção Requisitos',	'A FAPESP exige a contratação de um seguro saúde internacional para todos os bolsistas e pesquisadores que se deslocam ao exterior com recursos da Fundação. Diferente de seguros turísticos comuns, o seguro para bolsistas FAPESP deve atender a critérios específicos que, se não cumpridos, podem comprometer a liberação de outras parcelas da bolsa ou a prestação de contas.\n\nA vigência do seguro deve cobrir todo o período de permanência no exterior, do dia do embarque ao dia do retorno ao Brasil, sem lacunas. As coberturas essenciais incluem assistência médica e hospitalar por acidente ou doença, repatriação sanitária e funerária, e traslado médico — requisitos que vão além de um seguro turístico convencional.\n\nA apólice deve ser emitida em nome do bolsista ou pesquisador titular da bolsa, e o recibo de pagamento deve conter o número do processo FAPESP. Essa é uma exigência técnica fundamental para a aprovação da prestação de contas no sistema SAGe. Sem essa informação, o reembolso pode ser negado ou exigir correções burocráticas que atrasam o recebimento.\n\nAlém disso, o comprovante de pagamento deve discriminar o valor pago — motivo pelo qual seguros gratuitos de cartão de crédito não são aceitos. A FAPESP precisa ver claramente o quanto foi investido para calcular o reembolso dentro do limite da tabela vigente.\n\nPor fim, para bolsistas que viajam a países signatários do Tratado de Schengen (maioria da Europa), o seguro deve atender também às exigências consulares, com cobertura mínima de €30.000 para despesas médicas. Nossos planos já contemplam esse requisito automaticamente.\n\nBolsistas das modalidades BEPE (Bolsa Estágio de Pesquisa no Exterior), BPE (Bolsa Pesquisa no Exterior) e Reuniões Científicas têm exigências idênticas quanto ao seguro viagem. A diferença está no tempo de cobertura e no valor máximo de reembolso. Contar com uma corretora especializada em seguro para bolsistas FAPESP elimina o risco de erros documentais — algo especialmente crítico para pesquisadores que precisam focar em sua pesquisa, não em burocracia.',	'html',	'secao3',	11),
(8,	'secao4_titulo',	'Título Seção Cartão',	'Por que o Seguro do Cartão de Crédito NÃO Serve para a FAPESP',	'text',	'secao4',	20),
(9,	'secao6_titulo',	'Título Seção Processo',	'Nosso Processo em 3 Etapas',	'text',	'secao6',	30),
(10,	'secao6_etapa1_titulo',	'Etapa 1 - Título',	'Assessoria Pré-Embarque',	'text',	'secao6',	31),
(11,	'secao6_etapa1_texto',	'Etapa 1 - Texto',	'Escolhemos juntos o plano ideal, garantimos que a apólice tenha as exigências da FAPESP e do destino e revisamos os documentos antes do envio.',	'textarea',	'secao6',	32),
(12,	'secao6_etapa2_titulo',	'Etapa 2 - Título',	'Suporte Durante a Viagem',	'text',	'secao6',	33),
(13,	'secao6_etapa2_texto',	'Etapa 2 - Texto',	'Passou mal? Mala extraviada? Uma central de emergência com atendimento em português estará disponível 24hs. Sem robô — basta nos chamar no WhatsApp.',	'textarea',	'secao6',	34),
(14,	'secao6_etapa3_titulo',	'Etapa 3 - Título',	'Revisão da Prestação de Contas',	'text',	'secao6',	35),
(15,	'secao6_etapa3_texto',	'Etapa 3 - Texto',	'Ao voltar, revisamos sua documentação para garantir que o reembolso seja processado sem erros ou pendências.',	'textarea',	'secao6',	36),
(16,	'cta_final_titulo',	'CTA Final - Título',	'Sua bolsa foi aprovada. Agora garanta que seu seguro também seja.',	'text',	'cta',	40),
(17,	'cta_final_subtitulo',	'CTA Final - Subtítulo',	'Você foca na sua pesquisa — nós cuidamos da burocracia.',	'text',	'cta',	41),
(18,	'cta_final_botao',	'CTA Final - Texto Botão',	'Falar com um especialista em Seguro FAPESP',	'text',	'cta',	42),
(19,	'whatsapp_numero',	'WhatsApp - Número',	'+5554999974120',	'text',	'contato',	50),
(20,	'whatsapp_mensagem',	'WhatsApp - Mensagem Pré-preenchida',	'Olá, tenho uma bolsa FAPESP e preciso de orientação sobre o seguro viagem',	'text',	'contato',	51),
(21,	'email_contato',	'E-mail de Contato',	'',	'text',	'contato',	52),
(22,	'telefone_contato',	'Telefone de Contato',	'',	'text',	'contato',	53),
(23,	'exemplo_calculo',	'Exemplo Cálculo Valores',	'BEPE de 6 meses = R$ 10.080,00 de reembolso (6 x R$ 1.680,00). Se o seguro custar mais, o excedente é do bolsista. Se custar menos, a FAPESP reembolsa o valor exato do recibo.',	'textarea',	'valores',	60);

DROP TABLE IF EXISTS `app_depoimentos`;
CREATE TABLE `app_depoimentos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `modalidade` varchar(300) DEFAULT NULL,
  `universidade` varchar(300) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `texto` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `nota` tinyint DEFAULT '5',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `order_by` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_depoimentos` (`id`, `nome`, `modalidade`, `universidade`, `pais`, `texto`, `image`, `nota`, `status`, `order_by`, `created_at`) VALUES
(1,	'Ana Carolina M.',	'Bolsista BEPE — Doutorado',	'Universidade de Leiden',	'Holanda',	'Estava preocupada com a burocracia do seguro, mas com a assessoria da Otripulante, minha apólice teve o número do processo correto e minha prestação de contas foi aprovada sem nenhuma pendência. Atendimento excepcional!',	NULL,	5,	1,	1,	'2026-03-21 11:53:42'),
(2,	'Rafael S.',	'Bolsista BPE — Pós-Doutorado',	'Universidade de Lisboa',	'Portugal',	'A equipe entende perfeitamente o que a FAPESP solicita. Fechei meu seguro em poucos minutos, com coberturas completas e suporte sempre disponível. Viajando com segurança e tranquilidade!',	NULL,	5,	1,	1,	'2026-03-21 11:53:42'),
(3,	'Beatriz C.',	'Bolsista BEPE — Mestrado',	'MIT',	'Estados Unidos',	'Optei pela Otripulante por indicação de colegas e foi a melhor escolha. O seguro atendeu todas as exigências da FAPESP e quando tive um imprevisto médico em Boston, me atenderam pelo WhatsApp na hora. Recomendo de olhos fechados!',	NULL,	5,	1,	1,	'2026-03-21 11:53:42');

DROP TABLE IF EXISTS `app_faq`;
CREATE TABLE `app_faq` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pergunta` varchar(500) NOT NULL,
  `resposta` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `order_by` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_faq` (`id`, `pergunta`, `resposta`, `status`, `order_by`) VALUES
(1,	'O seguro do cartão de crédito serve para a FAPESP?',	'Geralmente não. A FAPESP exige um comprovante de pagamento (recibo) com valor discriminado e o seguro do cartão é um benefício gratuito, o que dificulta a prestação de contas. Além disso, não cobre períodos longos de permanência no exterior (meses de bolsa), funciona basicamente por reembolso e é impossível incluir o número do processo FAPESP — exigência técnica da prestação de contas.',	1,	1),
(2,	'Posso contratar um seguro local no país de destino?',	'Sim, desde que o recibo seja conversível em Reais e apresente as coberturas mínimas exigidas. No entanto, o seguro deve estar ativo desde a saída do Brasil, o que complica a logística. Recomendamos contratar no Brasil com corretor licenciado para evitar problemas na prestação de contas.',	1,	1),
(3,	'O que acontece se eu prorrogar minha estadia no exterior?',	'Você deve contratar um endosso (extensão) do seguro e submeter o novo comprovante à FAPESP imediatamente. Nossa equipe auxilia em todo o processo de extensão para que não haja lacuna na cobertura.',	1,	1),
(4,	'Qual a diferença entre Seguro Viagem e Seguro Saúde para a FAPESP?',	'No Brasil, o Seguro Viagem já inclui obrigatoriamente coberturas de despesas médicas, hospitalares e odontológicas (Resolução SUSEP 315/2014). Ele também cobre repatriação sanitária e funerária — exigência das agências de fomento. Por isso, o Seguro Viagem é a solução completa exigida pela FAPESP.',	1,	1),
(5,	'Posso parcelar o pagamento do seguro?',	'O pagamento deve ser feito pelo bolsista e a FAPESP reembolsa o valor. Não é permitido parcelamento se o objetivo for o reembolso integral imediato via Reserva Técnica. Consulte nossos especialistas para entender a melhor forma de pagamento para sua situação.',	1,	1),
(6,	'O número do processo FAPESP precisa estar na apólice?',	'Sim. A documentação deve incluir o número do processo FAPESP no corpo do documento ou no recibo. Nossa equipe garante que essa informação seja incluída corretamente, evitando problemas na prestação de contas.',	1,	1),
(7,	'Qual o prazo para contratar o seguro antes do embarque?',	'Recomendamos contratar assim que a bolsa for aprovada, pois a cobertura deve ser válida desde o dia do embarque. Quanto antes contratar, mais opções de planos e valores você terá disponível.',	1,	1),
(8,	'A FAPESP indica alguma seguradora específica?',	'A FAPESP não indica empresas específicas. Porém, a Otripulante Seguro Viagem é uma das poucas corretoras com Corretor de Seguros licenciado pela SUSEP que trabalha com as principais seguradoras de viagem do Brasil, garantindo que a apólice atenda todas as exigências técnicas.',	1,	1);

DROP TABLE IF EXISTS `app_leads`;
CREATE TABLE `app_leads` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `modalidade_bolsa` varchar(200) DEFAULT NULL,
  `pais_destino` varchar(200) DEFAULT NULL,
  `duracao` varchar(100) DEFAULT NULL,
  `mensagem` text,
  `origem` varchar(100) DEFAULT 'landing-page',
  `status` enum('novo','em_atendimento','convertido','descartado') NOT NULL DEFAULT 'novo',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_leads` (`id`, `nome`, `email`, `telefone`, `modalidade_bolsa`, `pais_destino`, `duracao`, `mensagem`, `origem`, `status`, `created_at`, `updated_at`) VALUES
(1,	'Tiago Ferreira',	'tiago@fcode.com.br',	'54999974120',	'BEPE - Pós-Doutorado',	'',	'',	'',	'landing-page',	'em_atendimento',	'2026-03-31 10:42:01',	'2026-03-31 08:38:03');

DROP TABLE IF EXISTS `app_seguradoras`;
CREATE TABLE `app_seguradoras` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `order_by` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_seguradoras` (`id`, `nome`, `image`, `link`, `status`, `order_by`) VALUES
(1,	'Coris Seguro Viagem',	'coris.png',	'https://www.coris.com.br',	1,	1),
(2,	'Assist Card',	'assist-card.png',	'https://www.assistcard.com/br',	1,	2),
(3,	'MTA Seguro Viagem',	'mta.png',	'https://www.mta.com.br',	1,	3),
(4,	'Universal Assistance',	'universal-assistance.png',	'https://www.universal-assistance.com',	1,	4);

DROP TABLE IF EXISTS `app_valores`;
CREATE TABLE `app_valores` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `modalidade` varchar(500) NOT NULL,
  `valor_atual` varchar(100) NOT NULL DEFAULT 'R$ 1.680,00',
  `valor_atual_label` varchar(200) DEFAULT 'A partir de 01/09/2025',
  `valor_anterior` varchar(100) DEFAULT 'R$ 1.560,00',
  `valor_anterior_label` varchar(200) DEFAULT '01/06/2022 a 31/08/2025',
  `unidade` varchar(100) DEFAULT '/ mês ou fração',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `order_by` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_valores` (`id`, `modalidade`, `valor_atual`, `valor_atual_label`, `valor_anterior`, `valor_anterior_label`, `unidade`, `status`, `order_by`) VALUES
(1,	'Viagens ao exterior (Pesquisa, BEPE, BPE, Reuniões Científicas etc.)',	'R$ 1.680,00',	'A partir de 01/09/2025',	'R$ 1.560,00',	'01/06/2022 a 31/08/2025',	'/ mês ou fração',	1,	1),
(2,	'Dependente — Bolsa de Pesquisa no Exterior (BPE)',	'R$ 1.680,00',	'A partir de 01/09/2025',	'R$ 1.560,00',	'01/06/2022 a 31/08/2025',	'/ mês ou fração',	1,	1);

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('h6358dd0jtus7n37vtq0batr9vsdi3h8',	'::1',	1774304102,	'__ci_last_regenerate|i:1774304031;'),
('fd8pu0m2q1hfflnisqfu33n2vdlgjfhu',	'::1',	1774305276,	'__ci_last_regenerate|i:1774305276;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8889\";b:1;}'),
('vdrohqpdduhj06b6qfgi3en5raga7rev',	'::1',	1774305660,	'__ci_last_regenerate|i:1774305660;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8889\";b:1;}'),
('csbqvfg6rpioj8jhjoc6iu7ij2h9tk9p',	'::1',	1774305382,	'__ci_last_regenerate|i:1774305382;'),
('sng6bpk060u5lc1l70o57hrc4ecvigtl',	'::1',	1774305566,	'__ci_last_regenerate|i:1774305566;'),
('sbtcrueihq4es95vo91tba1vgeosc3ll',	'::1',	1774305589,	'__ci_last_regenerate|i:1774305589;'),
('pkqekepqrul98tejj571b5khtnah7rea',	'::1',	1774305589,	'__ci_last_regenerate|i:1774305589;'),
('3touai6c2lf1hmbq1hsn1ai3aas326to',	'::1',	1774306057,	'__ci_last_regenerate|i:1774306057;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8889\";b:1;}'),
('7vnjq54mjd63tuv4jnll17i4otbp1jju',	'::1',	1774305919,	'__ci_last_regenerate|i:1774305919;'),
('vmmc5ac2trn9ofr5tph7v511r0pb2rio',	'::1',	1774306073,	'__ci_last_regenerate|i:1774306057;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8889\";b:1;}'),
('pg0n6rsjingg6krq59j7npqpoerqjtb5',	'::1',	1774311720,	'__ci_last_regenerate|i:1774311720;'),
('n656plo5t1ctthjckdhgrfio6ikqnmtv',	'::1',	1774311753,	'__ci_last_regenerate|i:1774311730;'),
('qeq8hlrp02onl6gdumvghhi52rj0pk39',	'::1',	1774894015,	'__ci_last_regenerate|i:1774894015;'),
('b3i61gul44hqb5n83elivs4ehfjiqju8',	'::1',	1774894634,	'__ci_last_regenerate|i:1774894634;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('v25glvf8vbbvru9ed9un7hc4k6ii3i3o',	'::1',	1774894147,	'__ci_last_regenerate|i:1774894147;'),
('dlge9gdjavelopf4vbm563bf2btmk210',	'::1',	1774894176,	'__ci_last_regenerate|i:1774894176;'),
('ge5k34jf16c1l5lch8e0aak8mv8ogn6f',	'::1',	1774894941,	'__ci_last_regenerate|i:1774894941;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('k2pvg7fd5qrgjbfguelu6dlgdup0iar7',	'::1',	1774898109,	'__ci_last_regenerate|i:1774898109;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('tkuvag0d0lq9h1v1uqq5soa3gjol4iqg',	'::1',	1774898446,	'__ci_last_regenerate|i:1774898446;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('d8i7q5822lkchk7i59ts583d9u9lcqrs',	'::1',	1774898864,	'__ci_last_regenerate|i:1774898864;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('86t1dd43hflt31msngsmrgel7b5dljko',	'::1',	1774903385,	'__ci_last_regenerate|i:1774903385;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('nf9v67meb3prllg7ue82i8dei65thu8s',	'::1',	1774903703,	'__ci_last_regenerate|i:1774903703;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('lknfkenbggaph4c19sgnvl8n5ul6oks6',	'::1',	1774904017,	'__ci_last_regenerate|i:1774904017;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('d6dhc9ufpfqvlfmj6no2ggdqv7e1ud2s',	'::1',	1774904336,	'__ci_last_regenerate|i:1774904336;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('daab4guvsk86e8f1rfs2su4rs266h67t',	'::1',	1774907894,	'__ci_last_regenerate|i:1774907894;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('vtum845h7ulcnblgumn02sf5ne3tmmc3',	'::1',	1774908225,	'__ci_last_regenerate|i:1774908225;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('h5h3tiu5jqfku8a6p6elg128jldmtnbk',	'::1',	1774909019,	'__ci_last_regenerate|i:1774909019;user_data|s:0:\"\";svfapesp_admin_session|a:0:{}'),
('uq731e0r7585n14hm8s0sqqqmhd1mn1f',	'::1',	1774909071,	'__ci_last_regenerate|i:1774909019;user_data|s:0:\"\";svfapesp_admin_session|a:0:{}'),
('jhofst9i8eohp9nu5n180blo9e3cib12',	'::1',	1774954922,	'__ci_last_regenerate|i:1774954922;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:13:\"Administrador\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";N;s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-23 22:13:19\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('fkmiso23teoj1d8n70krc68je1jv48lp',	'::1',	1774955324,	'__ci_last_regenerate|i:1774955324;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:14:\"Tiago Ferreira\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";s:36:\"08e7f8b9a3746cb774008a460939d621.png\";s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-31 08:05:25\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('r7dtv4osugbhal2fudevha922mirvr14',	'::1',	1774955646,	'__ci_last_regenerate|i:1774955646;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:14:\"Tiago Ferreira\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";s:36:\"7ab170edd39504646f46740e49004952.png\";s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:9:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-31 08:10:29\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('hm4qprddks7uhn4po2k2e1gk4et8t2ac',	'::1',	1774955992,	'__ci_last_regenerate|i:1774955992;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:14:\"Tiago Ferreira\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";s:36:\"7ab170edd39504646f46740e49004952.png\";s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:10:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:10;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-31 08:10:29\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('gvf7tutj8r3n52faghb7m24ei08estic',	'::1',	1774956347,	'__ci_last_regenerate|i:1774956347;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:14:\"Tiago Ferreira\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";s:36:\"7ab170edd39504646f46740e49004952.png\";s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:10:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:10;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-31 11:23:28\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('0e23tld8k7maepbvpkatnb1mjif1u72g',	'::1',	1774956777,	'__ci_last_regenerate|i:1774956777;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:14:\"Tiago Ferreira\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";s:36:\"7ab170edd39504646f46740e49004952.png\";s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:10:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:10;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-31 11:23:28\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('2c5l7e8mr0t08io4j83o44pa23ppt4t6',	'::1',	1774957080,	'__ci_last_regenerate|i:1774957080;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:14:\"Tiago Ferreira\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";s:36:\"7ab170edd39504646f46740e49004952.png\";s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:10:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:10;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-31 11:23:28\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('o8rjiisa1357uekt07olulroe7ia0292',	'::1',	1774957402,	'__ci_last_regenerate|i:1774957402;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:14:\"Tiago Ferreira\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";s:36:\"7ab170edd39504646f46740e49004952.png\";s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:10:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:10;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-31 11:23:28\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('6u178jjg6rs8k8o59gphhsaa72v9ipgb',	'::1',	1774958099,	'__ci_last_regenerate|i:1774958099;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:14:\"Tiago Ferreira\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";s:36:\"7ab170edd39504646f46740e49004952.png\";s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:10:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:10;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-31 11:23:28\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('3lq5dpe59i80ea283nlfvk8q3r00t4bn',	'::1',	1774964474,	'__ci_last_regenerate|i:1774964474;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:14:\"Tiago Ferreira\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";s:36:\"7ab170edd39504646f46740e49004952.png\";s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:10:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:10;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-31 11:23:28\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}'),
('vege2asg32vuot5n88i6k9ge1isc3k07',	'::1',	1774964639,	'__ci_last_regenerate|i:1774964474;user_data|O:8:\"stdClass\":14:{s:2:\"id\";s:1:\"1\";s:8:\"id_grupo\";s:1:\"1\";s:10:\"id_company\";s:1:\"1\";s:4:\"nome\";s:14:\"Tiago Ferreira\";s:7:\"usuario\";s:18:\"admin@fcode.com.br\";s:5:\"email\";s:18:\"admin@fcode.com.br\";s:8:\"password\";s:60:\"$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK\";s:5:\"image\";s:36:\"7ab170edd39504646f46740e49004952.png\";s:6:\"status\";s:1:\"1\";s:6:\"online\";s:1:\"0\";s:11:\"permissions\";a:10:{i:1;a:1:{i:0;s:10:\"visualizar\";}i:2;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:3;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:4;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:5;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:6;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:7;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:8;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:9;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}i:10;a:4:{i:0;s:10:\"visualizar\";i:1;s:9:\"cadastrar\";i:2;s:6:\"editar\";i:3;s:7:\"excluir\";}}s:10:\"created_at\";s:19:\"2026-03-21 11:53:42\";s:10:\"updated_at\";s:19:\"2026-03-31 11:23:28\";s:5:\"grupo\";s:13:\"Administrador\";}svfapesp_admin_session|a:1:{s:14:\"localhost:8000\";b:1;}');

DROP TABLE IF EXISTS `si_company`;
CREATE TABLE `si_company` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fantasy_name` varchar(255) NOT NULL DEFAULT 'Otripulante Seguro Viagem',
  `slug` varchar(255) DEFAULT 'otripulante',
  `domain` varchar(255) DEFAULT 'seguroviagemfapesp.com',
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `active_site` tinyint(1) NOT NULL DEFAULT '1',
  `language_main` int unsigned DEFAULT '1',
  `languages_site` varchar(50) DEFAULT '1',
  `phone` varchar(50) DEFAULT NULL,
  `whatsapp` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT 'São Paulo',
  `state` varchar(2) DEFAULT 'SP',
  `zipcode` varchar(15) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT 'Seguro Viagem FAPESP para Bolsistas | Otripulante Seguro Viagem',
  `meta_description` text,
  `meta_keywords` varchar(500) DEFAULT NULL,
  `meta_webmaster` varchar(255) DEFAULT NULL,
  `google_analytics` text,
  `facebook_pixel` text,
  `whatsapp_message` varchar(500) DEFAULT 'Olá, tenho uma bolsa FAPESP e preciso de orientação sobre o seguro viagem',
  `susep_registro` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_company` (`id`, `fantasy_name`, `slug`, `domain`, `image`, `status`, `active_site`, `language_main`, `languages_site`, `phone`, `whatsapp`, `email`, `address`, `number`, `district`, `city`, `state`, `zipcode`, `facebook`, `instagram`, `linkedin`, `youtube`, `twitter`, `meta_title`, `meta_description`, `meta_keywords`, `meta_webmaster`, `google_analytics`, `facebook_pixel`, `whatsapp_message`, `susep_registro`) VALUES
(1,	'Otripulante Seguro Viagem',	'otripulante',	'seguroviagemfapesp.com',	NULL,	1,	1,	1,	'1',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'São Paulo',	'SP',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Seguro Viagem FAPESP para Bolsistas | Otripulante Seguro Viagem',	'Seguro viagem obrigatório para bolsistas FAPESP (BEPE, BPE e Reuniões Científicas). Corretor licenciado SUSEP. Apólice com número do processo, cobertura mínima garantida e suporte na prestação de contas. Consulte agora.',	'seguro viagem FAPESP, seguro viagem obrigatório bolsista FAPESP, requisitos seguro FAPESP, BEPE seguro viagem, valor reembolso FAPESP 2026',	NULL,	NULL,	NULL,	'Olá, tenho uma bolsa FAPESP e preciso de orientação sobre o seguro viagem',	NULL);

DROP TABLE IF EXISTS `si_groups`;
CREATE TABLE `si_groups` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `permissions` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_groups` (`id`, `name`, `permissions`, `status`) VALUES
(1,	'Administrador',	'{\"1\": [\"visualizar\"], \"2\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"3\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"4\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"5\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"6\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"7\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"8\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"9\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"10\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"]}',	1);

DROP TABLE IF EXISTS `si_language`;
CREATE TABLE `si_language` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL DEFAULT 'pt',
  `name` varchar(100) NOT NULL DEFAULT 'Português',
  `directory` varchar(100) NOT NULL DEFAULT 'portuguese-br',
  `site` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `lc_time_names` varchar(20) NOT NULL DEFAULT 'pt_BR',
  `time_zone` varchar(10) NOT NULL DEFAULT '-03:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_language` (`id`, `code`, `name`, `directory`, `site`, `status`, `lc_time_names`, `time_zone`) VALUES
(1,	'pt',	'Português',	'portuguese-br',	1,	1,	'pt_BR',	'-03:00');

DROP TABLE IF EXISTS `si_logs`;
CREATE TABLE `si_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int unsigned DEFAULT NULL,
  `description` text,
  `auth` text,
  `session` text,
  `server` text,
  `data` text,
  `module` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `method` varchar(100) DEFAULT NULL,
  `post` text,
  `get` text,
  `ip` varchar(45) DEFAULT NULL,
  `system` varchar(50) DEFAULT 'admin',
  `type` varchar(50) DEFAULT 'general',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `si_modules`;
CREATE TABLE `si_modules` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `icon` varchar(100) DEFAULT 'flaticon-381-notepad',
  `parent_id` int unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `show_in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `order_by` int NOT NULL DEFAULT '0',
  `system` varchar(50) DEFAULT 'admin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_modules` (`id`, `slug`, `name`, `icon`, `parent_id`, `status`, `show_in_menu`, `order_by`, `system`) VALUES
(1,	'home',	'Dashboard',	'flaticon-381-home-2',	NULL,	1,	1,	0,	'admin'),
(2,	'banners',	'Banners / Hero',	'flaticon-381-picture',	NULL,	1,	1,	2,	'admin'),
(3,	'autoridade',	'Números de Autoridade',	'flaticon-381-star',	NULL,	1,	1,	3,	'admin'),
(4,	'seguradoras',	'Seguradoras Parceiras',	'flaticon-381-earth-globe',	NULL,	1,	1,	4,	'admin'),
(5,	'valores',	'Tabela de Valores',	'flaticon-381-price-tag',	NULL,	1,	1,	5,	'admin'),
(6,	'depoimentos',	'Depoimentos',	'flaticon-381-like',	NULL,	1,	1,	6,	'admin'),
(7,	'faq',	'Perguntas Frequentes',	'flaticon-381-help',	NULL,	1,	1,	7,	'admin'),
(8,	'leads',	'Leads / Contatos',	'flaticon-381-user-9',	NULL,	1,	1,	8,	'admin'),
(9,	'configuracoes',	'Configurações do Site',	'flaticon-381-settings-2',	NULL,	1,	1,	9,	'admin'),
(10,	'administration/users',	'Usuários',	'fas fa-users',	NULL,	1,	1,	10,	'admin');

DROP TABLE IF EXISTS `si_users`;
CREATE TABLE `si_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_grupo` int unsigned DEFAULT '1',
  `id_company` int unsigned DEFAULT '1',
  `nome` varchar(200) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `permissions` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_users` (`id`, `id_grupo`, `id_company`, `nome`, `usuario`, `email`, `password`, `image`, `status`, `online`, `permissions`, `created_at`, `updated_at`) VALUES
(1,	1,	1,	'Tiago Ferreira',	'admin@fcode.com.br',	'admin@fcode.com.br',	'$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK',	'7ab170edd39504646f46740e49004952.png',	1,	0,	'{\"1\": [\"visualizar\"], \"2\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"3\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"4\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"5\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"6\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"7\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"8\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"9\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"], \"10\": [\"visualizar\", \"cadastrar\", \"editar\", \"excluir\"]}',	'2026-03-21 11:53:42',	'2026-03-31 11:23:28'),
(2,	1,	1,	'Nicolas Aguiar',	'nicolas@otripulante.com',	'nicolas@otripulante.com',	'$2a$12$.wphapvZP5ki6cLPOk8EFOF9Zdg8WpYRx9zqg.XVl/iYVVz2gFNam',	'5b1580eb4281f4f89661b30aa1fa3ffa.png',	1,	0,	'{\"1\":[\"visualizar\"],\"2\":[\"visualizar\",\"cadastrar\",\"editar\",\"excluir\"],\"3\":[\"visualizar\",\"cadastrar\",\"editar\",\"excluir\"],\"4\":[\"visualizar\",\"cadastrar\",\"editar\",\"excluir\"],\"5\":[\"visualizar\",\"cadastrar\",\"editar\",\"excluir\"],\"6\":[\"visualizar\",\"cadastrar\",\"editar\",\"excluir\"],\"7\":[\"visualizar\",\"cadastrar\",\"editar\",\"excluir\"],\"8\":[\"visualizar\",\"cadastrar\",\"editar\",\"excluir\"],\"9\":[\"visualizar\",\"cadastrar\",\"editar\",\"excluir\"],\"10\":[\"visualizar\",\"cadastrar\",\"editar\",\"excluir\"]}',	'2026-03-31 08:45:42',	'2026-03-31 08:48:17');

-- 2026-03-31 13:46:00
