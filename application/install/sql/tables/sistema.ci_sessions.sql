
CREATE TABLE IF NOT EXISTS sistema.ci_sessions (
	session_id varchar(40) NOT NULL DEFAULT '0'::character varying,
	ip_address varchar(45) NOT NULL DEFAULT '0'::character varying,
	last_activity int8 NOT NULL DEFAULT 0,
	"data" text NOT NULL,
	"timestamp" int4 NULL,
	id varchar(128) NULL
);
CREATE INDEX IF NOT EXISTS last_activity_idx ON sistema.ci_sessions USING btree (last_activity);
