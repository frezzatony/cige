--USUARIOS
CREATE TABLE IF NOT EXISTS usuarios.usuarios (
	id serial NOT NULL,
	usuario varchar NOT NULL,
	senha varchar NULL,
	email varchar NULL,
	ativo bool NULL DEFAULT true,
	nome varchar NULL,
	configs jsonb NULL DEFAULT '{}'::jsonb,
	can_delete bool NULL DEFAULT true,
	CONSTRAINT usuarios_pkey1 PRIMARY KEY (id)
);

--USUARIOS_logs
CREATE TABLE IF NOT EXISTS usuarios_logs.usuarios_usuarios (
	id serial NOT NULL,
	item_id int4 NOT NULL,
	last_update timestamp NULL,
	log jsonb NULL,
	CONSTRAINT pk_log_usuarios_usuarios_id PRIMARY KEY (id, item_id)
);

