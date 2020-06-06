<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ITech lab2</title>
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
        Get nurse's wards:
        <form action="get_wards.php" method="post" id="get-wards-form">
            Nurse name: <input type="text" name="nurse" required>
            <input type="submit">
        </form>
        <div id="wards-container"></div>
        <hr/>

        Get department nurses:
        <form action="get_nurses.php" method="post" id="get-nurses-form">
            Department: <input type="number" name="department" min="0" required>
            <input type="submit">
        </form>
        <div id="nurses-container"></div>
        <hr/>

        Get shift info:
        <form action="get_shift_info.php" method="post" id="get-shift-info-form">
            Shift: 
                <select name="shift" required>
                    <option>first</option>
                    <option>second</option>
                    <option>third</option>
                    <option>fourth</option>
                </select>
            Department: <input type="number" name="department" min="0" required>
            <input type="submit">
        </form>
        <div id="shift-info-container"></div>

        <script>
            $(document).on('submit', '#get-nurses-form', function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'get_nurses.php',
                    data: {
                        'department': $(this).find('input[name="department"]').val()
                    },
                    method: 'post'
                }).done(function (response) {
                    $('#nurses-container').html(response);
                }).fail(function () {
                    alert('Error.');
                });
            });
            $(document).on('submit', '#get-wards-form', function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'get_wards.php',
                    data: {
                        'nurses': $(this).find('input[name="nurse"]').val()
                    },
                    method: 'post'
                }).done(function (response) {
                    $('#wards-container').html(response);
                }).fail(function () {
                    alert('Error.');
                });
            });
            $(document).on('submit', '#get-shift-info-form', function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'get_shift_info.php',
                    data: {
                        'shift': $(this).find('select[name="shift"]').val(),
                        'department': $(this).find('input[name="department"]').val()
                    },
                    method: 'post'
                }).done(function (response) {
                    $('#shift-info-container').html(response);
                }).fail(function () {
                    alert('Error.');
                });
            });
        </script>
    </body>
</html>
