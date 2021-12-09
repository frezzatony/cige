--PERMISSOES
CREATE TABLE IF NOT EXISTS sistema.permissoes (
	id serial NOT NULL,
	descricao varchar(140) NULL,
	contempla_ids jsonb NULL,
	CONSTRAINT permissoes_pkey PRIMARY KEY (id)
);

--PERMISSOES_logs
CREATE TABLE IF NOT EXISTS sistema_logs.sistema_permissoes (
	id serial NOT NULL,
	item_id int4 NOT NULL,
	last_update timestamp NULL,
	log jsonb NULL,
	CONSTRAINT sistema_permissoes_pk PRIMARY KEY (id)
);
ALTER TABLE sistema_logs.sistema_permissoes DROP CONSTRAINT IF EXISTS sistema_permissoes_fk_permissoes;
ALTER TABLE sistema_logs.sistema_permissoes ADD CONSTRAINT sistema_permissoes_fk_permissoes FOREIGN KEY (item_id) REFERENCES sistema.permissoes(id) ON UPDATE CASCADE;