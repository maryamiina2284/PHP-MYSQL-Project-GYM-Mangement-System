<?php 
include 'includes/init.php'; 
include 'modals/charge-income-modal.php'; 

$message = [];

if (isset($_POST['btnSave'])) {
    $data = [
        "member_id" => trim(escape($_POST['member'])),
        "charge_id" => trim(escape($_POST['charge'])),
        "user_id" => $_SESSION['userId'],
        "amount" => trim(escape($_POST['amount'])),
        "bank_id" => trim(escape($_POST['bank']))
    ];

    if (insert('payments', $data)) {
        $message = ["Successfully Recorded the payment!", "success"];
    } else {
        $message = ["Sorry! Something went wrong", "danger"];
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Charge Income</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="row alerts">
            <?php if (!empty($message)) { showMessage($message); } ?>
        </div>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Charges List</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#charge-income-modal">
                New Charge Income
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Charge ID</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>Banks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (read('payments') as $payment) { ?>
                            <tr>
                                <td><?= read_column('members', "FullName", $payment['member_id']); ?></td>
                                <td><?= $payment['charge_id']; ?></td>
                                <td><?= read_column('users', "FullName", $payment['user_id']); ?></td>
                                <td><?= $payment['amount']; ?></td>
                                <td><?= $payment['PaymentDate']; ?></td>
                                <td><?= read_column('banks', "name", $payment['bank_id']); ?></td>
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

    $("#member").change(function () {
        const member = $('#member').val(); 
        console.log(member);
        
        $("#charge").empty();

        $.ajax({
            url: "includes/ajax.php",
            method: "post",
            data: {
                table: "charges",
                memberid: member,
                action: "forPayment"
            },
            success: function (result) {
                console.log(result);
                const data = JSON.parse(result);
                let options = '';

                $.each(data, (i, row) => {
                    options += `<option value=${row.id} title=${row.Price}> ${row.Type + " - $" + row.Price} </option>`;
                });

                $('#charge').html('<option value="" selected disabled> Select Charge to Pay </option>');
                $("#charge").append(options);

                $("#charge").change(() => {
                    let selectedOption = $('#charge option:selected'); 
                    let chargeTitle = selectedOption.attr('title'); 
                    $("#amount").val(Number(chargeTitle)); 
                    $("#amount").prop('readonly', true); 
                });
            },
            error: function (error) {
                console.error("An error occurred: ", error);
            }
        });
    });

    

</script>
