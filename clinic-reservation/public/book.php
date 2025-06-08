<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$result = $conn->query("SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
    <link rel="stylesheet" href="reschedule.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('clinic3.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            margin-bottom: 25px;
            color: #222;
        }

        form table {
            margin: 0 auto;
            border-collapse: separate;
            border-spacing: 12px 20px;
            width: 380px;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        form table td {
            vertical-align: middle;
            text-align: left;
        }

        label {
            font-weight: 600;
            color: #444;
        }

        input[type="date"],
        select {
            width: 100%;
            padding: 8px 10px;
            font-size: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #e91e63;
            color: white;
            font-weight: 700;
            padding: 12px 0;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c2185b;
        }

        .error {
            color: #d32f2f;
            font-weight: 600;
            text-align: center;
            padding-bottom: 10px;
        }

        .back-link {
            color: #e91e63;
            font-weight: 600;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Book Appointment</h2>
    <form action="../actions/book_appointment.php" method="POST">
        <table>
            <tr>
                <td><label for="doctorSelect">Doctor:</label></td>
                <td>
                    <select name="doctor_id" id="doctorSelect" required onchange="updateTimeRange()">
                        <?php while ($doc = $result->fetch_assoc()): ?>
                            <option value="<?= $doc['id'] ?>"
                                    data-start="<?= $doc['start_time'] ?>"
                                    data-end="<?= $doc['end_time'] ?>">
                                <?= htmlspecialchars($doc['name']) ?> - <?= htmlspecialchars($doc['specialty']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="appointment_date">Date:</label></td>
                <td><input type="date" name="appointment_date" id="appointment_date" required></td>
            </tr>
            <tr>
                <td><label>Time:</label></td>
                <td>
                    <select name="hour" required id="hourSelect"></select> :
                    <select name="minute" required>
                        <?php for ($m = 0; $m < 60; $m++): ?>
                            <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($m, 2, '0', STR_PAD_LEFT) ?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="ampm" required id="ampmSelect">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <button type="submit">Confirm</button>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <a href="dashboard.php" class="back-link">Back</a>
                </td>
            </tr>
        </table>
    </form>

    <script>
    function updateTimeRange() {
        const doctorSelect = document.getElementById('doctorSelect');
        const selectedOption = doctorSelect.options[doctorSelect.selectedIndex];
        const startTime = selectedOption.getAttribute('data-start');
        const endTime = selectedOption.getAttribute('data-end');

        const startHour = parseInt(startTime.split(':')[0]);
        const endHour = parseInt(endTime.split(':')[0]);

        const hourSelect = document.getElementById('hourSelect');
        const ampmSelect = document.getElementById('ampmSelect');

        hourSelect.innerHTML = '';
        ampmSelect.innerHTML = '';

        let hasAM = false, hasPM = false;

        for (let h = startHour; h <= endHour; h++) {
            let displayHour = h % 12 || 12;
            let ampm = h < 12 ? 'AM' : 'PM';

            const option = document.createElement('option');
            option.value = displayHour;
            option.textContent = displayHour;
            hourSelect.appendChild(option);

            if (ampm === 'AM') hasAM = true;
            if (ampm === 'PM') hasPM = true;
        }

        if (hasAM) {
            const am = document.createElement('option');
            am.value = 'AM';
            am.text = 'AM';
            ampmSelect.appendChild(am);
        }

        if (hasPM) {
            const pm = document.createElement('option');
            pm.value = 'PM';
            pm.text = 'PM';
            ampmSelect.appendChild(pm);
        }
    }

    window.addEventListener('DOMContentLoaded', updateTimeRange);
    </script>
</body>
</html>