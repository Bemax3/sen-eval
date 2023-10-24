SELECT
    pap.employee_number MATRICULE,
    pap.first_name PRENOM,
    pap.last_name NOM,
    org.name ORGANISATION,
    loc.location_code LIEU,
    pj.name FONCTION,
    pg.name GF,
    psp.spinal_point NR,
    HR_GENERAL.DECODE_POSITION_LATEST_NAME (PAAF.POSITION_ID) Poste
FROM
    per_all_people_f pap,
    pay_people_groups ppg,
    per_all_assignments_f paaf,
    per_grades pg,
    per_spinal_point_steps_f psps,
    per_spinal_point_placements_f pspp,
    per_spinal_points psp,
    per_jobs pj,
    PER_PERSON_TYPE_USAGES_x ptu,
    hr_organization_units org,
    hr_locations loc
WHERE
    pap.person_id = paaf.person_id  AND
    pg.grade_id = paaf.grade_id  AND
    pj.job_id(+) = paaf.job_id AND
    pap.person_id = ptu.person_id    AND
    ppg.people_group_id = paaf.people_group_id  AND
    org.organization_id = paaf.organization_id   AND
    loc.location_id = paaf.location_id   AND
    paaf.assignment_id = pspp.assignment_id  AND
    psp.spinal_point_id = psps.spinal_point_id  AND
    psps.step_id = pspp.step_id  AND
    pap.employee_number = :MATRICULE AND
    paaf.assignment_status_type_id IN ('1','45','46','43'  ) AND
    :eff_date  BETWEEN pap.effective_start_date  AND pap.effective_end_date AND
    :eff_date  BETWEEN paaf.effective_start_date AND paaf.effective_end_date AND
    :eff_date  BETWEEN pspp.effective_start_date AND pspp.effective_end_date AND
    :eff_date  BETWEEN psps.effective_start_date AND psps.effective_end_date
ORDER BY (pap.employee_number)
