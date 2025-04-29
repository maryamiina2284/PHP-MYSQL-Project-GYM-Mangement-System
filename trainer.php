<?php 
include 'includes/init.php';
include 'modals/trainerModal.php';
$message = [];

if (isset($_POST['btnSave'])) {
    if (isset($_POST['action']) && $_POST['action'] == 'insert') {			
        $data = [	
            "FullName" => trim(escape($_POST['FullName'])),
            "Gender" => trim(escape($_POST['Gender'])),
            "Phone" => trim(escape($_POST['Phone'])),
            "Email" => trim(escape($_POST['Email'])),
            "Address" => trim(escape($_POST['Address'])),
            "HireDate" => trim(escape($_POST['HireDate'])),
            "Status" => trim(escape($_POST['Status']))
        ];

        if (insert('trainers', $data)) {
            $message = ["Successfully inserted!", "success"];
        } else {
            $message = ["Sorry! Something went wrong", "danger"];
        }
    } else if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $data = [
            "id" => trim(escape($_POST['trainerid'])),
            "FullName" => trim(escape($_POST['FullName'])),
            "Gender" => trim(escape($_POST['Gender'])),
            "Phone" => trim(escape($_POST['Phone'])),
            "Email" => trim(escape($_POST['Email'])),
            "Address" => trim(escape($_POST['Address'])),
            "HireDate" => trim(escape($_POST['HireDate'])),
            "Status" => trim(escape($_POST['Status']))
        ];

        if (update('trainers', $data)) {
            $message = ["Successfully Updated!", "success"];
        } else {
            $message = ["Sorry! Something went wrong", "danger"];
        }
    }
}

if (isset($_POST['btnDelete']) && isset($_POST['trainer_id'])) {
    if (delete('trainers', $_POST['trainer_id'])) {
        $message = ["Successfully Deleted!", "success"];
    } else {
        $message = ["Sorry! Something went wrong", "danger"];
    }
}
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Trainers</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="row alerts">
            <?php $message ? showMessage($message) : ""; ?>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">Trainer List</h6>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#trainer-modal" >
                New Trainer
            </button>
            </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Hire Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach (read('trainers') as $trainer) {
                        ?>
                        <tr>
                            <td><?= $trainer['FullName']; ?></td>
                            <td><?= $trainer['Gender']; ?></td>
                            <td><?= $trainer['Phone']; ?></td>
                            <td><?= $trainer['Email']; ?></td>
                            <td><?= $trainer['Address']; ?></td>
                            <td><?= $trainer['HireDate']; ?></td>
                            <td><?= $trainer['Status']; ?></td>

                            <td>
                                <a href="#trainer-modal" data-bs-toggle="modal" class="btn btn-primary"
                                    onclick="fillForm(<?= $trainer['id']; ?>)"> <i class="bx bx-edit-alt "></i></a>
                                <a href="#delete-trainer-modal" data-bs-toggle="modal" class="btn btn-danger"
                                    onclick="setId(<?= $trainer['id']; ?>)"> <i class="bx bx-trash"></i></a>
                            </td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


<?php include 'includes/footer.php'; ?>

<script>
function reset() {
    document.querySelector('.modal-title').textContent = 'Add Trainer Details';
    document.getElementById('action').value = 'insert';
    document.getElementById('trainerid').value = 0;
    document.getElementById('FullName').value = '';
    document.getElementById('Gender').value = '';
    document.getElementById('Phone').value = '';
    document.getElementById('Email').value = '';
    document.getElementById('Address').value = '';
    document.getElementById('HireDate').value = '';
    document.getElementById('Status').value = '';
}

function setId(id) {
    document.getElementById('trainer_id').value = id;
}

function fillForm(id) {
    document.querySelector('.modal-title').textContent = 'Update Trainer Details';
    document.getElementById('action').value = 'update';
    document.getElementById('trainerid').value = id;
    $.ajax({
        url: "includes/ajax.php",
        method: "post",
        data: {
            table: "trainers",
            id: id,
            action: "forUpdate"
        },
        success: function(result) {
            const data = JSON.parse(result);
            document.getElementById('FullName').value = data.FullName;
            document.getElementById('Gender').value = data.Gender;
            document.getElementById('Phone').value = data.Phone;
            document.getElementById('Email').value = data.Email;
            document.getElementById('Address').value = data.Address;
            document.getElementById('HireDate').value = data.HireDate;
            document.getElementById('Status').value = data.Status;
        },
        error: function(error) {
            console.log(error);
        }
    });
}
</script>
