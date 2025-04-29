<?php
include 'includes/init.php';

// Check if member_id is provided via AJAX
if (isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];

    // Retrieve the membership ID of the member
    $membership_id = read_column('members', 'MembershipID', $member_id);

    // Get the amount for this membership
    $amount = read_column('memberships', 'Price', $membership_id);
    
    // Set the remark (can adjust this logic as needed)
    $remark = date("F, Y") . " Charge"; // Default remark for the current month

    // Return the data as JSON
    echo json_encode(['amount' => $amount, 'remark' => $remark]);
} else {
    echo json_encode(['error' => 'No member ID provided']);
}
?>
