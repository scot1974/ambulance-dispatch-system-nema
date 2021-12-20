<?php require_once '../assets/core/init.php'; ?>
<?php
    if (isset($_POST['addAmb']) && $_POST['addAmb']) {
        $name = ucfirst(sanitize('name'));
        $location = strtolower(sanitize('location'));
        $desc = sanitize('desc');

        if ($system->addAmbulance($name, $location, $desc)) {
            $session->message("Ambulance Added Successfully.");
            echo 1;
        }
    }

    if (isset($_POST['delete'])) {
        $id = (int)sanitize('id');
        if ($system->deleteAmbulance($id)) {
            $session->message("Ambulance Deleted Successfully.");
            echo 1;
        }
    }

    // Updating emergency status
    if (isset($_POST['emergency_status'])) {
        $emergency_status = (int)sanitize('emergency_status');
        $emg_id = (int)sanitize('id');

        if ($system->updateEmergencyStatus($emergency_status, $emg_id)) {
            $session->message("Emergency Updated Successfully.");
            echo 1;
        }
    }

    if (isset($_POST['emg_id'])) {
        $emg_id = (int)sanitize('emg_id');
        $amb = array_merge($_POST['data']);
        $amb_id = implode(',', $amb);

        if ($system->updateAmbInEmergency($amb_id, $emg_id)) {
            $session->message("Ambulances have been successfully updated in the current emergency.");
            echo 1;
        }

    }