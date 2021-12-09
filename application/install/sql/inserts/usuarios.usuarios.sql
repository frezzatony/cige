

--ADMINISTRADOR
INSERT INTO usuarios.usuarios
(id, usuario, senha, email, ativo, nome, configs, can_delete)
VALUES(1, 'admin', '$2y$10$/Y45/X4VrhR6bx5RZtm/KuowoExmADd18TPPsqGEjra9h51RslkTC', 'tony@saobentodosul.sc.gov.br', true, 'Admin', '{"entity": "1", "modulo": "1", "modulo_descricao": "Gestão do sistema"}', false)
ON CONFLICT (id) DO NOTHING;

