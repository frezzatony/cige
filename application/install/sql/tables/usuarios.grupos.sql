--GRUPOS
CREATE TABLE IF NOT EXISTS usuarios.grupos (
	id serial NOT NULL,
	nome varchar NULL,
	descricao varchar NULL,
	ativo bool NULL,
	administrador bool NULL,
    can_delete bool NULL DEFAULT true,
	CONSTRAINT grupos_pkey PRIMARY KEY (id)
);

--GRUPOS_logs
CREATE TABLE IF NOT EXISTS usuarios_logs.usuarios_grupos (
	id serial NOT NULL,
	item_id int4 NOT NULL,
	last_update timestamp NULL,
	log jsonb NULL,
	CONSTRAINT pk_log_usuarios_gruposs_id PRIMARY KEY (id, item_id)
);

--USUARIOS_GRUPOS
CREATE TABLE IF NOT EXISTS usuarios.usuarios_grupos (
	id serial NOT NULL,
	usuarios_usuarios_id int4 NULL,
	usuarios_grupos_id int4 NULL,
	CONSTRAINT usuarios_grupos_pkey PRIMARY KEY (id)
);

ALTER TABLE usuarios.usuarios_grupos DROP CONSTRAINT IF EXISTS usuarios_grupos_fk_grupos;
ALTER TABLE usuarios.usuarios_grupos ADD CONSTRAINT usuarios_grupos_fk_grupos FOREIGN KEY (usuarios_grupos_id) REFERENCES usuarios.grupos(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE usuarios.usuarios_grupos DROP CONSTRAINT IF EXISTS usuarios_grupos_fk_usuarios;
ALTER TABLE usuarios.usuarios_grupos ADD CONSTRAINT usuarios_grupos_fk_usuarios FOREIGN KEY (usuarios_usuarios_id) REFERENCES usuarios.usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE;