<?php require_once 'assets/core/init.php'; ?>
<?php
// $user->logout();
    if (!loggedIn()) {
        redirectTo('login.php');
    }
    if (!isAdmin()) {
        redirectTo('index.php');
    }

?>
<?php include_once 'assets/inc/_head.php';  ?>
<?php include_once 'assets/inc/_admin_nav.php'; ?>
<style scope="emergency.php">
    #admin_nav .nav-link {
        color: #ccc !important;
    }
    #admin_nav .nav-link:hover {
        border-bottom: 1px solid #fff;
        cursor: pointer;
    }

    #admin_nav .nav-link.act {
        text-transform: uppercase;
        color: #fff !important;
    }
</style>


    <div class="container">
        <div class="row">
            <nav class="navbar mx-auto navbar-expand-sm navbar-dark bg-dark mt-1" id="admin_nav">
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                        data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link act" id="emergency_link" onclick="leave(1)">Emergency Management</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="#">|</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" id="ambulance_link" onclick="leave(2)">Ambulance Management</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="row mt-2">
            <div id="emergency">

            </div>
            <div id="ambulance" class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 style="display: inline;" class="text-black-50">Ambulance Management</h5>
                        <button class="btn btn-outline-primary pull-right" data-toggle="modal" data-target="#addAmbulance"><span class="fas fa-plus"></span></button>
                    </div>
                    <small class="col-md-6 mx-auto mt-1">
                        <?php echo success($session->message); ?>
                    </small>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Date Created</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                            <?php $n = 1; foreach ($system->getAmbulance() as $amb) : ?>
                                <tr>
                                    <td scope="row"><?php echo $n++; ?></td>
                                    <td><?=$amb['name']; ?></td>
                                    <td><?=$amb['location'];?></td>
                                    <td><?=excerpt($amb['description'], 10); ?></td>
                                    <td><?=date_to_text($amb['created_at']);?></td>
                                    <td><?php
                                        if ($amb['status'] == 1) {
                                            echo "<small class='text-success'>Available</small>";
                                        } elseif ($amb['status'] == 0) {
                                            echo "<small class='text-danger'>Not Available</small>";
                                        } else {
                                            echo "<small class='text-info'><em>en route</em></small>";
                                        }
                                        ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">edit</button>
                                        <button onclick="deleteAmb(<?=$amb['id'];?>)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


<?php //include_once 'assets/inc/_footer.php'; ?>

<!-- Add Ambulance Modal -->
<div class="modal fade" id="addAmbulance" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Ambulance</h5>
                <button type="button" class="close clearBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="addAmbulanceForm">
                <div class="modal-body">
                    <div id="errorNote" class="alert alert-danger">All fields with * are required.</div>
                    <div class="form-group">
                        <label for="name">Name: <span class="text-danger"><sup>*</sup></span></label>
                        <input type="text" name="title" id="name" class="form-control form-control-sm">
                    </div>

                    <div class="form-group">
                        <label for="location">Location: <span class="text-danger"><sup>*</sup></span></label>
                        <input type="text" name="location" id="location" class="form-control form-control-sm">
                    </div>

                    <div class="form-group">
                        <label for="desc">Description: </label>
                        <textarea name="desc" id="desc" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger clearBtn">Clear</button>
                    <button type="button" onclick="addEmergency()" name="addAmbulance" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Scripting -->
<script scope="emergency.php">
    $(function() {
        $("#ambulance").hide();
        $("#errorNote").hide();
    });

    $(".clearBtn").on('click', function() {
        $("#addAmbulanceForm").trigger('reset');
    });

    function leave(mode) {
        if (parseInt(mode) === 1) {
            $("#ambulance").hide();
            $("#emergency").show();
            $("#emergency_link").addClass('act');
            $("#ambulance_link").removeClass('act');
        } else if (parseInt(mode) === 2) {
            $("#ambulance").show();
            $("#emergency").hide();
            $("#ambulance_link").addClass('act');
            $("#emergency_link").removeClass('act');
        }
    }
    
    function addEmergency() {
        let name = $("#name");
        let location = $("#location");
        let desc = $("#desc");
        let err = 0;

        if (name.val() === '' || location.val() === '') {
            $("#name, #location").addClass('is-invalid');
            $("#errorNote").show();
            err = 1;
        }

        if (!err) {
            $("#name, #location").removeClass('is-invalid');
            $("#errorNote").hide();

            let data = {addAmb: true, name: name.val(), location: location.val(), desc: desc.val()};

            $.ajax({
               url: 'ajax/system.php',
               method: 'post',
               data: data,
               cache: false,
               success: function (res) {
                   if (parseInt(res) === 1) {
                       window.location.reload();
                   }
               },
                error: function (err) {
                    console.log(err);
                }
            });

        }
    }
    
    function deleteAmb(id) {
        if (confirm("Are you sure you want to delete this ambulance?")) {
            let data = {delete: true, id: id};
            $.ajax({
                url: 'ajax/system.php',
                method: 'post',
                data: data,
                cache: false,
                success: function (res) {
                    if (parseInt(res) === 1) {
                        window.location.reload();
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
    }

</script>
