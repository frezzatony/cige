
--PERMISSOES

INSERT INTO sistema.permissoes
(id, descricao, contempla_ids)
VALUES(1, 'Visualizar', NULL) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.permissoes
(id, descricao, contempla_ids)
VALUES(2, 'Visualizar+Editar', '[1]') ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.permissoes
(id, descricao, contempla_ids)
VALUES(3, 'Visualizar+Editar+Excluir', '[2]') ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.permissoes
(id, descricao, contempla_ids)
VALUES(4, 'Visualizar+Log', '[1]') ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.permissoes
(id, descricao, contempla_ids)
VALUES(5, 'Visualizar+Editar+Log', '[2, 4]') ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.permissoes
(id, descricao, contempla_ids)
VALUES(6, 'Visualizar+Editar+Excluir+Log', '[5, 3]') ON CONFLICT (id) DO NOTHING;