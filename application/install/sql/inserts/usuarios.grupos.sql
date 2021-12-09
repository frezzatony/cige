
--ADMINISTRADORES
INSERT INTO usuarios.grupos
(id, nome, descricao, ativo, administrador, can_delete)
VALUES(1, 'Administradores', 'Administradores do sistema', true, true, false) ON CONFLICT (id) DO NOTHING;

--ACESSO PUBLICO
INSERT INTO usuarios.grupos
(id, nome, descricao, ativo, administrador, can_delete)
VALUES(2, 'Acesso público', 'Acesso público', true, false, false) ON CONFLICT (id) DO NOTHING;


--USUARIO ADMINISTRADOR NO GRUPO ADMINISTRADORES
INSERT INTO usuarios.usuarios_grupos
(id, usuarios_usuarios_id, usuarios_grupos_id)
VALUES(1, 1, 1) ON CONFLICT (id) DO NOTHING;

