SELECT
    ORGANIZATION_ID ID,
    name Libelle,
    ATTRIBUTE4 Centre_Resp,
    TYPE Type
FROM
    Hr_Organization_units
WHERE
--     type IN ('DIRP','DEL','DIR','DG') AND
    DATE_TO IS NULL
