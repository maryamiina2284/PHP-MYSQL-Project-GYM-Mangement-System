<?php 
include 'includes/init.php';
include 'modals/membersModal.php';
$message = [];

if (isset($_POST['btnSave'])) {
   if($_POST['TypeOfData'] == 'insert'){
    $data = [
        "FullName" => trim(escape($_POST['FullName'])),
        "DateOfBirth" => trim(escape($_POST['DateOfBirth'])),
        "Gender" => trim(escape($_POST['Gender'])),
        "Phone" => trim(escape($_POST['Phone'])),
        "Email" => trim(escape($_POST['Email'])),
        "Address" => trim(escape($_POST['Address'])),
        "MemberWeight" => trim(escape($_POST['MemberWeight'])),
        "MembershipID" => trim(escape($_POST['type'])),
        "schedule_id" => trim(escape($_POST['time'])),
        "Status" => trim(escape($_POST['Status']))
    ];
    $result = insert('members', $data);
    if ($result) {
        $message = ["Successfully inserted!", "success"];
    } else {
        $message = ["Sorry! Something went wrong", "danger"];
    }
   } else if($_POST['TypeOfData'] == 'update'){
    $data = [
        "id" => trim(escape($_POST['member_Id'])),
        "FullName" => trim(escape($_POST['FullName'])),
        "DateOfBirth" => trim(escape($_POST['DateOfBirth'])),
        "Gender" => trim(escape($_POST['Gender'])),
        "Phone" => trim(escape($_POST['Phone'])),
        "Email" => trim(escape($_POST['Email'])),
        "Address" => trim(escape($_POST['Address'])),
        "MemberWeight" => trim(escape($_POST['MemberWeight'])),
        "MembershipID" => trim(escape($_POST['type'])),
        "schedule_id" => trim(escape($_POST['time'])),
        "Status" => trim(escape($_POST['Status']))
    ];
    $result = update('members', $data);
    if ($result) {
        $message = ["Successfully updated!", "success"];
        // echo "<script>alert('Successfully updated!')</script>";
    } else {
        $message = ["Sorry! Something went wrong", "danger"];
    }
   }
}

if (isset($_POST['btnDelete']) && isset($_POST['member_id'])) {
    if (delete('members', $_POST['member_id'])) {
        $message = ["Successfully Deleted!", "success"];
    } else {
        $message = ["Sorry! Something went wrong", "danger"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Page</title>
    <style>
     
        .search-bar {
            margin-bottom: 15px;
            /* display: flex;
            justify-content: flex-end; */
            width: 400px;
        }
    </style>
</head>
<body>
    

<!-- Begin Page Content -->
<div class="container">

    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All members </h1>
    </div>
    <div class="card shadow mb-4">
        <div class="row alerts">
            <?php $message ? showMessage($message) : ""; ?>
        </div>
        

        <div class="card-header py-3"> 
    <h6 class="m-0 fw-bold text-primary">Member List</h6>

    <!-- Add New Member Button -->
    <button class="btn btn-primary float-end" data-bs-toggle="modal" href="#member-modal" onclick="reset()">
        Add New Member
    </button>

    <!-- Table Search Bar -->
    <!-- <div class="search-bar mt-2">
        <input type="text" id="searchInput" class="form-control w-50 float-end" placeholder="Search ...">
    </div> -->
</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead >
                        <tr>
                            <th>Full Name</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>MemberWeight</th>
                            <th>Membership Type</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody  id="memberTableBody">
                        <?php
                        foreach (read('members') as $member) {
                        ?>
                        <tr>
                            <td><?= $member['FullName']; ?></td>
                            <td><?= $member['DateOfBirth']; ?></td>
                            <td><?= $member['Gender']; ?></td>
                            <td><?= $member['Phone']; ?></td>
                            <td><?= $member['Email']; ?></td>
                            <td><?= $member['Address']; ?></td>
                            <td><?= $member['MemberWeight']; ?></td>
                            <td><?= read_column('memberships', 'MembershipType', $member['MembershipID']); ?></td>
                            <td> <?= getgetStartTime_EndTim($member['schedule_id']); ?> </td>
                            <td><?= $member['Status']; ?></td>
                            <td>
                                <a href="#member-modal" data-bs-toggle="modal" class="btn btn-primary"
                                    onclick="fillForm(<?= $member['id']; ?>)">  <i class="bx bx-edit-alt "></i></a>
                                <a href="#delete-member-modal" data-bs-toggle="modal" class="btn btn-danger"
                                    onclick="setId(<?= $member['id']; ?>)"> <i class="bx bx-trash"></i></a>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>

function reset() {
    document.querySelector('.modal-title').textContent = 'Add Member Details';
    document.getElementById('action').value = 'insert';
    document.getElementById('memberid').value = 0;
    document.getElementById('FullName').value = '';
    document.getElementById('DateOfBirth').value = '';
    document.getElementById('Gender').value = '';
    document.getElementById('Phone').value = '';
    document.getElementById('Email').value = '';
    document.getElementById('Address').value = '';
    document.getElementById('MemberWeight').value = '';
    document.getElementById('MembershipID').value = '';
    document.getElementById('schedule_id').value = '';
    document.getElementById('Status').value = '';
}

function setId(id) {
    document.getElementById('member_id').value = id;
}

function fillForm(id) {
    document.querySelector('.modal-title').textContent = 'Update Member Details';
    document.getElementById('action').value = 'update';
    document.getElementById('memberid').value = id;

    $.ajax({
        url: "includes/ajax.php",
        method: "post",
        data: {
            table: "members",
            id: id,
            action: "forUpdate"
        },
        success: function(result) {
            const data = JSON.parse(result);
            document.getElementById('FullName').value = data.FullName;
            document.getElementById('DateOfBirth').value = data.DateOfBirth;
            document.getElementById('Gender').value = data.Gender;
            document.getElementById('Phone').value = data.Phone;
            document.getElementById('Email').value = data.Email;
            document.getElementById('Address').value = data.Address;
            document.getElementById('MemberWeight').value = data.MemberWeight;
            Array.from(document.getElementById('type').children).forEach(option => option.value == data.MembershipID ? option.selected = true : '');
            document.getElementById('StartDate').value = data.StartDate;
            document.getElementById('Status').value = data.Status;
        },
        error: function(error) {
            console.log(error);
        }
    });
}




        // Search functionality for the table
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchQuery = this.value.toLowerCase();
            const rows = document.querySelectorAll('#memberTableBody tr');
            rows.forEach(function(row) {
                const cells = row.querySelectorAll('td');
                let rowContent = '';
                cells.forEach(function(cell) {
                    rowContent += cell.textContent.toLowerCase();
                });
                if (rowContent.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
