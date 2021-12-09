
--MENUS
CREATE TABLE IF NOT EXISTS sistema.menus (
	id serial NOT NULL,
	nome varchar(40) NULL,
	CONSTRAINT menus_pkey PRIMARY KEY (id)
);

--MENUS_logs
CREATE TABLE IF NOT EXISTS sistema_logs.sistema_menus (
	id serial NOT NULL,
	item_id int4 NOT NULL,
	last_update timestamp NULL,
	log jsonb NULL,
	CONSTRAINT sistema_menus_pk PRIMARY KEY (id)
);
ALTER TABLE sistema_logs.sistema_menus DROP CONSTRAINT IF EXISTS sistema_menus_fk_sistema_menus;
ALTER TABLE sistema_logs.sistema_menus ADD CONSTRAINT sistema_menus_fk_sistema_menus FOREIGN KEY (item_id) REFERENCES sistema.menus(id) ON UPDATE CASCADE;

--MENUS_ITENS
CREATE TABLE IF NOT EXISTS sistema.menus_itens (
	id uuid NOT NULL,
	id_item_pai uuid NULL,
	sistema_menus_id int4 NULL,
	ordem int4 NULL,
	atributos jsonb NULL,
	sistema_tipos_controllers_id int4 NULL,
	sistema_controllers_acoes_id int4 NULL,
	sistema_modulos_id int4 NULL,
	sistema_controllers_id int4 NULL,
	admin_node bool NULL DEFAULT false,
	can_edit bool NULL DEFAULT true,
	can_delete bool NULL DEFAULT true,
	CONSTRAINT menus_itens_pkey PRIMARY KEY (id)
);
CREATE INDEX IF NOT EXISTS fki_fk_menus_itens_menus ON sistema.menus_itens USING btree (sistema_menus_id);

ALTER TABLE sistema.menus_itens DROP CONSTRAINT IF EXISTS menus_itens_fk_controllers;
ALTER TABLE sistema.menus_itens ADD CONSTRAINT menus_itens_fk_controllers FOREIGN KEY (sistema_tipos_controllers_id) REFERENCES sistema.tipos_controllers(id) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE sistema.menus_itens DROP CONSTRAINT IF EXISTS menus_itens_fk_controllers_acoes;
ALTER TABLE sistema.menus_itens ADD CONSTRAINT menus_itens_fk_controllers_acoes FOREIGN KEY (sistema_controllers_acoes_id) REFERENCES sistema.controllers_acoes(id) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE sistema.menus_itens DROP CONSTRAINT IF EXISTS menus_itens_fk_menus_itens_pai;
ALTER TABLE sistema.menus_itens ADD CONSTRAINT menus_itens_fk_menus_itens_pai FOREIGN KEY (id_item_pai) REFERENCES sistema.menus_itens(id) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE sistema.menus_itens DROP CONSTRAINT IF EXISTS menus_itens_fk_sistema_modulos;
ALTER TABLE sistema.menus_itens ADD CONSTRAINT menus_itens_fk_sistema_modulos FOREIGN KEY (sistema_modulos_id) REFERENCES sistema.modulos(id) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE sistema.menus_itens DROP CONSTRAINT IF EXISTS menus_itens_fk_tipos_controllers;
ALTER TABLE sistema.menus_itens ADD CONSTRAINT menus_itens_fk_tipos_controllers FOREIGN KEY (sistema_tipos_controllers_id) REFERENCES sistema.tipos_controllers(id) ON UPDATE CASCADE ON DELETE RESTRICT;
