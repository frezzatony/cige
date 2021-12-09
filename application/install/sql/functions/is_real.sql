
--is_real
CREATE OR REPLACE FUNCTION public.is_real(s character varying)
 RETURNS boolean
 LANGUAGE plpgsql
AS $function$
begin
  perform s::real;
  return true;
exception when others then
  return false;
end;
$function$
;