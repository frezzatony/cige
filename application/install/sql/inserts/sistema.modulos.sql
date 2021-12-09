
--MODULOS
INSERT INTO sistema.modulos
(id, descricao)
VALUES(1, 'Gestão do sistema') ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.modulos
(id, descricao)
VALUES(2, 'Acesso Público') ON CONFLICT (id) DO NOTHING;
