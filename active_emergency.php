<?php require_once 'assets/core/init.php'; ?>
<?php
    if (!loggedIn() || isAdmin()) {
        redirectTo('index.php');
    }




?>

<?php include_once 'assets/inc/_head.php';  ?>
<?php include_once 'assets/inc/_dispatcher_nav.php'; ?>

<div class="container mt-2">
    <div class="row">
        <h3>Active Emergencies</h3>
        <hr>
        <?php echo success($session->message); ?>
        <div class="col-md-10 mx-auto">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Emg ID</th>
                    <th>Started</th>
                    <th>Location</th>
                    <th>Type</th>
<!--                    <th>Ambulances</th>-->
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                    <?php $emger = !empty($system->getEmergencies($_SESSION['profile'])) ? $system->getEmergencies($_SESSION['profile']) : []; foreach($emger as $emg): ?>
                        <tr>
                            <td><a href="emergency_detail.php?id=<?=$emg['id'];?>">Emg - #<?=$emg['id'];?></a></td>
                            <td><?=datetime_to_text($emg['created_at']);?></td>
                            <td><?=$emg['address'];?></td>
                            <td><?=$emg['emg_type'];?></td>
                            <td><?php
                                if ($emg['status'] == 1) {
                                    echo "<small class='text-success'>Delivered</small>";
                                } elseif ($emg['status'] == 0) {
                                    echo "<small class='text-info'>En route</small>";
                                } elseif ($emg['status'] == 2) {
                                    echo "<small class='text-danger'>Failed</small>";
                                }
                                ?>
                                <button class="btn btn-xs btn-outline-success" onclick="updateStatus(1, <?=$emg['id'];?>)"><i class="fas fa-check-circle"></i></button>
                                <button class="btn btn-xs btn-outline-danger" onclick="updateStatus(2, <?=$emg['id'];?>)"><i class="fas fa-times-circle"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    function updateStatus(mode, id) {
        if (confirm("Are you sure you want to update this emergency?")) {
            let data = {emergency_status: mode, id: id};
            if (parseInt(mode) === 1) {
                updateStat(data);
            } else {
                updateStat(data);
            }
        }
    }

    function updateStat(data) {
        $.ajax({
            url: "ajax/system.php",
            method: "post",
            data: data,
            cache: false,
            success: function (res) {
                if (parseInt(res) === 1) {
                    location.reload();
                }
            },
            error: function (err) {
                console.log(err);
            }
        })
    }

    function addAmb() {
        alert("adding ambulance")
    }
</script>


