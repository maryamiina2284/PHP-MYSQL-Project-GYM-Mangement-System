<?php
include 'includes/init.php';

if (isset($_GET['id'])) {
    $paymentId = $_GET['id'];

    // Delete query
    $sql = "DELETE FROM payments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $paymentId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Payment deleted successfully.";
    } else {
        echo "Payment not found or already deleted.";
    }

    $stmt->close();
}

$conn->close();
?>


<script>
    function deletePayment(paymentId) {
    if (confirm("Are you sure you want to delete this payment?")) {
        var xhr = new XMLHttpRequest();
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert("Payment deleted successfully.");
                location.reload(); // Refresh the page to update the list
            } else {
                console.error("Failed to delete payment");
            }
        };

        xhr.open('GET', 'delete_payment.php?id=' + paymentId, true);
        xhr.send();
    }
}

</script>