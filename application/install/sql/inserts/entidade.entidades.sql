
--ENTIDADES
INSERT INTO entidade.entidades
(id, entidade_entidades_id, descricao, abreviatura, ativo, principal, can_delete)
VALUES(1, NULL, 'ENTIDADE PRINCIPAL', 'ENT PRINC', true, true, false)
ON CONFLICT (id) DO NOTHING;
