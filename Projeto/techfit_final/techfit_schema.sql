
-- TechFit Gym - MySQL schema (aligned to backend_completo PHP endpoints)
-- Charset/engine
CREATE DATABASE IF NOT EXISTS techfit CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE techfit;

-- Safety: drop tables if needed (comment out in production)
-- SET FOREIGN_KEY_CHECKS=0;
-- DROP TABLE IF EXISTS acessos, avaliacoes, mensagens, reservas, tickets, turmas, membros;
-- SET FOREIGN_KEY_CHECKS=1;

-- =============
-- Base: membros
-- =============
CREATE TABLE IF NOT EXISTS membros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(120) UNIQUE,
  modalidade VARCHAR(80),
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_membros_nome (nome)
) ENGINE=InnoDB;

-- =============
-- Turmas
-- =============
CREATE TABLE IF NOT EXISTS turmas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  modalidade VARCHAR(80) NOT NULL,
  capacidade INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============
-- Reservas
-- =============
CREATE TABLE IF NOT EXISTS reservas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  membro_id INT NOT NULL,
  turma_id INT NOT NULL,
  data DATE NOT NULL,
  hora TIME NOT NULL,
  status VARCHAR(30) NOT NULL DEFAULT 'confirmado',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_reservas_membro FOREIGN KEY (membro_id) REFERENCES membros(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_reservas_turma  FOREIGN KEY (turma_id)  REFERENCES turmas(id)  ON DELETE CASCADE ON UPDATE CASCADE,
  -- evita reserva duplicada do mesmo membro para a mesma turma no mesmo horário
  UNIQUE KEY uk_reserva_unica (membro_id, turma_id, data, hora)
) ENGINE=InnoDB;

-- =============
-- Mensagens (com segmentos em JSON/Texto)
-- =============
CREATE TABLE IF NOT EXISTS mensagens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(200) NOT NULL,
  corpo TEXT NOT NULL,
  segmentos JSON NULL,
  destinatarios INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Se o seu MySQL não suportar JSON, troque a coluna por TEXT:
-- ALTER TABLE mensagens MODIFY segmentos TEXT NULL;

-- =============
-- Avaliações físicas
-- =============
CREATE TABLE IF NOT EXISTS avaliacoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  membro_id INT NOT NULL,
  peso DECIMAL(6,2) NULL,
  altura DECIMAL(4,2) NULL,
  gordura DECIMAL(5,2) NULL,
  cintura DECIMAL(6,2) NULL,
  obs TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_avaliacoes_membro FOREIGN KEY (membro_id) REFERENCES membros(id) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX idx_avaliacoes_membro (membro_id, created_at)
) ENGINE=InnoDB;

-- =============
-- Tickets (suporte)
-- =============
CREATE TABLE IF NOT EXISTS tickets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  membro_id INT NOT NULL,
  assunto VARCHAR(200) NOT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'aberto',
  data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_tickets_membro FOREIGN KEY (membro_id) REFERENCES membros(id) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX idx_tickets_status (status),
  INDEX idx_tickets_membro (membro_id, data_criacao)
) ENGINE=InnoDB;

-- =============
-- Acessos (logs de acesso/autenticação)
-- =============
CREATE TABLE IF NOT EXISTS acessos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  membro_id INT NOT NULL,
  metodo VARCHAR(50) NOT NULL,        -- ex: 'email', 'google', 'admin'
  resultado VARCHAR(50) NOT NULL,     -- ex: 'sucesso', 'falha'
  obs TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_acessos_membro FOREIGN KEY (membro_id) REFERENCES membros(id) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX idx_acessos_membro (membro_id, created_at),
  INDEX idx_acessos_resultado (resultado)
) ENGINE=InnoDB;

-- ========================
-- Vistas úteis (opcional)
-- ========================
CREATE OR REPLACE VIEW vw_reservas_detalhe AS
SELECT r.id,
       r.data,
       r.hora,
       r.status,
       m.id AS membro_id,
       m.nome AS membro_nome,
       t.id AS turma_id,
       t.nome AS turma_nome,
       t.modalidade AS turma_modalidade
FROM reservas r
JOIN membros m ON m.id = r.membro_id
JOIN turmas  t ON t.id = r.turma_id;

CREATE OR REPLACE VIEW vw_tickets AS
SELECT t.id, t.assunto, t.status, t.data_criacao, m.nome AS membro_nome, m.email AS membro_email
FROM tickets t
JOIN membros m ON m.id = t.membro_id;

-- ========================
-- Dados mínimos para teste
-- ========================
INSERT INTO membros (nome, email, modalidade) VALUES
('Admin Demo','admin@techfit.com','Musculação'),
('Maria Silva','maria.silva@exemplo.com','Cross'),
('João Souza','joao.souza@exemplo.com','Pilates');

INSERT INTO turmas (nome, modalidade, capacidade) VALUES
('Cross 07h', 'Cross', 20),
('Pilates 18h', 'Pilates', 12);

INSERT INTO reservas (membro_id, turma_id, data, hora) VALUES
(2, 1, CURDATE(), '07:00:00'),
(3, 2, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '18:00:00');

INSERT INTO tickets (membro_id, assunto) VALUES
(2, 'Dúvida sobre plano'),
(3, 'Problema no acesso ao app');

INSERT INTO avaliacoes (membro_id, peso, altura, gordura, cintura, obs) VALUES
(2, 68.5, 1.65, 22.4, 78.0, 'Revisar em 30 dias'),
(3, 82.3, 1.78, 18.1, 83.0, NULL);

INSERT INTO mensagens (titulo, corpo, segmentos, destinatarios) VALUES
('Boas‑vindas', 'Bem‑vindo(a) à TechFit! 🎉', JSON_ARRAY('novos','geral'), 2);
