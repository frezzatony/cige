
--TIPOS DE CONTROLLERS
INSERT INTO sistema.tipos_controllers
(id, descricao)
VALUES(1, 'Default') ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.tipos_controllers
(id, descricao)
VALUES(2, 'Cadastro') ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.tipos_controllers
(id, descricao)
VALUES(3, 'Gestão do sistema') ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.tipos_controllers
(id, descricao)
VALUES(4, 'Relatório') ON CONFLICT (id) DO NOTHING;



--CONTROLLERS
INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(1, 3, true, 'Controller', 'Controllers', '{BASE_URL}/controllers', NULL, NULL, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(2, 3, true, 'Usuário', 'Usuários', '{BASE_URL}users/users', NULL, NULL, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(3, 3, true, 'Perfil de usuário', 'Perfis de usuários', '{BASE_URL}users/profiles', NULL, NULL, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(4, 3, true, 'Ação de controller', 'Ações de controllers', '{BASE_URL}controllers/acoes-controllers', NULL, NULL, false)  ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(5, 3, true, 'Permissão de ação de controller', 'Permissões de ações de controllers', '{BASE_URL}controllers/permissoes-acoes', NULL, NULL, false)  ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(6, 3, true, 'Gestão do Main Menu', 'Gestão do Main Menu', '{BASE_URL}menus/main-menu', NULL, NULL, false)  ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(7, 3, true, 'Tipo de controller', 'Tipos de controllers', '{BASE_URL}controllers/tipos-controllers', NULL, NULL, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(8, 3, true, 'Entidade', 'Entidades', '{BASE_URL}entities', NULL, NULL, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(9, 3, true, 'Seção de trabalho', 'Seções de trabalho', '{BASE_URL}entitites/sections', NULL, NULL, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(10, 3, true, 'Permissão', 'Permissões', '{BASE_URL}permissions', NULL, NULL, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers
(id, sistema_tipos_controllers_id, ativo, descricao_singular, descricao_plural, url, atributos, controller, can_delete)
VALUES(11, 3, true, 'Módulo', 'Módulos', '{BASE_URL}/modulos/modulos', NULL, NULL, true) ON CONFLICT (id) DO NOTHING;



--ACOES DE CONTROLLERS

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(1, 1, 'Gerenciar controllers', 6) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(2, 1, 'Consultar controllers', 1) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(3, 2, 'Consultar Usuários', 1) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(4, 2, 'Gerenciar Usuários', 6) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(5, 3, 'Consultar Perfis de Usuários', 1) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(6, 3, 'Gerenciar Perfis de Usuários', 6) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(7, 4, 'Consultar Ações de Controllers', 1) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(8, 4, 'Gerenciar Ações de Controllers', 6) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(9, 5, 'Consultar Permissões de Ações de Controllers', 1) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(10, 5, 'Gerenciar Permissões de Ações de Controllers', 6) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(11, 6, 'Gerenciar Main Menu', 6) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(12, 7, 'Consultar Tipos de Controllers', 1) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(13, 7, 'Gerenciar Tipos de Controllers', 6) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(14, 8, 'Consultar Entidades', 1) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(15, 8, 'Gerenciar Entidades', 6) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(16, 9, 'Consultar Seções de Trabalho', 1) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(17, 9, 'Gerenciar Seções de Trabalho', 6) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(18, 10, 'Consultar Permissões', 1) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(19, 10, 'Gerenciar Permissões', 6) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(20, 11, 'Consultar Módulos', 1) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.controllers_acoes
(id, sistema_controllers_id, descricao, sistema_permissoes_id)
VALUES(21, 11, 'Gerenciar Módulos', 6) ON CONFLICT (id) DO NOTHING;
