<?php
include 'includes/init.php';
include 'modals/equipmentModal.php'; // Include the modal file

$message = [];
if (isset($_POST['btnSave'])) {
    // Ensure 'action' is set before accessing
    if (isset($_POST['action']) && $_POST['action'] == 'insert') {			
        $data = [	
            "EquipmentName" => trim(escape($_POST['EquipmentName'])),
            "PurchaseCost" => trim(escape($_POST['PurchaseCost'])),
            "Quantity" => trim(escape($_POST['Quantity'])),
            "PurchaseDate" => trim(escape($_POST['PurchaseDate']))
        ];

        if (insert('equipments', $data)) {
            $message = ["Successfully inserted!", "success"];
        } else {
            $message = ["Sorry! Something went wrong", "danger"];
        }
    } else if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $data = [
            "id" => trim(escape($_POST['equipmentid'])),
            "EquipmentName" => trim(escape($_POST['EquipmentName'])),
            "PurchaseCost" => trim(escape($_POST['PurchaseCost'])),
            "Quantity" => trim(escape($_POST['Quantity'])),
            "PurchaseDate" => trim(escape($_POST['PurchaseDate']))
        ];

        if (update('equipments', $data)) {
            $message = ["Successfully Updated!", "success"];
        } else {
            $message = ["Sorry! Something went wrong", "danger"];
        }
    }
}

if (isset($_POST['btnDelete']) && isset($_POST['equipment_id'])) {
    if (delete('equipments', $_POST['equipment_id'])) {
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
        <h1 class="h3 mb-0 text-gray-800">All Equipment</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="row alerts">
            <?php if (!empty($message)) { showMessage($message); } ?>
        </div>

        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">Equipment List</h6>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#equipment-modal">
                Add New Equipment
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Equipment Name</th>
                            <th>Purchase Cost</th>
                            <th>Quantity</th>
                            <th>Purchase Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach (read('equipments') as $equipment) {
                        ?>
                        <tr>
                            <td><?= $equipment['EquipmentName']; ?></td>
                            <td><?= $equipment['PurchaseCost']; ?></td>
                            <td><?= $equipment['Quantity']; ?></td>
                            <td><?= $equipment['PurchaseDate']; ?></td>
                            <td>
                                <a href="#equipment-modal" data-bs-toggle="modal" class="btn btn-primary"
                                    onclick="fillForm(<?= $equipment['id']; ?>)"> <i class="bx bx-edit-alt "></i></a>
                                <a href="#delete-equipment-modal" data-bs-toggle="modal" class="btn btn-danger"
                                    onclick="setId(<?= $equipment['id']; ?>)"> <i class="bx bx-trash"></i></a>

                                    
                                    <!-- <div class="dropdown-menu">
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-edit-alt me-2"></i> Edit</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-trash me-2"></i> Delete</a
                              >
                            </div> -->
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
    document.querySelector('.modal-title').textContent = 'Add Equipment Details';
    document.getElementById('action').value = 'insert';
    document.getElementById('equipmentid').value = 0;
    document.getElementById('EquipmentName').value = '';
    document.getElementById('PurchaseCost').value = '';
    document.getElementById('Quantity').value = '';
    document.getElementById('PurchaseDate').value = '';
}

function setId(id) {
    document.getElementById('equipment_id').value = id;
}

function fillForm(id) {
    document.querySelector('.modal-title').textContent = 'Update Equipment Details';
    document.getElementById('action').value = 'update';
    document.getElementById('equipmentid').value = id;
    $.ajax({
        url: "includes/ajax.php",
        method: "post",
        data: {
            table: "equipments",
            id: id,
            action: "forUpdate"
        },
        success: function(result) {
            const data = JSON.parse(result);
            document.getElementById('EquipmentName').value = data.EquipmentName;
            document.getElementById('PurchaseCost').value = data.PurchaseCost;
            document.getElementById('Quantity').value = data.Quantity;
            document.getElementById('PurchaseDate').value = data.PurchaseDate;
        },
        error: function(error) {
            console.log(error);
        }
    });
}
</script>
