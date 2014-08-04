<?php


include 'models/patient_model.php';

$patient_model = new patient_model();

$patients = $patient_model->list_all();

?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ARX Test - Patient Selection Page</title>
    <meta name="description" content="assistrx programming test">
    <meta name="author" content="assistrx-dw">

    <link rel="stylesheet" href="public/normalize.css">
    <link rel="stylesheet" href="public/styles.css?v=1.0">
</head>
<body>
    <nav>
        <a href="patients.php">All Patients</a> &bull;
        <a href="report.php">Report</a>
    </nav>


    <h1>Patient Listing</h1>

    <p>
        <label for="patient_filter">Filter by Name</label>
        <input type="text" name="patient_filter" />
    </p>

    <table id="patients">
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Phone</th>
            <th>Has Song</th>
            <th>Actions</th>
        </tr>

        <?php foreach($patients as $patient): ?>
            <tr class="patient">
                <td class="patient-name"><?php echo $patient->patient_name; ?></td>
                <td class="patient-age"><?php echo $patient->patient_age; ?></td>
                <td class="patient-phone"><?php echo $patient->patient_phone; ?></td>
                <td class="patient-has-song">
                    <?php echo empty($patient->favorite_song_id) ? 'NO' : 'YES'; ?>
                </td>
                <td class="patient-song">
                    <a href="songs.php?patient_id=<?php echo $patient->patient_id; ?>" title="Click to Assisgn a Song to <?php echo $patient->patient_name; ?>">
                        Assign Song
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>

    <!-- scripts at the bottom! -->
    <script src="public/jquery-1.9.1.min.js"></script>

    <!-- this script file is for global js -->
    <script src="public/script.js"></script>
</body>
</html>
