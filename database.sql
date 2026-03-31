-- =====================================================
-- Seguro Viagem FAPESP - Database Schema
-- Framework: CodeIgniter 3 + HMVC (Fcode)
-- =====================================================

-- Banco: seguroviagemfapesp (LOCAL)
-- Host: 127.0.0.1 | User: root | Pass: fcode@2019
USE `seguroviagemfapesp`;

-- -----------------------------------------------------
-- TABELAS DO SISTEMA (si_)
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `si_language` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NOT NULL DEFAULT 'pt',
  `name` VARCHAR(100) NOT NULL DEFAULT 'Português',
  `directory` VARCHAR(100) NOT NULL DEFAULT 'portuguese-br',
  `site` TINYINT(1) NOT NULL DEFAULT 1,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `lc_time_names` VARCHAR(20) NOT NULL DEFAULT 'pt_BR',
  `time_zone` VARCHAR(10) NOT NULL DEFAULT '-03:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `si_language` (`id`, `code`, `name`, `directory`, `site`, `status`, `lc_time_names`, `time_zone`) VALUES
(1, 'pt', 'Português', 'portuguese-br', 1, 1, 'pt_BR', '-03:00');

-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `si_company` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fantasy_name` VARCHAR(255) NOT NULL DEFAULT 'Otripulante Seguro Viagem',
  `slug` VARCHAR(255) DEFAULT 'otripulante',
  `domain` VARCHAR(255) DEFAULT 'seguroviagemfapesp.com',
  `image` VARCHAR(255) DEFAULT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `active_site` TINYINT(1) NOT NULL DEFAULT 1,
  `language_main` INT UNSIGNED DEFAULT 1,
  `languages_site` VARCHAR(50) DEFAULT '1',
  `phone` VARCHAR(50) DEFAULT NULL,
  `whatsapp` VARCHAR(50) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `number` VARCHAR(20) DEFAULT NULL,
  `district` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT 'São Paulo',
  `state` VARCHAR(2) DEFAULT 'SP',
  `zipcode` VARCHAR(15) DEFAULT NULL,
  `facebook` VARCHAR(255) DEFAULT NULL,
  `instagram` VARCHAR(255) DEFAULT NULL,
  `linkedin` VARCHAR(255) DEFAULT NULL,
  `youtube` VARCHAR(255) DEFAULT NULL,
  `twitter` VARCHAR(255) DEFAULT NULL,
  `meta_title` VARCHAR(255) DEFAULT 'Seguro Viagem FAPESP para Bolsistas | Otripulante Seguro Viagem',
  `meta_description` TEXT DEFAULT NULL,
  `meta_keywords` VARCHAR(500) DEFAULT NULL,
  `meta_webmaster` VARCHAR(255) DEFAULT NULL,
  `google_analytics` TEXT DEFAULT NULL,
  `facebook_pixel` TEXT DEFAULT NULL,
  `whatsapp_message` VARCHAR(500) DEFAULT 'Olá, tenho uma bolsa FAPESP e preciso de orientação sobre o seguro viagem',
  `susep_registro` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `si_company` (`id`, `fantasy_name`, `slug`, `domain`, `phone`, `whatsapp`, `email`, `city`, `state`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
(1, 'Otripulante Seguro Viagem', 'otripulante', 'seguroviagemfapesp.com', NULL, NULL, NULL, 'São Paulo', 'SP',
 'Seguro Viagem FAPESP para Bolsistas | Otripulante Seguro Viagem',
 'Seguro viagem obrigatório para bolsistas FAPESP (BEPE, BPE e Reuniões Científicas). Corretor licenciado SUSEP. Apólice com número do processo, cobertura mínima garantida e suporte na prestação de contas. Consulte agora.',
 'seguro viagem FAPESP, seguro viagem obrigatório bolsista FAPESP, requisitos seguro FAPESP, BEPE seguro viagem, valor reembolso FAPESP 2026');

-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `si_groups` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `permissions` TEXT DEFAULT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `si_groups` (`id`, `name`, `permissions`) VALUES
(1, 'Administrador', NULL);

-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `si_users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_grupo` INT UNSIGNED DEFAULT 1,
  `id_company` INT UNSIGNED DEFAULT 1,
  `nome` VARCHAR(200) NOT NULL,
  `usuario` VARCHAR(100) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `online` TINYINT(1) NOT NULL DEFAULT 0,
  `permissions` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Senha padrão: T!L17m26m2 (hash phpass/bcrypt)
INSERT INTO `si_users` (`id`, `nome`, `usuario`, `email`, `password`, `id_grupo`, `id_company`, `status`) VALUES
(1, 'Administrador', 'admin@fcode.com.br', 'admin@fcode.com.br', '$2a$08$USgKxsQHwlHXx9apjD4lGuJJVzlaM/aiprfTCDR26yBgxrvA4fOHK', 1, 1, 1);

-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `si_modules` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(200) NOT NULL,
  `name` VARCHAR(200) NOT NULL,
  `icon` VARCHAR(100) DEFAULT 'flaticon-381-notepad',
  `parent_id` INT UNSIGNED DEFAULT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `show_in_menu` TINYINT(1) NOT NULL DEFAULT 1,
  `order_by` INT NOT NULL DEFAULT 0,
  `system` VARCHAR(50) DEFAULT 'admin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `si_modules` (`id`, `slug`, `name`, `icon`, `order_by`, `show_in_menu`) VALUES
(1, 'home', 'Dashboard', 'flaticon-381-home-2', 1, 0),
(2, 'banners', 'Banners / Hero', 'flaticon-381-picture', 2, 1),
(3, 'autoridade', 'Números de Autoridade', 'flaticon-381-star', 3, 1),
(4, 'seguradoras', 'Seguradoras Parceiras', 'flaticon-381-shield', 4, 1),
(5, 'valores', 'Tabela de Valores', 'flaticon-381-price-tag', 5, 1),
(6, 'depoimentos', 'Depoimentos', 'flaticon-381-quote-1', 6, 1),
(7, 'faq', 'Perguntas Frequentes', 'flaticon-381-help', 7, 1),
(8, 'leads', 'Leads / Contatos', 'flaticon-381-user-9', 8, 1),
(9, 'configuracoes', 'Configurações do Site', 'flaticon-381-settings-2', 9, 1);

-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `si_logs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` INT UNSIGNED DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `auth` TEXT DEFAULT NULL,
  `session` TEXT DEFAULT NULL,
  `server` TEXT DEFAULT NULL,
  `data` TEXT DEFAULT NULL,
  `module` VARCHAR(100) DEFAULT NULL,
  `class` VARCHAR(100) DEFAULT NULL,
  `method` VARCHAR(100) DEFAULT NULL,
  `post` TEXT DEFAULT NULL,
  `get` TEXT DEFAULT NULL,
  `ip` VARCHAR(45) DEFAULT NULL,
  `system` VARCHAR(50) DEFAULT 'admin',
  `type` VARCHAR(50) DEFAULT 'general',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` VARCHAR(128) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `timestamp` INT UNSIGNED DEFAULT 0 NOT NULL,
  `data` BLOB NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =====================================================
-- TABELAS DA APLICAÇÃO (app_)
-- =====================================================

-- S1 - Hero / Banners
CREATE TABLE IF NOT EXISTS `app_banners` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(500) DEFAULT NULL,
  `subtitle` TEXT DEFAULT NULL,
  `cta_text` VARCHAR(200) DEFAULT 'Falar com especialista',
  `cta_link` VARCHAR(500) DEFAULT NULL,
  `cta_secondary_text` VARCHAR(200) DEFAULT 'Entender o que a FAPESP exige',
  `cta_secondary_link` VARCHAR(500) DEFAULT '#requisitos',
  `image` VARCHAR(255) DEFAULT NULL,
  `image_mobile` VARCHAR(255) DEFAULT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `order_by` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `app_banners` (`title`, `subtitle`, `cta_text`, `cta_link`, `cta_secondary_text`, `cta_secondary_link`, `status`, `order_by`) VALUES
('Seguro Viagem FAPESP', 'Especialistas no seguro obrigatório para bolsistas FAPESP.\nSua apólice correta, do embarque à prestação de contas.', 'Falar com especialista', '#whatsapp', 'Entender o que a FAPESP exige', '#requisitos', 1, 1);

-- S2 - Números de Autoridade
CREATE TABLE IF NOT EXISTS `app_autoridade` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero` VARCHAR(100) NOT NULL,
  `label` VARCHAR(300) NOT NULL,
  `icone` VARCHAR(100) DEFAULT 'fa-shield-alt',
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `order_by` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `app_autoridade` (`numero`, `label`, `icone`, `order_by`) VALUES
('+10 anos', 'atendendo bolsistas FAPESP, CAPES e CNPq', 'fa-calendar-check', 1),
('100%', 'de aprovação nas prestações de contas (0 apólices recusadas)', 'fa-check-circle', 2),
('SUSEP', 'Corretor licenciado - Superintendência de Seguros Privados', 'fa-shield-alt', 3);

-- Seguradoras Parceiras (logos)
CREATE TABLE IF NOT EXISTS `app_seguradoras` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `link` VARCHAR(500) DEFAULT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `order_by` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- S5 - Tabela de Valores FAPESP 2026
CREATE TABLE IF NOT EXISTS `app_valores` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `modalidade` VARCHAR(500) NOT NULL,
  `valor_atual` VARCHAR(100) NOT NULL DEFAULT 'R$ 1.680,00',
  `valor_atual_label` VARCHAR(200) DEFAULT 'A partir de 01/09/2025',
  `valor_anterior` VARCHAR(100) DEFAULT 'R$ 1.560,00',
  `valor_anterior_label` VARCHAR(200) DEFAULT '01/06/2022 a 31/08/2025',
  `unidade` VARCHAR(100) DEFAULT '/ mês ou fração',
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `order_by` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `app_valores` (`modalidade`, `valor_atual`, `valor_anterior`, `order_by`) VALUES
('Viagens ao exterior (Pesquisa, BEPE, BPE, Reuniões Científicas etc.)', 'R$ 1.680,00', 'R$ 1.560,00', 1),
('Dependente — Bolsa de Pesquisa no Exterior (BPE)', 'R$ 1.680,00', 'R$ 1.560,00', 2);

-- S7 - Depoimentos de Bolsistas
CREATE TABLE IF NOT EXISTS `app_depoimentos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `modalidade` VARCHAR(300) DEFAULT NULL,
  `universidade` VARCHAR(300) DEFAULT NULL,
  `pais` VARCHAR(100) DEFAULT NULL,
  `texto` TEXT NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `nota` TINYINT DEFAULT 5,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `order_by` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `app_depoimentos` (`nome`, `modalidade`, `universidade`, `pais`, `texto`, `nota`, `order_by`) VALUES
('Ana Carolina M.', 'Bolsista BEPE — Doutorado', 'Universidade de Leiden', 'Holanda', 'Estava preocupada com a burocracia do seguro, mas com a assessoria da Otripulante, minha apólice teve o número do processo correto e minha prestação de contas foi aprovada sem nenhuma pendência. Atendimento excepcional!', 5, 1),
('Rafael S.', 'Bolsista BPE — Pós-Doutorado', 'Universidade de Lisboa', 'Portugal', 'A equipe entende perfeitamente o que a FAPESP solicita. Fechei meu seguro em poucos minutos, com coberturas completas e suporte sempre disponível. Viajando com segurança e tranquilidade!', 5, 2),
('Beatriz C.', 'Bolsista BEPE — Mestrado', 'MIT', 'Estados Unidos', 'Optei pela Otripulante por indicação de colegas e foi a melhor escolha. O seguro atendeu todas as exigências da FAPESP e quando tive um imprevisto médico em Boston, me atenderam pelo WhatsApp na hora. Recomendo de olhos fechados!', 5, 3);

-- S8 - FAQ - Perguntas Frequentes
CREATE TABLE IF NOT EXISTS `app_faq` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pergunta` VARCHAR(500) NOT NULL,
  `resposta` TEXT NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `order_by` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `app_faq` (`pergunta`, `resposta`, `order_by`) VALUES
('O seguro do cartão de crédito serve para a FAPESP?', 'Geralmente não. A FAPESP exige um comprovante de pagamento (recibo) com valor discriminado e o seguro do cartão é um benefício gratuito, o que dificulta a prestação de contas. Além disso, não cobre períodos longos de permanência no exterior (meses de bolsa), funciona basicamente por reembolso e é impossível incluir o número do processo FAPESP — exigência técnica da prestação de contas.', 1),
('Posso contratar um seguro local no país de destino?', 'Sim, desde que o recibo seja conversível em Reais e apresente as coberturas mínimas exigidas. No entanto, o seguro deve estar ativo desde a saída do Brasil, o que complica a logística. Recomendamos contratar no Brasil com corretor licenciado para evitar problemas na prestação de contas.', 2),
('O que acontece se eu prorrogar minha estadia no exterior?', 'Você deve contratar um endosso (extensão) do seguro e submeter o novo comprovante à FAPESP imediatamente. Nossa equipe auxilia em todo o processo de extensão para que não haja lacuna na cobertura.', 3),
('Qual a diferença entre Seguro Viagem e Seguro Saúde para a FAPESP?', 'No Brasil, o Seguro Viagem já inclui obrigatoriamente coberturas de despesas médicas, hospitalares e odontológicas (Resolução SUSEP 315/2014). Ele também cobre repatriação sanitária e funerária — exigência das agências de fomento. Por isso, o Seguro Viagem é a solução completa exigida pela FAPESP.', 4),
('Posso parcelar o pagamento do seguro?', 'O pagamento deve ser feito pelo bolsista e a FAPESP reembolsa o valor. Não é permitido parcelamento se o objetivo for o reembolso integral imediato via Reserva Técnica. Consulte nossos especialistas para entender a melhor forma de pagamento para sua situação.', 5),
('O número do processo FAPESP precisa estar na apólice?', 'Sim. A documentação deve incluir o número do processo FAPESP no corpo do documento ou no recibo. Nossa equipe garante que essa informação seja incluída corretamente, evitando problemas na prestação de contas.', 6),
('Qual o prazo para contratar o seguro antes do embarque?', 'Recomendamos contratar assim que a bolsa for aprovada, pois a cobertura deve ser válida desde o dia do embarque. Quanto antes contratar, mais opções de planos e valores você terá disponível.', 7),
('A FAPESP indica alguma seguradora específica?', 'A FAPESP não indica empresas específicas. Porém, a Otripulante Seguro Viagem é uma das poucas corretoras com Corretor de Seguros licenciado pela SUSEP que trabalha com as principais seguradoras de viagem do Brasil, garantindo que a apólice atenda todas as exigências técnicas.', 8);

-- S9 - Leads (captura de e-mail e WhatsApp)
CREATE TABLE IF NOT EXISTS `app_leads` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) DEFAULT NULL,
  `email` VARCHAR(300) DEFAULT NULL,
  `telefone` VARCHAR(50) DEFAULT NULL,
  `modalidade_bolsa` VARCHAR(200) DEFAULT NULL,
  `pais_destino` VARCHAR(200) DEFAULT NULL,
  `duracao` VARCHAR(100) DEFAULT NULL,
  `mensagem` TEXT DEFAULT NULL,
  `origem` VARCHAR(100) DEFAULT 'landing-page',
  `status` ENUM('novo','em_atendimento','convertido','descartado') NOT NULL DEFAULT 'novo',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Configurações editáveis do site
CREATE TABLE IF NOT EXISTS `app_configuracoes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `chave` VARCHAR(100) NOT NULL,
  `titulo` VARCHAR(200) NOT NULL,
  `valor` TEXT DEFAULT NULL,
  `tipo` ENUM('text','textarea','image','html') DEFAULT 'text',
  `grupo` VARCHAR(100) DEFAULT 'geral',
  `order_by` INT DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chave` (`chave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `app_configuracoes` (`chave`, `titulo`, `valor`, `tipo`, `grupo`, `order_by`) VALUES
('hero_titulo', 'Título do Hero (H1)', 'Seguro Viagem FAPESP', 'text', 'hero', 1),
('hero_subtitulo', 'Subtítulo do Hero', 'Especialistas no seguro obrigatório para bolsistas FAPESP.\nSua apólice correta, do embarque à prestação de contas.', 'textarea', 'hero', 2),
('hero_selo_1', 'Selo Hero 1', 'Corretor SUSEP', 'text', 'hero', 3),
('hero_selo_2', 'Selo Hero 2', '+10 anos', 'text', 'hero', 4),
('hero_selo_3', 'Selo Hero 3', '100% aprovação', 'text', 'hero', 5),
('secao3_titulo', 'Título Seção Requisitos', 'O que a FAPESP Realmente Exige do Seu Seguro Viagem', 'text', 'secao3', 10),
('secao3_texto', 'Texto Seção Requisitos', 'A FAPESP exige a contratação de um seguro saúde internacional para todos os bolsistas e pesquisadores que se deslocam ao exterior com recursos da Fundação. Diferente de seguros turísticos comuns, o seguro para bolsistas FAPESP deve atender a critérios específicos que, se não cumpridos, podem comprometer a liberação de outras parcelas da bolsa ou a prestação de contas.\n\nA vigência do seguro deve cobrir todo o período de permanência no exterior, do dia do embarque ao dia do retorno ao Brasil, sem lacunas. As coberturas essenciais incluem assistência médica e hospitalar por acidente ou doença, repatriação sanitária e funerária, e traslado médico — requisitos que vão além de um seguro turístico convencional.\n\nA apólice deve ser emitida em nome do bolsista ou pesquisador titular da bolsa, e o recibo de pagamento deve conter o número do processo FAPESP. Essa é uma exigência técnica fundamental para a aprovação da prestação de contas no sistema SAGe. Sem essa informação, o reembolso pode ser negado ou exigir correções burocráticas que atrasam o recebimento.\n\nAlém disso, o comprovante de pagamento deve discriminar o valor pago — motivo pelo qual seguros gratuitos de cartão de crédito não são aceitos. A FAPESP precisa ver claramente o quanto foi investido para calcular o reembolso dentro do limite da tabela vigente.\n\nPor fim, para bolsistas que viajam a países signatários do Tratado de Schengen (maioria da Europa), o seguro deve atender também às exigências consulares, com cobertura mínima de €30.000 para despesas médicas. Nossos planos já contemplam esse requisito automaticamente.', 'html', 'secao3', 11),
('secao4_titulo', 'Título Seção Cartão', 'Por que o Seguro do Cartão de Crédito NÃO Serve para a FAPESP', 'text', 'secao4', 20),
('secao6_titulo', 'Título Seção Processo', 'Nosso Processo em 3 Etapas', 'text', 'secao6', 30),
('secao6_etapa1_titulo', 'Etapa 1 - Título', 'Assessoria Pré-Embarque', 'text', 'secao6', 31),
('secao6_etapa1_texto', 'Etapa 1 - Texto', 'Escolhemos juntos o plano ideal, garantimos que a apólice tenha as exigências da FAPESP e do destino e revisamos os documentos antes do envio.', 'textarea', 'secao6', 32),
('secao6_etapa2_titulo', 'Etapa 2 - Título', 'Suporte Durante a Viagem', 'text', 'secao6', 33),
('secao6_etapa2_texto', 'Etapa 2 - Texto', 'Passou mal? Mala extraviada? Uma central de emergência com atendimento em português estará disponível 24hs. Sem robô — basta nos chamar no WhatsApp.', 'textarea', 'secao6', 34),
('secao6_etapa3_titulo', 'Etapa 3 - Título', 'Revisão da Prestação de Contas', 'text', 'secao6', 35),
('secao6_etapa3_texto', 'Etapa 3 - Texto', 'Ao voltar, revisamos sua documentação para garantir que o reembolso seja processado sem erros ou pendências.', 'textarea', 'secao6', 36),
('cta_final_titulo', 'CTA Final - Título', 'Sua bolsa foi aprovada. Agora garanta que seu seguro também seja.', 'text', 'cta', 40),
('cta_final_subtitulo', 'CTA Final - Subtítulo', 'Você foca na sua pesquisa — nós cuidamos da burocracia.', 'text', 'cta', 41),
('cta_final_botao', 'CTA Final - Texto Botão', 'Falar com um especialista em Seguro FAPESP', 'text', 'cta', 42),
('whatsapp_numero', 'WhatsApp - Número', '', 'text', 'contato', 50),
('whatsapp_mensagem', 'WhatsApp - Mensagem Pré-preenchida', 'Olá, tenho uma bolsa FAPESP e preciso de orientação sobre o seguro viagem', 'text', 'contato', 51),
('email_contato', 'E-mail de Contato', '', 'text', 'contato', 52),
('telefone_contato', 'Telefone de Contato', '', 'text', 'contato', 53),
('exemplo_calculo', 'Exemplo Cálculo Valores', 'BEPE de 6 meses = R$ 10.080,00 de reembolso (6 x R$ 1.680,00). Se o seguro custar mais, o excedente é do bolsista. Se custar menos, a FAPESP reembolsa o valor exato do recibo.', 'textarea', 'valores', 60);
