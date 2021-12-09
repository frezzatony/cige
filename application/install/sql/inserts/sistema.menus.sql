
--MENUS
INSERT INTO sistema.menus
(id, nome)
VALUES(1, 'Main Menu') ON CONFLICT (id) DO NOTHING;
INSERT INTO sistema.menus
(id, nome)
VALUES(2, 'Ações de um modulo') ON CONFLICT (id) DO NOTHING;
INSERT INTO sistema.menus
(id, nome)
VALUES(3, 'Ações de um item de um módulo') ON CONFLICT (id) DO NOTHING;


--MENUS ITENS

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('4681c9f7-505c-4dcf-bb25-afa2b4a06370', NULL, 1, 1, '{"href": "#", "icon": "fa ", "class": null, "title": "Sistema"}', 3, NULL, 1, NULL, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('8ca5f073-1c04-4b0d-8d32-8b929c417233', NULL, 1, 2, '{"href": "#", "icon": "fa empty", "class": null, "title": "Entidades"}', NULL, NULL, 1, NULL, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('b14a3eee-e253-416e-af62-12c313b62db7', NULL, 1, 3, '{"href": "#", "icon": "fa ", "class": null, "title": "Controllers"}', NULL, NULL, 1, NULL, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('0a364524-a550-4855-b50d-d406d01fc0df', NULL, 1, 1, '{"href": "#", "icon": "fa ", "class": null, "title": "Cadastros"}', NULL, NULL, 2, NULL, true, true, true) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('185317a0-5aad-49fd-bf6f-25f7e2c3eb2d', NULL, 1, 4, '{"href": "#", "icon": "fa empty", "class": null, "title": "Permissões"}', NULL, NULL, 1, NULL, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('327bc565-a090-41f2-9687-0ccd80bf5248', NULL, 1, 5, '{"href": "#", "icon": "fa ", "class": null, "title": "Usuários"}', NULL, NULL, 1, NULL, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('411c7d6f-3d55-425b-805e-4e9c084baedb', '4681c9f7-505c-4dcf-bb25-afa2b4a06370', 1, 1, '{"href": "{BASE_URL}menus/main-menu", "icon": "fa fa-bars", "class": null, "title": "Main Menu"}', 3, NULL, 1, 5, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('1552fe4e-2661-4a5d-a0c0-b8df508b40c3', '4681c9f7-505c-4dcf-bb25-afa2b4a06370', 1, 2, '{"href": "{BASE_URL}modulos/modulos", "icon": "fa fa-columns", "class": null, "title": "Módulos"}', 3, NULL, 1, NULL, true, true, true) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('6fb05c7d-0fbd-4c5d-a1bb-c12f9d211085', '327bc565-a090-41f2-9687-0ccd80bf5248', 1, 1, '{"href": "{BASE_URL}users/users", "icon": "fa fa-user", "class": null, "title": "Usuários"}', 3, NULL, 1, 5, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('1c38e132-45fd-43cd-b12f-5f9de860fefe', '327bc565-a090-41f2-9687-0ccd80bf5248', 1, 2, '{"href": "{BASE_URL}users/profiles", "icon": "fa fa-address-card-o", "class": null, "title": "Perfis de usuários"}', 3, NULL, 1, 5, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('f172f003-0d49-446b-8c5d-9a57327a02d6', '185317a0-5aad-49fd-bf6f-25f7e2c3eb2d', 1, 1, '{"href": "{BASE_URL}permissoes", "icon": "fa fa-shield", "class": null, "title": "Permissões"}', 3, NULL, 1, NULL, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('fd9cbf6d-0ec7-499c-b897-3ad027b67a6c', 'b14a3eee-e253-416e-af62-12c313b62db7', 1, 1, '{"href": "{BASE_URL}controllers", "icon": "fa fa-bullseye", "class": null, "title": "Controllers"}', 3, 1, 1, 1, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('95142785-c92a-4719-9077-6aefe7e336c9', 'b14a3eee-e253-416e-af62-12c313b62db7', 1, 2, '{"href": "{BASE_URL}controllers/tipos-controllers", "icon": "fa fa-codepen", "class": null, "title": "Tipos de controllers"}', 3, NULL, 1, 5, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('4bd38d1d-f214-485f-b786-8fac27f4a4ce', 'b14a3eee-e253-416e-af62-12c313b62db7', 1, 3, '{"href": "{BASE_URL}controllers/acoes-controllers", "icon": "fa fa-adn", "class": null, "title": "Ações de controllers"}', 3, NULL, 1, 5, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('911bf8f0-fa9f-48ed-a149-35c5daaebaa9', 'b14a3eee-e253-416e-af62-12c313b62db7', 1, 4, '{"href": "{BASE_URL}controllers/permissoes-acoes-controllers", "icon": "fa fa-expeditedssl", "class": null, "title": "Permissões de ações"}', 3, NULL, 1, NULL, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('6dba12ba-951f-4989-8f71-9ad28989230f', '8ca5f073-1c04-4b0d-8d32-8b929c417233', 1, 1, '{"href": "{BASE_URL}entidades/entidades", "icon": "fa fa-building-o", "class": null, "title": "Entidades"}', 3, NULL, 1, NULL, true, true, false) ON CONFLICT (id) DO NOTHING;

INSERT INTO sistema.menus_itens
(id, id_item_pai, sistema_menus_id, ordem, atributos, sistema_tipos_controllers_id, sistema_controllers_acoes_id, sistema_modulos_id, sistema_controllers_id, admin_node, can_edit, can_delete)
VALUES('2adf7a12-eb3a-4570-82e1-97b55217d9d2', '8ca5f073-1c04-4b0d-8d32-8b929c417233', 1, 2, '{"href": "{BASE_URL}entities/sections", "icon": "fa fa-connectdevelop", "class": null, "title": "Seções de trabalho"}', 3, NULL, 1, 5, true, true, false) ON CONFLICT (id) DO NOTHING;
