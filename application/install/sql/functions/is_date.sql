
--is_date
CREATE OR REPLACE FUNCTION public.is_date(s character varying)
 RETURNS boolean
 LANGUAGE plpgsql
AS $function$
begin
  perform s::date;
  return true;
exception when others then
  return false;
end;
$function$
;
