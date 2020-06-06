<?php
    $nurses_sql = "SELECT * FROM nurse";
    $last_nurse_id = "SELECT id_nurse FROM nurse ORDER BY id_nurse DESC LIMIT 1";
    $nurse_wards = "SELECT fid_ward FROM nurse_ward WHERE fid_nurse = :id_nurse";
    $department_nurses = "SELECT id_nurse FROM nurse WHERE department = :department";
    $shift_info = "SELECT id_nurse, id_ward FROM nurse join nurse_ward on nurse.id_nurse = nurse_ward.fid_nurse join ward on ward.id_ward = nurse_ward.fid_ward WHERE shift = :shift";
    $wards_sql = "SELECT * FROM ward";
    $last_ward_id = "SELECT id_ward FROM ward ORDER BY id_ward DESC LIMIT 1";

    $insert_nurse = "INSERT INTO nurse (id_nurse, name, date, department, shift) VALUES (?,?,?,?,?)";
    $insert_ward = "INSERT INTO ward (id_ward, name) VALUES (?,?)";
    $insert_nurse_ward = "INSERT INTO nurse_ward (fid_nurse, fid_ward) VALUES (?,?)";
?>