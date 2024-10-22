-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21/10/2024 às 16:18
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
-- Estrutura para tabela `checkout`
--

CREATE TABLE `checkout` (
  `checkout_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `metodo` varchar(50) NOT NULL,
  `senha` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `checkout`
--

INSERT INTO `checkout` (`checkout_id`, `usuario_id`, `data_inicio`, `metodo`, `senha`) VALUES
(4, 3, '2024-10-17', 'PIX', 'eu'),
(5, 57, '2024-10-18', 'PayPal', '123'),
(6, 58, '2024-10-18', 'PayPal', '123');

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
  `preco_plano` decimal(5,2) NOT NULL,
  `tempo` varchar(3) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `plano`
--

INSERT INTO `plano` (`plano_id`, `nome_plano`, `preco_plano`, `tempo`, `descricao`) VALUES
(2, 'Free', 100.00, '-1', 'Tenha acesso a: Sistema operacional'),
(3, 'Pro', 250.00, '4', 'Tenha acesso a: Sistemas operacionais e Ferramentas'),
(4, 'Ultra', 560.00, '6', 'Tenha acesso a: Sistemas operacionais, ferramentas e solicitação de serviço'),
(5, 'Mega', 990.00, '12', 'Tenha acesso a: Sistemas operacionais, Ferramentas, solicitação de serviços e ferramentas edição Vanguard');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `produto_id` int(11) NOT NULL,
  `nome_produto` text NOT NULL,
  `classe` varchar(20) NOT NULL,
  `descricao` text NOT NULL,
  `imagem` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`produto_id`, `nome_produto`, `classe`, `descricao`, `imagem`) VALUES
(25, 'back box', 'Sistema operacional', 'teste', 0x6261636b626f782e706e67),
(26, 'Black Arch', 'Sistema Operacional', 'BlackArch Linux é uma distribuição de teste de penetração baseada em Arch Linux para testadores de penetração e pesquisadores de segurança. O repositório contém 2.921 ferramentas. Você pode instalar ferramentas individualmente ou em grupos. BlackArch Linux é compatível com instalações existentes do Arch.', 0x426c61636b417263682e706e67),
(27, 'Kali', 'Sistema Operacional', 'É voltado principalmente para auditoria e segurança de computadores em geral. É desenvolvido e mantido pela Offensive Security Ltd.', 0x6b616c692e706e67),
(28, 'John The Ripper', 'Ferramenta', 'É uma ferramenta de cracking de senhas altamente eficiente e de código aberto. Originalmente desenvolvida para sistemas Unix, expandiu-se para suportar várias plataformas e formatos de senha, incluindo Windows, Linux, macOS e até mesmo dispositivos móveis.', 0x4a54522e706e67),
(29, 'Burp Suite', 'Ferramenta', 'É uma ferramenta integrada de segurança de aplicativos web que permite aos profissionais de segurança realizar uma ampla gama de testes de penetração.', 0x627572702d73756974652e706e67),
(30, 'Metasploit', 'Ferramenta', 'É um projeto de segurança de computadores que fornece informações sobre vulnerabilidades de segurança e ajuda em testes de penetração e desenvolvimento de assinaturas IDS', 0x6d65746173706c6f69742e706e67),
(31, 'leandro', 'ferramenta', 'asd', 0x343935356539643139323130626635383461663035633733656533313263333739653838346366666364616638316430623866636636326632633566643164655f312e6a7067);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_plano`
--

CREATE TABLE `produto_plano` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `plano_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto_plano`
--

INSERT INTO `produto_plano` (`id`, `produto_id`, `plano_id`) VALUES
(1, 25, 2),
(2, 25, 5),
(3, 25, 3),
(4, 25, 4),
(5, 26, 2),
(6, 26, 5),
(7, 26, 3),
(8, 26, 4),
(9, 27, 2),
(10, 27, 5),
(11, 27, 3),
(12, 27, 4),
(13, 28, 5),
(14, 28, 3),
(15, 28, 4),
(16, 29, 5),
(17, 29, 3),
(18, 29, 4),
(19, 30, 5),
(20, 30, 3),
(21, 30, 4),
(22, 31, 2);

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
(1, 'Gabriel', '2005-04-21', 'morozini@gmail', '123', '09423569935', 'morozini.jpg', 3, 12, 1, 0),
(2, 'Victor', '2006-03-20', 'Vmoice@gmail.com', '@gmail.como', '94823465309', 'Victor.jpg', 2, 5, 0, 0),
(3, 'Teste', '2000-02-09', 'eu@eu', 'eu', '12345678921', 'Ryan Alves Costa.jpeg', 3, 10, 0, 5),
(56, 'Pedro', '0000-00-00', 'pedro@gmail', 'pedro', '09876543213', 'cave man.jpg', 2, 7, 0, 0),
(58, 'leandro2', '2000-03-21', 'leandro2@leandro2', '123', '1234', 'Donald G. Stephens.jpeg', 1, 12, 1, 5);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`avaliacao_id`);

--
-- Índices de tabela `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`checkout_id`);

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`cidade_id`);

--
-- Índices de tabela `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`estado_id`);

--
-- Índices de tabela `plano`
--
ALTER TABLE `plano`
  ADD PRIMARY KEY (`plano_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`produto_id`);

--
-- Índices de tabela `produto_plano`
--
ALTER TABLE `produto_plano`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `plano_id` (`plano_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `avaliacao_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `checkout`
--
ALTER TABLE `checkout`
  MODIFY `checkout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT de tabela `plano`
--
ALTER TABLE `plano`
  MODIFY `plano_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `produto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `produto_plano`
--
ALTER TABLE `produto_plano`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `produto_plano`
--
ALTER TABLE `produto_plano`
  ADD CONSTRAINT `produto_plano_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`produto_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produto_plano_ibfk_2` FOREIGN KEY (`plano_id`) REFERENCES `plano` (`plano_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
