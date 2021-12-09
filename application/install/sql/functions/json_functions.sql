

--json_funcitons


CREATE OR REPLACE FUNCTION public.json_object_set_key(json json, key_to_set text, value_to_set anyelement)
 RETURNS json
 LANGUAGE sql
 IMMUTABLE STRICT
AS $function$
SELECT concat('{', string_agg(to_json("key") || ':' || "value", ','), '}')::json
  FROM (SELECT *
          FROM json_each("json")
         WHERE "key" <> "key_to_set"
         UNION ALL
        SELECT "key_to_set", to_json("value_to_set")) AS "fields"
$function$
;

CREATE OR REPLACE FUNCTION public.json_object_set_keys(json json, keys_to_set text[], values_to_set anyarray)
 RETURNS json
 LANGUAGE sql
 IMMUTABLE STRICT
AS $function$
SELECT concat('{', string_agg(to_json("key") || ':' || "value", ','), '}')::json
  FROM (SELECT *
          FROM json_each("json")
         WHERE "key" <> ALL ("keys_to_set")
         UNION ALL
        SELECT DISTINCT ON ("keys_to_set"["index"])
               "keys_to_set"["index"],
               CASE
                 WHEN "values_to_set"["index"] IS NULL THEN 'null'::json
                 ELSE to_json("values_to_set"["index"])
               END
          FROM generate_subscripts("keys_to_set", 1) AS "keys"("index")
          JOIN generate_subscripts("values_to_set", 1) AS "values"("index")
         USING ("index")) AS "fields"
$function$
;
