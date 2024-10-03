-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/10/2024 às 04:35
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vanguard`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `avaliacao_id` int(11) NOT NULL,
  `pontos` int(5) DEFAULT NULL,
  `texto` varchar(45) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `cidade_id` int(11) NOT NULL,
  `nome_cidade` varchar(100) NOT NULL,
  `estado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `cidades`
--

INSERT INTO `cidades` (`cidade_id`, `nome_cidade`, `estado_id`) VALUES
(1, 'Guarapuava', 1),
(2, 'Pato Branco', 1),
(3, 'Ponta Grossa', 1),
(4, 'Curitiba', 1),
(5, 'São Caetano do Sul', 2),
(6, 'São Paulo', 2),
(7, 'São José dos Campos', 2),
(8, 'Jundiaí', 2),
(9, 'Florianópolis', 3),
(10, 'Joinville', 3),
(11, 'Chapecó', 3),
(12, 'Blumenau', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `estado`
--

CREATE TABLE `estado` (
  `estado_id` int(11) NOT NULL,
  `nome_estado` varchar(100) NOT NULL,
  `uf` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `estado`
--

INSERT INTO `estado` (`estado_id`, `nome_estado`, `uf`) VALUES
(1, 'Paraná', 'PR'),
(2, 'São Paulo', 'SP'),
(3, 'Santa Catarina', 'SC');

-- --------------------------------------------------------

--
-- Estrutura para tabela `plano`
--

CREATE TABLE `plano` (
  `plano_id` int(11) NOT NULL,
  `nome_plano` varchar(150) NOT NULL,
  `preco_plano` decimal(3,2) NOT NULL,
  `tempo` date NOT NULL,
  `produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `produto_id` int(11) NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `plano_id` int(11) NOT NULL,
  `classe` varchar(20) NOT NULL,
  `descricao` text NOT NULL,
  `imagem` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`produto_id`, `nome_produto`, `plano_id`, `classe`, `descricao`, `imagem`) VALUES
(1, 'Backbox', 500, 'Sistema Operacional', ' uma distribuição GNU/Linux derivada do Ubuntu, voltada para executar testes de penetração e de vulnerabilidade, o sistema dispõe de várias ferramentas para análise de sistemas e de redes.', 0x6261636b626f782e706e67),
(2, 'Black Arch', 500, 'Sistema Operacional', 'uma distribuição Linux para testes de penetração e pesquisadores de segurança. É uma derivação do ArchLinux e os usuários podem instalar componentes do BlackArch individualmente ou por grupos em cima da distribuição.', 0x426c61636b417263682e706e67),
(3, 'Kali', 500, 'Sistema Operacional', 'uma distribuição GNU/Linux baseada no Debian, considerado o sucessor do Back Track. O projeto apresenta várias melhorias, além de mais aplicativos. É voltado principalmente para auditoria e segurança de computadores em geral.', 0x6b616c692e706e67),
(4, 'Parrot OS', 500, 'Sistema Operacional', 'O Parrot OS é um sistema operacional Linux, baseado no Debian, que procura atender um público bem específico, especialistas em segurança, pessoas que trabalham que computação forense, estudantes de ciência da computação e engenharia, pesquisadores, desenvolvedores de software e, claro, os hackers.', 0x706172726f742e706e67),
(5, 'Samurai Web Testing Framerowk', 500, 'Sistema Operacional', 'uma máquina virtual, suportada no VirtualBox e no VMWare, que foi pré-configurada para funcionar como um ambiente de pen-testing web. A VM contém as melhores ferramentas de código aberto e gratuitas que se concentram em testar e atacar sites.', 0x53616d757261692d5765622d54657374696e672d4672616d65776f726b2e706e67),
(6, 'Burp Suite', 751, 'Ferramenta', 'atua como um proxy web que permite interceptar e modificar solicitações e respostas HTTP/HTTPS entre o cliente e o servidor.', 0x627572702d73756974652e706e67),
(7, 'John The Ripper', 751, 'Ferramenta', ' uma ferramenta gratuita de software para quebrar senhas. Originalmente desenvolvido para o sistema operacional Unix, pode rodar em quinze plataformas diferentes', 0x4a54522e706e67),
(8, 'Maltego', 751, 'Ferramenta', 'O foco do Maltego é analisar as relações do mundo real entre informações que são publicamente acessíveis na Internet. Isso inclui a infraestrutura de apoio à Internet, bem como a localização de informações sobre as pessoas e a organização que as possuem', 0x6d616c7465676f2e706e67),
(9, 'Metasploit', 751, 'Ferramenta', ' é um projeto de segurança de computadores que fornece informações sobre vulnerabilidades de segurança e ajuda em testes de penetração e desenvolvimento de assinaturas IDS.', 0x6d65746173706c6f69742e706e67),
(10, 'Nmap', 751, 'Ferramentas', 'muito utilizado para avaliar a segurança dos computadores, e para descobrir serviços ou servidores em uma rede de computadores. Nmap é conhecido pela sua rapidez e pelas opções que dispõe', 0x6e6d61702e706e67);

-- --------------------------------------------------------

--
-- Estrutura para tabela `relatorio`
--

CREATE TABLE `relatorio` (
  `relatorio_id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `cidades_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servico`
--

CREATE TABLE `servico` (
  `tipo` varchar(10) NOT NULL,
  `comentario` text NOT NULL,
  `servico_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `dt_nasc` date NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `cpf` char(11) NOT NULL,
  `foto` text DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `cidades_id` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `plano_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `nome`, `dt_nasc`, `email`, `senha`, `cpf`, `foto`, `estado_id`, `cidades_id`, `is_admin`, `plano_id`) VALUES
(1, 'morozini', '2005-04-21', 'morozini@gmail.com', '321', '09423569935', 'morozini.jpg', 1, 2, 1, 0),
(9, 'Donald', '0000-00-00', 'eu@gmail.com', 'eu', '342398874', 'Donald G. Stephens.jpeg', 3, 12, 0, 0),
(10, 'teste', '2004-03-20', 'teste@gmail.com', '321', '09876543219', 'Yasmin Safiyyah.jpeg', 2, 7, 0, 0),
(11, 'GB', '2022-03-16', 'gb@gmail.com', '08642', '098765342', 'Yasmin Safiyyah.jpeg', 1, 12, 0, 0),
(12, 'prefeito', '0000-00-00', 'pedrosenna@gmail.com', '3877', '87587585875', 'Donald G. Stephens.jpeg', 1, 12, 1, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`avaliacao_id`,`usuario_id`),
  ADD KEY `fk_Avaliacao_usuario1_idx` (`usuario_id`);

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`cidade_id`,`estado_id`),
  ADD KEY `fk_Cidades_Estado_idx` (`estado_id`);

--
-- Índices de tabela `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`estado_id`);

--
-- Índices de tabela `plano`
--
ALTER TABLE `plano`
  ADD PRIMARY KEY (`plano_id`,`produto_id`),
  ADD KEY `fk_plano_produto1_idx` (`produto_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`produto_id`);

--
-- Índices de tabela `relatorio`
--
ALTER TABLE `relatorio`
  ADD PRIMARY KEY (`relatorio_id`,`usuario_id`,`estado_id`,`cidades_id`),
  ADD KEY `fk_relatorio_usuario1_idx` (`usuario_id`,`estado_id`,`cidades_id`);

--
-- Índices de tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`servico_id`,`usuario_id`),
  ADD KEY `fk_solicitacao_usuario1_idx` (`usuario_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`,`estado_id`,`cidades_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`),
  ADD KEY `fk_Usuario_Cidades1_idx` (`cidades_id`),
  ADD KEY `fk_usuario_estado1_idx` (`estado_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `cidade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `estado`
--
ALTER TABLE `estado`
  MODIFY `estado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `produto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `relatorio`
--
ALTER TABLE `relatorio`
  MODIFY `relatorio_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `fk_Avaliacao_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cidades`
--
ALTER TABLE `cidades`
  ADD CONSTRAINT `fk_Cidades_Estado` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `plano`
--
ALTER TABLE `plano`
  ADD CONSTRAINT `fk_plano_produto1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`produto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `relatorio`
--
ALTER TABLE `relatorio`
  ADD CONSTRAINT `fk_relatorio_usuario1` FOREIGN KEY (`usuario_id`,`estado_id`,`cidades_id`) REFERENCES `usuario` (`usuario_id`, `estado_id`, `cidades_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `servico`
--
ALTER TABLE `servico`
  ADD CONSTRAINT `fk_solicitacao_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_Usuario_Cidades1` FOREIGN KEY (`cidades_id`) REFERENCES `cidades` (`cidade_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
