 <?php require_once 'assets/core/init.php'; ?>
<?php
    if (!loggedIn() || isAdmin()) {
        redirectTo('index.php');
    }

    if (isset($_POST['new_emg'])) {
        $dispatcherID = (int)$_SESSION['profile'];
        $callerName = sanitize('caller_name');
        $phone = sanitize('phone');
        $rship = sanitize('relationship');
        $emgType = sanitize('type');
        $injured = sanitize('injured');
        $ambRequired = sanitize('amb_required');
        $address = sanitize('location');
        $notes = sanitize('notes');

        if ($callerName == '' || $phone == '' || $rship == '' || $emgType == '' || $injured == '' || $ambRequired == '' || $address == '' || $notes == '') {
            $errors[] = "All fields are required";
        }

        // Some validation goes in here

        $amb_locations = array();
        $found = 0;
        $ambulances = $system->getAmbulanceWhereAvailable();
        foreach ($ambulances as $amb) {
            $amb_locations[$amb['id']] = strtolower($amb['location']);
        }
        $pos = array_search(strtolower($address), $amb_locations);
        if ($pos !== false) {
            $amb_id = (int) $pos;

            $ambInfo = $system->getAmbInfo($amb_id);
            if (empty($errors)) {
                if ($system->addEmergency($dispatcherID, $amb_id, $callerName, $phone, $rship, $emgType, $injured, $ambRequired, $address, $notes)) {
                    $session->message("Emergency added successfully.");
                    redirectTo('new_emergency.php');
                }
            }
        } else {
            // No nearby ambulance


            if (empty($errors)) {
                $amb_id = 'No_Ambulance';
                if ($system->addEmergency($dispatcherID, $amb_id, $callerName, $phone, $rship, $emgType, $injured, $ambRequired, $address, $notes)) {
                    $session->message("Emergency added successfully.");
                    redirectTo('new_emergency.php');
                }
            }
        }
    }
?>

<?php include_once 'assets/inc/_head.php';  ?>
<?php include_once 'assets/inc/_dispatcher_nav.php'; ?>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card p-2">
                <h2 class="card-header mb-2">New Emergency</h2>
                <?php echo error($errors); echo success($session->message); ?>
                <form action="" method="post" id="newEmergencyForm">
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
<!--                                <label for="caller_name">Caller Name: </label>-->
                                <input type="text" name="caller_name" id="caller_name" class="form-control form-control-sm" placeholder="Enter Caller Name">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- <label for="caller_name">Caller Name: </label>-->
                                <input type="text" name="phone" id="phone" class="form-control form-control-sm" placeholder="Enter Caller Phone Number">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- <label for="caller_name">Caller Name: </label>-->
                                <select name="relationship" id="relationship" class="form-control form-control-sm">
                                    <option value="">-- Select Relationship --</option>
                                    <option value="self">Self</option>
                                    <option value="father">Father</option>
                                    <option value="mother">Mother</option>
                                    <option value="sibling">Sibling</option>
                                    <option value="husband">Husband</option>
                                    <option value="wife">Wife</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="type" id="type" class="form-control form-control-sm" placeholder="Enter Emergency Type: ">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="injured" id="injured" class="form-control form-control-sm" placeholder="No. of People Injured: ">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="amb_required" id="amb_required" class="form-control form-control-sm" placeholder="Ambulances Required: ">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <input name="location" id="location" class="form-control form-control-sm" placeholder="Enter Emergency Location">
                        </div>
                        <div class="col-md-6">
                            <textarea name="notes" id="notes" cols="30" rows="5" class="form-control form-control-sm" placeholder="Enter Emergency Description"></textarea>
                        </div>
                    </div>
                    <div class="mt-3">System Information: <span class="text-danger"><small>None</small></span></div>
                    <hr>
                    <div class="row mt-3">
                        <button type="button" class="btn btn-sm mx-auto btn-danger" id="clearBtn">Clear</button>
                        <button type="submit" name="new_emg" class="btn btn-sm mx-auto btn-success">Activate Emergency</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $("#clearBtn").on('click', function () {
       $("#newEmergencyForm").trigger('reset');
    });
</script>


