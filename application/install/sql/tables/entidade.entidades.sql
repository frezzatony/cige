
CREATE TABLE IF NOT EXISTS entidade.entidades (
	id serial NOT NULL,
	entidade_entidades_id int4 NULL,
	descricao varchar(60) NULL,
	abreviatura varchar(20) NULL,
	ativo bool NULL,
	principal bool NULL DEFAULT false,
    can_delete bool NULL DEFAULT true,
	CONSTRAINT pk_entidade_entidades_id PRIMARY KEY (id)
);

--LOGS
CREATE TABLE IF NOT EXISTS entidade_logs.entidade_entidades (
	id serial NOT NULL,
	item_id int4 NOT NULL,
	last_update timestamp NULL,
	log jsonb NULL,
	CONSTRAINT pk_log_entidade_logs_id PRIMARY KEY (id, item_id)
);
ALTER TABLE entidade_logs.entidade_entidades  DROP CONSTRAINT IF EXISTS entidade_entidades_fk_entidades;
ALTER TABLE entidade_logs.entidade_entidades ADD CONSTRAINT entidade_entidades_fk_entidades FOREIGN KEY (id) REFERENCES entidade.entidades(id) ON UPDATE CASCADE;