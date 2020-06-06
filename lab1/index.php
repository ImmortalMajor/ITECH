<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ITech lab1</title>
        <style>
            .active {
                background-color: #d5d5d5;
            }
        </style>
    </head>
    <body>
        <?php
            include 'config.php';
            include 'queries.php';

            $selected_wards = array();
            if (isset($_GET['nurse_wards'])) {
                $stmt = $dbh->prepare($nurse_wards);
                $stmt->execute(array('id_nurse'=>$_GET['id_nurse']));
                foreach ($stmt->fetchAll() as $row) {
                    array_push($selected_wards, $row['fid_ward']);
                }
            }

            $selected_nurses = array();
            if (isset($_GET['department_nurses'])) {
                $stmt = $dbh->prepare($department_nurses);
                $stmt->execute(array('department'=>$_GET['department']));
                foreach ($stmt->fetchAll() as $row) {
                    array_push($selected_nurses, $row['id_nurse']);
                }
            }

            if (isset($_GET['shift_info'])) {
                $stmt = $dbh->prepare($shift_info);
                $stmt->execute(array('shift'=>$_GET['shift']));
                foreach ($stmt->fetchAll() as $row) {
                    array_push($selected_nurses, $row['id_nurse']);
                    array_push($selected_wards, $row['id_ward']);
                }
            }
        ?>

        <table>
            <tr>
                <td>
                    <table border="1">
                        <caption>Nurses Table</caption>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Department</th>
                            <th>Shift</th>
                        </tr>
                        <?php foreach ($dbh->query($nurses_sql) as $row) { ?>
                            <tr
                                <?php
                                    if (in_array($row['id_nurse'], $selected_nurses)) {
                                        echo 'class="active"';
                                    }
                                ?>
                            >
                                <td><?php echo $row['id_nurse'] ?></td>
                                <td>
                                    <a href="index.php?nurse_wards=true&id_nurse=<?php echo $row['id_nurse'] ?>"
                                        title="Click to see nurse's wards"
                                    >
                                        <?php echo $row['name'] ?>
                                    </a>
                                </td>
                                <td><?php echo $row['date'] ?></td>
                                <td>
                                    <a href="index.php?department_nurses=true&department=<?php echo $row['department'] ?>"
                                        title="Click to see department's nurses"
                                    >
                                        <?php echo $row['department'] ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="index.php?shift_info=true&shift=<?php echo $row['shift'] ?>"
                                        title="Click to see shift info"
                                    >
                                        <?php echo $row['shift'] ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
                <td>
                    <h4>Add nurse</h4>
                    <form action="insert_nurse.php" method="post">
                        <?php
                            $stmt = $dbh->prepare($last_nurse_id);
                            $stmt->execute();
                            $result = $stmt->fetch();
                        ?>
                        <input type="hidden" name="id_nurse" value="<?php echo $result['id_nurse'] + 1 ?>">
                        Name: <input type="text" name="name" required><br>
                        Date: <input type="date" name="date" required><br>
                        Department: <input type="number" name="department" min="1" required><br>
                        Shift: 
                        <select name="shift" required>
                            <option>First</option>
                            <option>Second</option>
                            <option>Third</option>
                            <option>Fourth</option>
                        </select>
                        <br>
                        <input type="submit">
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1">
                        <caption>Wards Table</caption>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Add nurse</th>
                        </tr>
                        <?php foreach ($dbh->query($wards_sql) as $row) { ?>
                            <tr
                                <?php
                                    if (in_array($row['id_ward'], $selected_wards)) {
                                        echo 'class="active"';
                                    }
                                ?>
                            >
                                <td><?php echo $row['id_ward'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td>
                                    <form action="insert_nurse_ward.php" method="post">
                                        <input type="hidden" name="id_ward" value="<?php echo $row['id_ward'] ?>">
                                        <input type="number" name="id_nurse" placeholder="Nurse Id" min="0" required>
                                        <input type="submit">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
                <td>
                    <h4>Add ward</h4>
                    <form action="insert_ward.php" method="post">
                        <?php
                            $stmt = $dbh->prepare($last_ward_id);
                            $stmt->execute();
                            $result = $stmt->fetch();
                        ?>
                        <input type="hidden" name="id_ward" value="<?php echo $result['id_ward'] + 1 ?>">
                        Name: <input type="text" name="name" required><br>
                        <input type="submit">
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>