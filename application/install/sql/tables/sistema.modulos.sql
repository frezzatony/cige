--MODULOS
CREATE TABLE IF NOT EXISTS  sistema.modulos (
	id serial NOT NULL,
	descricao varchar NOT NULL,
	CONSTRAINT modulos_pk PRIMARY KEY (id)
);

--MODULOS_logs
CREATE TABLE IF NOT EXISTS sistema_logs.sistema_modulos (
	id serial NOT NULL,
	item_id int4 NOT NULL,
	last_update timestamp NULL,
	log jsonb NULL,
	CONSTRAINT sistema_modulos_pk PRIMARY KEY (id)
);

ALTER TABLE sistema_logs.sistema_modulos DROP CONSTRAINT IF EXISTS sistema_modulos_fk_sistema_modulos;
ALTER TABLE sistema_logs.sistema_modulos ADD CONSTRAINT sistema_modulos_fk_sistema_modulos FOREIGN KEY (item_id) REFERENCES sistema.modulos(id) ON UPDATE CASCADE;