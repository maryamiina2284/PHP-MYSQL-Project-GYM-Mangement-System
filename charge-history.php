<?php 
// Include the database connection
include 'includes/init.php'; 
// Check if a member_id is passed through the URL
if (isset($_GET['member_id'])) {
    $member_id = $_GET['member_id'];
    
    // Get charge history for the member
    $charge_history = read_where('charges', "member_id = $member_id");
    
    // Get member's full name for display
    $member_name = read_column('members', 'FullName', $member_id);
} else {
    // Redirect if no member_id is provided
    echo "No member selected.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charge History for <?= htmlspecialchars($member_name) ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h1 class="text-center mb-4">Charge History for <?= htmlspecialchars($member_name) ?></h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($charge_history): ?>
                <?php foreach ($charge_history as $charge): ?>
                    <tr>
                        <td><?= $charge['date'] ?></td>
                        <td><?= $charge['Price'] ?></td>
                        <td><?= $charge['remarks'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No charges found for this member.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
</div>

<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
