--TIPOS_CONTROLLERS
CREATE TABLE IF NOT EXISTS sistema.tipos_controllers (
	id serial NOT NULL,
	descricao varchar(140) NULL,
	CONSTRAINT controllers_pkey PRIMARY KEY (id)
);

--TIPOS_CONTROLLERS_logs
CREATE TABLE IF NOT EXISTS sistema_logs.sistema_tipos_controllers (
	id serial NOT NULL,
	item_id int4 NOT NULL,
	last_update timestamp NULL,
	log jsonb NULL,
	CONSTRAINT sistema_tipos_controllers_pk PRIMARY KEY (id)
);
ALTER TABLE sistema_logs.sistema_tipos_controllers DROP CONSTRAINT IF EXISTS sistema_tipos_controllers_fk_tipos_controllers;
ALTER TABLE sistema_logs.sistema_tipos_controllers ADD CONSTRAINT sistema_tipos_controllers_fk_tipos_controllers FOREIGN KEY (item_id) REFERENCES sistema.tipos_controllers(id) ON UPDATE CASCADE;

--CONTROLLERS
CREATE TABLE IF NOT EXISTS sistema.controllers (
	id serial NOT NULL,
	sistema_tipos_controllers_id int4 NOT NULL,
	ativo bool NULL DEFAULT true,
	descricao_singular varchar NULL,
	descricao_plural varchar NULL,
	url varchar NULL,
	atributos jsonb NULL,
	controller varchar NULL,
	can_delete bool NULL DEFAULT true,
	CONSTRAINT controllers_pk PRIMARY KEY (id)
);
ALTER TABLE sistema.controllers DROP CONSTRAINT IF EXISTS controllers_fk_tipos_controllers;
ALTER TABLE sistema.controllers ADD CONSTRAINT controllers_fk_tipos_controllers FOREIGN KEY (sistema_tipos_controllers_id) REFERENCES sistema.tipos_controllers(id) ON UPDATE CASCADE ON DELETE RESTRICT;

--CONTROLLERS_log
CREATE TABLE IF NOT EXISTS sistema_logs.sistema_controllers (
	id serial NOT NULL,
	item_id int4 NOT NULL,
	last_update timestamp NULL,
	log jsonb NULL,
	CONSTRAINT sistema_controllers_pk PRIMARY KEY (id)
);
ALTER TABLE sistema_logs.sistema_controllers DROP CONSTRAINT IF EXISTS sistema_controllers_fk_controllers;
ALTER TABLE sistema_logs.sistema_controllers ADD CONSTRAINT sistema_controllers_fk_controllers FOREIGN KEY (item_id) REFERENCES sistema.controllers(id) ON UPDATE CASCADE;

--CONTROLLERS_ACOES
CREATE TABLE IF NOT EXISTS sistema.controllers_acoes (
	id serial NOT NULL,
	sistema_controllers_id int4 NULL,
	descricao varchar NULL,
	sistema_permissoes_id int4 NOT NULL,
	CONSTRAINT controllers_acoes_pkey PRIMARY KEY (id)
);
ALTER TABLE sistema.controllers_acoes DROP CONSTRAINT IF EXISTS controllers_acoes_fk_controllers;
ALTER TABLE sistema.controllers_acoes ADD CONSTRAINT controllers_acoes_fk_controllers FOREIGN KEY (sistema_controllers_id) REFERENCES sistema.controllers(id) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE sistema.controllers_acoes DROP CONSTRAINT IF EXISTS controllers_acoes_fk_permissoes;
ALTER TABLE sistema.controllers_acoes ADD CONSTRAINT controllers_acoes_fk_permissoes FOREIGN KEY (sistema_permissoes_id) REFERENCES sistema.permissoes(id) ON UPDATE CASCADE ON DELETE RESTRICT;

--CONTROLLERS_ACOES_log
CREATE TABLE IF NOT EXISTS sistema_logs.sistema_controllers_acoes (
	id serial NOT NULL,
	item_id int4 NOT NULL,
	last_update timestamp NULL,
	log jsonb NULL,
	CONSTRAINT pk_log_sistema_controllers_acoes_id PRIMARY KEY (id, item_id)
);

--CONTROLLERS_ACOES_FILHAS
CREATE TABLE IF NOT EXISTS sistema.controllers_acoes_filhas (
	id int4 NULL,
	sistema_controllers_acoes_id int4 NOT NULL,
	sistema_controllers_acoes_id_filha int4 NOT NULL
);
ALTER TABLE sistema.controllers_acoes_filhas DROP CONSTRAINT IF EXISTS controllers_acoes_filhas_fk_acoes;
ALTER TABLE sistema.controllers_acoes_filhas ADD CONSTRAINT controllers_acoes_filhas_fk_acoes FOREIGN KEY (sistema_controllers_acoes_id) REFERENCES sistema.controllers_acoes(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE sistema.controllers_acoes_filhas DROP CONSTRAINT IF EXISTS controllers_acoes_filhas_fk_acoes_filhas;
ALTER TABLE sistema.controllers_acoes_filhas ADD CONSTRAINT controllers_acoes_filhas_fk_acoes_filhas FOREIGN KEY (sistema_controllers_acoes_id_filha) REFERENCES sistema.controllers_acoes(id) ON UPDATE CASCADE ON DELETE CASCADE;


--CONTROLLERS_PERMISSOES_ACOES
CREATE TABLE IF NOT EXISTS sistema.controllers_permissoes_acoes (
	id serial NOT NULL,
	sistema_controllers_acoes_id int4 NOT NULL,
	usuarios_grupos_id int4 NOT NULL,
	entidade_entidades_id int4 NOT NULL,
	CONSTRAINT controllers_permissoes_acoes_pk PRIMARY KEY (id)
);

ALTER TABLE sistema.controllers_permissoes_acoes  DROP CONSTRAINT IF EXISTS controllers_permissoes_acoes_fk_controllers_acoes;
ALTER TABLE sistema.controllers_permissoes_acoes ADD CONSTRAINT controllers_permissoes_acoes_fk_controllers_acoes FOREIGN KEY (sistema_controllers_acoes_id) REFERENCES sistema.controllers(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE sistema.controllers_permissoes_acoes  DROP CONSTRAINT IF EXISTS controllers_permissoes_acoes_fk_entidades_entidade;
ALTER TABLE sistema.controllers_permissoes_acoes ADD CONSTRAINT controllers_permissoes_acoes_fk_entidades_entidade FOREIGN KEY (entidade_entidades_id) REFERENCES entidade.entidades(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE sistema.controllers_permissoes_acoes  DROP CONSTRAINT IF EXISTS controllers_permissoes_acoes_fk_usuarios_grupos;
ALTER TABLE sistema.controllers_permissoes_acoes ADD CONSTRAINT controllers_permissoes_acoes_fk_usuarios_grupos FOREIGN KEY (usuarios_grupos_id) REFERENCES usuarios.grupos(id) ON UPDATE CASCADE ON DELETE CASCADE;


--CONTROLLERS_PERMISSOES_ACOES_log
CREATE TABLE IF NOT EXISTS sistema_logs.sistema_controllers_permissoes_acoes (
	id serial NOT NULL,
	item_id int4 NOT NULL,
	last_update timestamp NULL,
	log jsonb NULL,
	CONSTRAINT sistema_controllers_permissoes_acoes_pk_controllers_permissoes_ PRIMARY KEY (id)
);
ALTER TABLE sistema_logs.sistema_controllers_permissoes_acoes  DROP CONSTRAINT IF EXISTS sistema_controllers_permissoes_acoes_fk_permissoes_acoes;
ALTER TABLE sistema_logs.sistema_controllers_permissoes_acoes ADD CONSTRAINT sistema_controllers_permissoes_acoes_fk_permissoes_acoes FOREIGN KEY (item_id) REFERENCES sistema.controllers_permissoes_acoes(id) ON UPDATE CASCADE;
