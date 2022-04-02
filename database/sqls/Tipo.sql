INSERT INTO tipo(id,descricao, created_at, updated_at) VALUES
(1, 'Moto', now(), now()),
(2, 'Carro', now(), now()),
(3, 'Caminhão', now(), now())
ON DUPLICATE KEY UPDATE id=id
;
