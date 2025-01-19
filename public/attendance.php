<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }

        form {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h2>Mark Attendance</h2>
    <form action="attendance.php" method="post">
        <div class="form-group">
            <label for="admission_no">Admission Number:</label>
            <input type="number" id="admission_no" name="admission_no" required>
        </div>
        <div class="form-group">
            <label for="course_id">Course ID:</label>
            <input type="number" id="course_id" name="course_id" required>
        </div>
        <div class="form-group">
            <label for="attendance_date">Date:</label>
            <input type="date" id="attendance_date" name="attendance_date" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
            </select>
        </div>
        <div class="form-group" id="reason-group" style="display:none;">
            <label for="reason">Reason for Absence:</label>
            <textarea id="reason" name="reason"></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>

    <script>
        document.getElementById('status').addEventListener('change', function () {
            var reasonGroup = document.getElementById('reason-group');
            if (this.value === 'Absent') {
                reasonGroup.style.display = 'block';
            } else {
                reasonGroup.style.display = 'none';
            }
        });
    </script>
</body>

</html>