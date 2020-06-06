<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ITech lab3</title>
        <style>
            .active {
                background-color: #d5d5d5;
            }
        </style>
        <script
            src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
            crossorigin="anonymous"
        ></script>
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
                    <table border="1" id="nurses-table">
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
                                data-id="<?php echo $row['id_nurse'] ?>"
                                <?php
                                    if (in_array($row['id_nurse'], $selected_nurses)) {
                                        echo 'class="active"';
                                    }
                                ?>
                            >
                                <td><?php echo $row['id_nurse'] ?></td>
                                <td>
                                    <a href="?id_nurse=<?php echo $row['id_nurse'] ?>"
                                        title="Click to see nurse's wards"
                                        class="filter-rows-html"
                                    >
                                        <?php echo $row['name'] ?>
                                    </a>
                                </td>
                                <td><?php echo $row['date'] ?></td>
                                <td>
                                    <a href="?department_nurses=true&department=<?php echo $row['department'] ?>"
                                        title="Click to see department's nurses"
                                        class="filter-rows-xml"
                                    >
                                        <?php echo $row['department'] ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="?shift_info=true&shift=<?php echo $row['shift'] ?>"
                                        title="Click to see shift info"
                                        class="filter-rows-json"
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
                    <form id="add-nurse-form" action="insert_nurse.php" method="post">
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
                        </select><br>
                        <input type="submit">
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" id="wards-table">
                        <caption>Wards Table</caption>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Add nurse</th>
                        </tr>
                        <?php foreach ($dbh->query($wards_sql) as $row) { ?>
                            <tr
                                data-id="<?php echo $row['id_ward'] ?>"
                                <?php
                                    if (in_array($row['id_ward'], $selected_wards)) {
                                        echo 'class="active"';
                                    }
                                ?>
                            >
                                <td><?php echo $row['id_ward'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td>
                                    <form id="add-nurse-ward-form" action="insert_nurse_ward.php" method="post">
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
                    <form id="add-ward-form" action="insert_ward.php" method="post">
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

        <script>
            $(document).on('click', '.filter-rows-html', function (e) {
                e.preventDefault();
                var url_params = $(this).attr('href');
                $('#nurses-table').find('tr').removeClass('active');
                $('#wards-table').find('tr').removeClass('active');
                $.ajax({
                    url: 'get_wards.php' + url_params
                }).done(function (response) {
                    $('#wards-table').html(response);
                }).fail(function () {
                    alert('Error occured.');
                });
            });

            $(document).on('click', '.filter-rows-xml', function (e) {
                e.preventDefault();
                var url_params = $(this).attr('href');

                $('#nurses-table').find('tr').removeClass('active');
                $('#wards-table').find('tr').removeClass('active');
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4) {
                        if (xmlhttp.status == 200) {
                            var xmlDoc = xmlhttp.responseXML;
                            var rows = xmlDoc.firstChild.children;
                            for (var i = 0; i < rows.length; i++) {
                                $('#nurses-table').find('tr[data-id="' + rows[i].textContent + '"]').addClass('active');
                            }
                        }
                    }
                }
                xmlhttp.open("GET", 'get_nurses.php' + url_params, true);
                xmlhttp.send();
            });

            $(document).on('click', '.filter-rows-json', function (e) {
                e.preventDefault();
                var url_params = $(this).attr('href');
                $('#nurses-table').find('tr').removeClass('active');
                $('#wards-table').find('tr').removeClass('active');
                $.ajax({
                    url: 'get_shift_info.php' + url_params,
                    dataType: 'json'
                }).done(function (response) {
                    response['nurses'].forEach(function (id) {
                        $('#nurses-table').find('tr[data-id="' + id + '"]').addClass('active');
                    });
                    response['wards'].forEach(function (id) {
                        $('#wards-table').find('tr[data-id="' + id + '"]').addClass('active');
                    });
                }).fail(function () {
                    alert('Error occured.');
                });
            });

            $('#add-nurse-form').on('submit', function (e) {
                e.preventDefault();
                var $fields = $(this).find('input[name]'),
                    form_data = {};
                $fields.each(function () {
                    form_data[$(this).attr('name')] = $(this).val();
                });
                $.ajax({
                    url: 'insert_nurse.php',
                    data: form_data,
                    method: 'post'
                }).done(function (response) {
                    alert(response);
                    $('#nurses-table').append(
                        '<tr>' +
                            '<td>' + form_data['id_nurse'] + '</td>' +
                            '<td><a href="index.php?nurse_wards=true&id_nurse=' + form_data['id_nurse'] + '" title="Click to see nurse\'s wards">' + form_data['name'] + '</a></td>' +
                            '<td>' + form_data['date'] + '</td>' +
                            '<td><a href="index.php?department_nurses=true&department=' + form_data['department'] + '" title="Click to see department\'s nurses">' + form_data['department'] + '</a></td>' +
                            '<td><a href="index.php?shift_info=true&shift=' + form_data['shift'] + '" title="Click to see shift info">' + form_data['shift'] + '</a></td>' +
                        '</tr>'
                    );
                    $fields.each(function () {
                        if ($(this).attr('name') === 'id_nurse') {
                            $(this).val(parseInt(form_data['id_nurse']) + 1);
                        } else {
                            $(this).val('');
                        }
                    });
                }).fail(function () {
                    alert('Cannot add nurse due to error.');
                });
            });

            $('#add-nurse-form').on('submit', function (e) {
                e.preventDefault();
                var $fields = $(this).find('input[name]'),
                    form_data = {};
                $fields.each(function () {
                    form_data[$(this).attr('name')] = $(this).val();
                });
                $.ajax({
                    url: 'insert_nurse.php',
                    data: form_data,
                    method: 'post'
                }).done(function (response) {
                    alert(response);
                    $('#nurses-table').append(
                        '<tr>' +
                            '<td>' + form_data['id_nurse'] + '</td>' +
                            '<td><a href="index.php?nurse_wards=true&id_nurse=' + form_data['id_nurse'] + '" title="Click to see nurse\'s wards">' + form_data['name'] + '</a></td>' +
                            '<td>' + form_data['date'] + '</td>' +
                            '<td><a href="index.php?department_nurses=true&department=' + form_data['department'] + '" title="Click to see department\'s nurses">' + form_data['department'] + '</a></td>' +
                            '<td><a href="index.php?shift_info=true&shift=' + form_data['shift'] + '" title="Click to see shift info">' + form_data['shift'] + '</a></td>' +
                        '</tr>'
                    );
                    $fields.each(function () {
                        if ($(this).attr('name') === 'id_nurse') {
                            $(this).val(parseInt(form_data['id_nurse']) + 1);
                        } else {
                            $(this).val('');
                        }
                    });
                }).fail(function () {
                    alert('Cannot add nurse due to error.');
                });
            });

            $('#add-ward-form').on('submit', function (e) {
                e.preventDefault();
                var $fields = $(this).find('input[name]'),
                    form_data = {};
                $fields.each(function () {
                    form_data[$(this).attr('name')] = $(this).val();
                });
                $.ajax({
                    url: 'insert_ward.php',
                    data: form_data,
                    method: 'post'
                }).done(function (response) {
                    alert(response);
                    $('#wards-table').append(
                        '<tr>' +
                            '<td>' + form_data['id_ward'] + '</td>' +
                            '<td>' + form_data['name'] + '</td>' +
                            '<td>' +
                                '<form id="add-nurse-ward-form" action="insert_nurse_ward.php" method="post">' +
                                    '<input type="hidden" name="id_ward" value="' + form_data['id_ward'] + '">' +
                                    '<input type="number" name="id_nurse" placeholder="Nurse Id" min="0" required>' +
                                    '<input type="submit">' +
                                '</form>' +
                            '</td>' +
                        '</tr>'
                    );
                    $fields.each(function () {
                        if ($(this).attr('name') === 'id_ward') {
                            $(this).val(parseInt(form_data['id_ward']) + 1);
                        } else {
                            $(this).val('');
                        }
                    });
                }).fail(function () {
                    alert('Cannot add ward due to error.');
                });
            });

            $(document).on('submit', '#add-nurse-ward-form', function (e) {
                e.preventDefault();
                var $fields = $(this).find('input[name]'),
                    form_data = {};
                $fields.each(function () {
                    form_data[$(this).attr('name')] = $(this).val();
                });
                $.ajax({
                    url: 'insert_nurse_ward.php',
                    data: form_data,
                    method: 'post'
                }).done(function (response) {
                    alert(response);
                    $fields.each(function () {
                        if ($(this).attr('name') === 'id_ward') {
                            $(this).val(parseInt(form_data['id_ward']) + 1);
                        } else {
                            $(this).val('');
                        }
                    });
                }).fail(function () {
                    alert('Cannot add ward due to error.');
                });
            });
        </script>
    </body>
</html>