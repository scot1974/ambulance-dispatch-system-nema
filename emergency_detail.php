<?php require_once 'assets/core/init.php'; ?>
<?php
if (!loggedIn() || isAdmin()) {
    redirectTo('index.php');
}
if (isset($_GET['id'])) {
    $emg_id = (int)urlencode($_GET['id']);

    $emgInfo = $system->getEmergency($emg_id)[0];

    $am_id = explode(',', $emgInfo['ambulance_id']);
}




?>

<?php include_once 'assets/inc/_head.php';  ?>
<?php include_once 'assets/inc/_dispatcher_nav.php'; ?>

<div class="container mt-2">
    <div class="row">
        <h3 class="text-danger">Emergencies Details</h3>
<!--        <div class="col-md-6 mx-auto">-->
<!--            <h4><label for="emergency">Choose Emergency: </label></h4>-->
<!--            <select name="emergency" id="emergency" class="form-control">-->
<!--                --><?php //foreach($system->getEmergencies($_SESSION['profile']) as $emg): ?>
<!--                    <option value="--><?php //echo $emg['id']; ?><!--">#--><?//=$emg['id'] .' ~ ' . $emg['emg_type'];?><!--</option>-->
<!--                --><?php //endforeach; ?>
<!--            </select>-->
<!--        </div>-->
        <?php echo success($session->message); ?>
        <hr>
        <div class="col-md-10 mx-auto">
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item bg-success text-white">Caller Name</li>
                        <li class="list-group-item"><?=$emgInfo['caller_name'];?></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item bg-success text-white">Caller Phone</li>
                        <li class="list-group-item"><?=$emgInfo['caller_phone'];?></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item bg-success text-white">Caller Relationship</li>
                        <li class="list-group-item"><?=$emgInfo['relationship'];?></li>
                    </ul>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item bg-danger text-white">Emergency Type</li>
                        <li class="list-group-item"><?=$emgInfo['emg_type'];?></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item bg-danger text-white">No. of People Injured</li>
                        <li class="list-group-item"><?=$emgInfo['injured'];?></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item bg-danger text-white">Ambulance Required</li>
                        <li class="list-group-item"><?=$emgInfo['amb_required'];?></li>
                    </ul>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <ul class="list-group">
                        <li class="list-group-item bg-info text-white">Emergency Location</li>
                        <li class="list-group-item"><?=$emgInfo['address'];?></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-group">
                        <li class="list-group-item bg-info text-white">Emergency Notes</li>
                        <li class="list-group-item"><?=$emgInfo['notes'];?></li>
                    </ul>
                </div>
            </div>

            <h5 class="mt-2 text-danger">System information: </h5> Emergency Started at: <?=datetime_to_text($emgInfo['created_at']);?>
        </div>

        <h3 class="text-danger mt-4">Ambulance Information</h3>
        <div class="col-md-10 mx-auto mb-lg-5">
            <?php echo success($session->message); ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Ambulance ID</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($emgInfo['ambulance_id'] != 'No_Ambulance') : ?>
                    <tr>
                        <td>
                            <input type="checkbox" <?=($emgInfo['status'] == 1) ? 'checked' : '';?> name="attached_amb" id="attached_amb" value="<?=$emgInfo['ambulance_id'];?>">
                        </td>
                        <td><?=$system->getAmbInfo($emgInfo['ambulance_id'])[0]['name'];?></td>
                        <td><?=$system->getAmbInfo($emgInfo['ambulance_id'])[0]['location'];?></td>
                        <td>

                        </td>
                        <td></td>
                    </tr>
                <?php endif; ?>
                <?php foreach($system->getAmbulanceWhereAvailable() as $amb) : ?>
                    <?php if ($amb['id'] != $emgInfo['ambulance_id'] && !in_array($amb['id'], $am_id)): ?>
                        <form action="" id="ambForm">
                            <tr>
                                <td>
                                    <input type="checkbox" <?=(in_array($amb['id'], $am_id) ? 'checked' : '');?>  name="unused_ambulance" id="unused_ambulance" value="<?=$amb['id'];?>">
                                </td>
                                <td><?=$amb['name']; ?></td>
                                <td><?=$amb['location'];?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
            <button class="btn btn-sm btn-warning" onclick="mapSelected(<?=$emgInfo['id'];?>)">Map Selected</button>
            <button class="btn btn-sm btn-info" onclick="releaseAmbulance(<?=$emgInfo['id'];?>)">Release Ambulance</button>
            <button class="btn btn-sm btn-outline-primary pull-right">Save Changes</button>
        </div>
    </div>
</div>


<script>
    function releaseAmbulance(emg_id) {
        let data = [];
        $.each($("input[type='checkbox']:checked"), function () {
            data.push($(this).val())
        });
    }

    function mapSelected(emg_id) {
        let data = [];
        $.each($("input[type='checkbox']:checked"), function () {
            data.push($(this).val())
        });

        $.ajax({
            url: 'ajax/system.php',
            method: 'post',
            data: {emg_id: emg_id, data},
            cache: false,
            success: function (res) {
                if (parseInt(res) === 1) {
                    location.reload();
                }
            }, 
            error: function (err) {
                
            }
        })

    }
</script>



