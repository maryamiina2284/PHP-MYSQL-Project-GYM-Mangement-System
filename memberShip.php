<?php
include 'includes/init.php';
include 'modals/membershipModal.php'; // Include the modal file

$message = [];
if (isset($_POST['btnSaveMembership'])) {
    if ($_POST['action'] && $_POST['action'] == 'insert') {			
        $data = [	
            "MembershipType" => trim(escape($_POST['MembershipType'])),
            "Price" => trim(escape($_POST['Price'])),
            "Duration" => trim(escape($_POST['Duration']))
        ];

        if (insert('memberships', $data)) {
            $message = ["Successfully inserted!", "success"];
        } else {
            $message = ["Sorry! Something went wrong", "danger"];
        }
    } else if ($_POST['action'] && $_POST['action'] == 'update') {
        $data = [
            "id" => trim(escape($_POST['membershipid'])),
            "MembershipType" => trim(escape($_POST['MembershipType'])),
            "Price" => trim(escape($_POST['Price'])),
            "Duration" => trim(escape($_POST['Duration']))
        ];

        if (update('memberships', $data)) {
            $message = ["Successfully Updated!", "success"];
        } else {
            $message = ["Sorry! Something went wrong", "danger"];
        }
    }
}

if (isset($_POST['btnDelete']) && isset($_POST['membership_id'])) {
    if (delete('memberships', $_POST['membership_id'])) {
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
        <h1 class="h3 mb-0 text-gray-800">All Membership</h1>
    </div>

    <div class="card shadow mb-4">
    <div class="row alerts">
            <?php $message ? showMessage($message) : ""; ?>
        </div>

        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">Membership List</h6>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#membership-modal" onclick="reset()">
                Add New Membership
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Membership Type</th>
                            <th>Price</th>
                            <th>Duration (Days)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach (read('memberships') as $membership) {
                        ?>
                        <tr>
                            <td><?= $membership['MembershipType']; ?></td>
                            <td><?= $membership['Price']; ?></td>
                            <td><?= $membership['Duration']; ?></td>
                            <td>
                            <a href="#membership-modal" data-bs-toggle="modal" class="btn btn-primary"
                                    onclick="fillForm(<?= $membership['id']; ?>)"> <i class="bx bx-edit-alt "></i></a>
                                <a href="#delete-membership-modal" data-bs-toggle="modal" class="btn btn-danger"
                                    onclick="setId(<?= $membership['id']; ?>)"> <i class="bx bx-trash"></i></a>
                            </td>
                        </tr>

                        
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>



<script>
    
function reset() {
    document.querySelector('.modal-title').textContent = 'Add Member Details';
    document.getElementById('action').value = 'insert';
    document.getElementById('membershipid').value = 0;
    document.getElementById('MembershipType').value = '';
    document.getElementById('Price').value = '';
    document.getElementById('Duration').value = '';
}

function setId(id) {
    $('#membership_id').val(id);
}

function fillForm(id) {
    // console.log(id);
     document.querySelector('.modal-title').textContent = 'Update MemberShips Details';
    document.getElementById('action').value = 'update';
    document.getElementById('membershipid').value = id;
    $.ajax({
        url: "includes/ajax.php",
        method: "post",
        data: {
            table: "memberships",
            id: id,
            action: "forUpdate"
        },
        success: function(result) {
            //   console.log(result);
            const data = JSON.parse(result)
            document.getElementById('MembershipType').value = data.MembershipType;
            document.getElementById('Price').value = data.Price;
            document.getElementById('Duration').value = data.Duration;
        },
        error: function(error) {
            console.log(error);
        }
    })

}

</script>