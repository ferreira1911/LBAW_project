-- Populate Script for LBAW25172
SET search_path TO lbaw25172;

------------------------------------------------------------
-- USERS
-- Password placeholder: '$2y$10$XXXXXXXXXXXXXXXXXXXXXX' (Bcrypt hash for 'password123')
------------------------------------------------------------
INSERT INTO users (email, name, obs, credit, password, url) VALUES
(1, 'joao.silva@mail.pt', 'Vendedor verificado, especialista em antiguidades e arte.', 4500.50, '$2y$10$S1lVaX5u6c7b8d9e0f1g2h3i4j5k6l7m8n9o0p1q2r3s4t5u6v7w8x9y0z1a2b3c4', 'https://example.com/users/joao.jpg'),
(2, 'ana.gomes@mail.pt', 'Colecionadora de joias raras, excelente feedback.', 8200.00, '$2y$10$A6nAg0mE1s2f3e4d5c6b7a8z9y0x1w2v3u4t5s6r7q8p9o0n1m2l3k4j5i6h7g8f9e', 'https://example.com/users/ana.jpg'),
(3, 'pedro.oliveira@mail.pt', 'Interessado em eletrónica e gadgets. Novo na plataforma.', 750.00, '$2y$10$P3dRo0lI1vE2iR3a4o5e6f7g8h9i0j1k2l3m4n5o6p7q8r9s0t1u2v3w4x5y6z7a8b', NULL),
(4, 'maria.fernandes@mail.pt', 'Vendedora profissional de vestuário vintage.', 3150.75, '$2y$10$M4rIaF3rN4nDs5eA6b7c8d9e0f1g2h3i4j5k6l7m8n9o0p1q2r3s4t5u6v7w8x9y0z', 'https://example.com/users/maria.jpg'),
(5, 'carlos.almeida@mail.pt', 'Fã de carros e motocicletas clássicas.', 1980.25, '$2y$10$C5rL0sA6lM7eId8aF9g0h1i2j3k4l5m6n7o8p9q0r1s2t3u4v5w6x7y8z9a0b1c2d3e', NULL),
(6, 'ines.santos@mail.pt', 'Interesses variados, de livros a desporto.', 1500.00, '$2y$10$I6nEsS7aN8tOs9F0g1h2i3j4k5l6m7n8o9p0q1r2s3t4u5v6w7x8y9z0a1b2c3d4e5f6', 'https://example.com/users/ines.jpg'),
(7, 'ricardo.pires@mail.pt', NULL, 900.00, '$2y$10$R7cRdP8iR9eS0g1h2i3j4k5l6m7n8o9p0q1r2s3t4u5v6w7x8y9z0a1b2c3d4e5f6g7h', NULL),
(8, 'sofia.martins@mail.pt', 'Especialista em decoração e artigos para o lar.', 2200.50, '$2y$10$S8fMaR9tInS0g1h2i3j4k5l6m7n8o9p0q1r2s3t4u5v6w7x8y9z0a1b2c3d4e5f6g7hI', 'https://example.com/users/sofia.jpg'),
(9, 'miguel.ferreira@mail.pt', 'Vende material fotográfico e tecnologia.', 3750.00, '$2y$10$M9gFlF0rR1rA2eI3rA4o5e6f7g8h9i0j1k2l3m4n5o6p7q8r9s0t1u2v3w4x5y6z7a', NULL),
(10, 'elena.rodriguez@mail.pt', 'Compradora de obras de arte contemporânea.', 5500.25, '$2y$10$E0lEaR1dG2uEz3f4e5d6c7b8a9z0y1x2w3v4u5t6s7r8q9p0o1n2m3l4k5j6i7h8g9f', 'https://example.com/users/elena.jpg');

------------------------------------------------------------
-- ADMIN
------------------------------------------------------------
INSERT INTO admin (email, name, password) VALUES
('admin.geral@auctionhouse.com', 'Admin Geral', '$2y$10$A1dMiN2gE3rA4l5c6b7a8z9y0x1w2v3u4t5s6r7q8p9o0n1m2l3k4j5i6h7g8f9e'),
('admin.financeiro@auctionhouse.com', 'Admin Financeiro', '$2y$10$A2dMiN3fI4nC5eI6rO7c8d9e0f1g2h3i4j5k6l7m8n9o0p1q2r3s4t5u6v7w8x9y0z');

------------------------------------------------------------
-- CATEGORIES
------------------------------------------------------------
INSERT INTO category (name) VALUES
('Eletrónica'),
('Arte e Colecionáveis'),
('Joalharia e Relógios'),
('Veículos'),
('Casa e Jardim'),
('Desporto e Lazer'),
('Moda e Acessórios'),
('Livros e Multimédia'),
('Antiguidades'),
('Moedas e Selos');

------------------------------------------------------------
-- LOCATIONS
------------------------------------------------------------
INSERT INTO location (gps, address, url) VALUES
('38.7223,-9.1393', 'Rua Augusta, 100, 1100-053 Lisboa, Portugal', 'https://maps.example.com/lisboa'),
('41.1579,-8.6291', 'Avenida da Boavista, 500, 4100-112 Porto, Portugal', 'https://maps.example.com/porto'),
('40.6405,-8.6538', 'Rua de Coimbra, 25, 3800-100 Aveiro, Portugal', 'https://maps.example.com/aveiro'),
('51.5074,-0.1278', '140 Oxford St, London W1D 1JQ, UK', 'https://maps.example.com/london'),
('48.8566,2.3522', 'Avenue des Champs-Élysées, 75008 Paris, France', 'https://maps.example.com/paris'),
('40.7128,-74.0060', '123 Wall St, New York, NY 10005, USA', 'https://maps.example.com/nyc_usa'),
('35.6895,139.6917', 'Ginza St, Chūō City, Tokyo 104-0061, Japan', 'https://maps.example.com/tokyo'),
('34.0522,-118.2437', '9021 Rodeo Dr, Beverly Hills, CA 90210, USA', 'https://maps.example.com/la_usa'),
('34.6937,135.5023', 'Dotonbori St, Chuo Ward, Osaka 542-0071, Japan', 'https://maps.example.com/osaka'),
('52.3676,4.9041', 'Dam Square, 1012 JS Amsterdam, Netherlands', 'https://maps.example.com/amsterdam');

------------------------------------------------------------
-- AUCTIONS
-- Owner_id é a FK para users(id)
-- Category_id é a FK para category(id)
-- Location_id é a FK para location(id)
------------------------------------------------------------
INSERT INTO auction (title, reference, description, startdate, enddate, startingprice, currentprice, status, owner_id, category_id, location_id) VALUES
-- Active auctions
(1, 'Relógio Patek Philippe Calatrava Ouro', 10001, 'Modelo clássico, caixa em ouro rosa 18K. Inclui caixa e documentos originais.', CURRENT_TIMESTAMP - INTERVAL '3 days', CURRENT_TIMESTAMP + INTERVAL '10 days', 18000.00, 19500.00, 'Active', 2, 3, 4), -- Ana Gomes (Joalharia)
(2, 'Laptop Gaming Asus ROG Novo', 10002, 'Processador i9, RTX 4080. Selado, garantia 2 anos.', CURRENT_TIMESTAMP - INTERVAL '12 hours', CURRENT_TIMESTAMP + INTERVAL '5 days', 2800.00, 2950.00, 'Active', 9, 1, 1), -- Miguel Ferreira (Eletrónica)
(3, 'Escultura em Bronze "O Pensador"', 10003, 'Réplica licenciada de 1.5m de altura. Excelente para jardim ou interior.', CURRENT_TIMESTAMP - INTERVAL '1 day', CURRENT_TIMESTAMP + INTERVAL '3 days 6 hours', 900.00, 1050.00, 'Active', 1, 2, 2), -- João Silva (Arte)
(4, 'VW Pão de Forma T1 1975 Restaurada', 10004, 'Completamente restaurada, motor em perfeitas condições. Viatura de coleção.', CURRENT_TIMESTAMP - INTERVAL '2 days', CURRENT_TIMESTAMP + INTERVAL '14 days', 25000.00, 25000.00, 'Active', 5, 4, 3), -- Carlos Almeida (Veículos)
(5, 'Máquina Fotográfica Nikon Z9', 10005, 'Corpo profissional, apenas 500 cliques. Como nova.', CURRENT_TIMESTAMP - INTERVAL '6 hours', CURRENT_TIMESTAMP + INTERVAL '7 days', 4500.00, 4500.00, 'Active', 9, 1, 10), -- Miguel Ferreira (Eletrónica)
(6, 'Serviço de Jantar Vista Alegre 12 Pessoas', 10006, 'Coleção "D. João V", novo, nunca usado.', CURRENT_TIMESTAMP + INTERVAL '2 days', CURRENT_TIMESTAMP + INTERVAL '14 days', 1500.00, 1500.00, 'Pending', 8, 5, 5), -- Sofia Martins (Casa e Jardim)
(7, 'Camisa Autografada Cristiano Ronaldo', 10007, 'Camisa da seleção nacional autografada. Certificado de autenticidade.', CURRENT_TIMESTAMP + INTERVAL '1 day', CURRENT_TIMESTAMP + INTERVAL '7 days', 3500.00, 3500.00, 'Pending', 6, 6, 6), -- Inês Santos (Desporto)
(8, 'Diamante de 1 Quilate (Certificado GIA)', 10008, 'Diamante redondo, cor F, pureza VS1.', CURRENT_TIMESTAMP - INTERVAL '15 days', CURRENT_TIMESTAMP - INTERVAL '5 days', 6000.00, 8500.00, 'Ended', 2, 3, 7), -- Ana Gomes (Joalharia)
(9, 'Coleção de Livros "Os Lusíadas" (1ª Edição)', 10009, 'Edição de 1572. Estado de conservação razoável.', CURRENT_TIMESTAMP - INTERVAL '20 days', CURRENT_TIMESTAMP - INTERVAL '1 day', 10000.00, 15200.00, 'Ended', 1, 8, 8), -- João Silva (Livros)
(10, 'Bicicleta de Estrada Carbono Pinarello', 10010, 'Modelo 2023, Ultegra Di2. Sem lances recebidos.', CURRENT_TIMESTAMP - INTERVAL '10 days', CURRENT_TIMESTAMP - INTERVAL '3 days', 4000.00, 4000.00, 'Ended', 6, 6, 9), -- Inês Santos (Desporto)
(11, 'Moeda de Ouro D. Maria II 1845', 10011, 'Raríssima, estado de conservação MB. Leilão cancelado por problemas de autenticidade.', CURRENT_TIMESTAMP - INTERVAL '7 days', CURRENT_TIMESTAMP + INTERVAL '4 days', 3000.00, 3000.00, 'Cancelled', 10, 10, 1); -- Elena Rodriguez (Moedas e Selos)

INSERT INTO bid (amount, date, user_id, auction_id) VALUES
(18500.00, CURRENT_TIMESTAMP - INTERVAL '2 days 10 hours', 3, 1),
(19000.00, CURRENT_TIMESTAMP - INTERVAL '1 day 5 hours', 10, 1),
(19500.00, CURRENT_TIMESTAMP - INTERVAL '8 hours', 3, 1),

(2850.00, CURRENT_TIMESTAMP - INTERVAL '10 hours', 7, 2),
(2900.00, CURRENT_TIMESTAMP - INTERVAL '8 hours', 3, 2),
(2950.00, CURRENT_TIMESTAMP - INTERVAL '2 hours', 4, 2),

(950.00, CURRENT_TIMESTAMP - INTERVAL '18 hours', 6, 3),
(1000.00, CURRENT_TIMESTAMP - INTERVAL '15 hours', 7, 3),
(1050.00, CURRENT_TIMESTAMP - INTERVAL '5 hours', 8, 3),

(7000.00, CURRENT_TIMESTAMP - INTERVAL '14 days', 3, 8),
(7500.00, CURRENT_TIMESTAMP - INTERVAL '12 days', 10, 8),
(8000.00, CURRENT_TIMESTAMP - INTERVAL '10 days', 4, 8),
(8500.00, CURRENT_TIMESTAMP - INTERVAL '6 days', 3, 8), -- Pedro Oliveira (Vencedor)

(11000.00, CURRENT_TIMESTAMP - INTERVAL '18 days', 5, 9),
(12500.00, CURRENT_TIMESTAMP - INTERVAL '15 days', 4, 9),
(14000.00, CURRENT_TIMESTAMP - INTERVAL '10 days', 10, 9),
(15200.00, CURRENT_TIMESTAMP - INTERVAL '2 days', 5, 9); -- Carlos Almeida (Vencedor)


INSERT INTO transactions (amount, date, status, auction_id, winner_id) VALUES
(8500.00, CURRENT_TIMESTAMP - INTERVAL '4 days', 'Completed', 8, 3), -- Vencedor: Pedro Oliveira (id 3)
(15200.00, CURRENT_TIMESTAMP - INTERVAL '12 hours', 'Completed', 9, 5), -- Vencedor: Carlos Almeida (id 5)

(19500.00, CURRENT_TIMESTAMP + INTERVAL '10 days', 'Pending', 1, 3); -- Vencedor potencial: Pedro Oliveira (id 3)


INSERT INTO review (description, rating, createddate, user_id) VALUES
('O diamante superou as expectativas. Vendedor altamente recomendado (Ana Gomes)!', 5.00, CURRENT_TIMESTAMP - INTERVAL '3 days', 3), -- Pedro Oliveira (comprador)
('Pagamento imediato e comunicação excelente do comprador (Pedro Oliveira).', 5.00, CURRENT_TIMESTAMP - INTERVAL '2 days', 2), -- Ana Gomes (vendedor)
('Livro chegou bem embalado e conforme a descrição, excelente transação.', 4.80, CURRENT_TIMESTAMP - INTERVAL '10 hours', 5), -- Carlos Almeida (comprador)
('Transação suave e rápida. Comprador (Carlos Almeida) sério e responsável.', 4.50, CURRENT_TIMESTAMP - INTERVAL '5 hours', 1), -- João Silva (vendedor)
('Artigo para o lar de ótima qualidade. Vendedor atencioso.', 4.00, CURRENT_TIMESTAMP - INTERVAL '7 days', 7); -- Ricardo Pires (comprador noutra transação)


INSERT INTO report (description, createddate, status, user_id, admin_id, reported_user_id, auction_id) VALUES
(1, 'Suspeita de lances falsos no leilão do relógio Patek Philippe.', CURRENT_TIMESTAMP - INTERVAL '1 day', 'Pending', 10, NULL, 3, 1), -- Elena reporta Pedro (Admin ainda não atribuiu)
(2, 'Descrição do artigo (VW Pão de Forma) parece exagerada. Necessário verificação.', CURRENT_TIMESTAMP - INTERVAL '10 hours', 'InReview', 4, 1, 5, 4), -- Maria reporta Carlos (Admin Geral)
(3, 'Utilizador (João Silva) enviou mensagens ofensivas após perder um leilão.', CURRENT_TIMESTAMP - INTERVAL '3 days', 'Resolved', 7, 2, 1, NULL), -- Ricardo reporta João (Admin Financeiro resolveu)
(4, 'O leilão da Moeda de Ouro é fraudulento. Produto claramente falso.', CURRENT_TIMESTAMP - INTERVAL '5 days', 'Dismissed', 9, 1, 10, 11), -- Miguel reporta Elena (Admin Geral rejeitou, falta de provas)
(5, 'Problema no pagamento da transação do Diamante (ID 8). O comprador alegou falha no sistema.', CURRENT_TIMESTAMP - INTERVAL '1 day', 'Pending', 2, NULL, 3, 8); -- Ana reporta Pedro (Admin ainda não atribuiu)


INSERT INTO user_follows (follower_id, followed_auction) VALUES
(1, 1), (1, 2), (1, 4), -- João segue Patek, Laptop, VW
(2, 4), (2, 8), (2, 9), -- Ana segue VW, Diamante (Ended), Lusíadas (Ended)
(3, 1), (3, 2), (3, 8), -- Pedro segue Patek, Laptop, Diamante (Venceu um)
(4, 1), (4, 3), (4, 4), -- Maria segue Patek, Escultura, VW
(5, 4), (5, 9), -- Carlos segue VW, Lusíadas (Venceu)
(6, 2), (7, 2), (8, 3),
(9, 1), (10, 1), (10, 9);



UPDATE users SET is_deleted = TRUE WHERE id = 10; -- this will be to test the trigger that annonamyzes the user activities