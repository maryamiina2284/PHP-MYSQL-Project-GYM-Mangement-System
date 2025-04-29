<?php 
// Include the database connection
include 'connection.php';

// Function to read all records from a table
function read($table)
{
  global $conn;
  $result = $conn->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

// Function to read records based on a condition
function read_where($table, $condition)
{
  global $conn;
  $result = $conn->query("SELECT * FROM $table WHERE $condition")->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

// Function to read a specific column value by ID

// function read_column($table, $column, $id)
// { 
//   global $conn;
//   $result = $conn->query("SELECT $column FROM $table WHERE id=$id")->fetchColumn();
//   return $result;
// }

// Function to read a specific column value by ID using prepared statements
function read_column($table, $column, $id)
{
    global $conn;
    
    // Check if the id is valid
    if (empty($id)) {
        return false; // Return false if the id is invalid
    }

    // Use prepared statements for the query
    $sql = "SELECT $column FROM $table WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Execute the statement
    $stmt->execute();
    
    // Return the value of the column or false if no value is found
    return $stmt->fetchColumn() ?: false;
}


// Function to insert data into a table
function insert($table, $data)
{
  global $conn;
  $keys = implode(",", array_keys($data));
  $namedKeys = ":" . implode(",:", array_keys($data));

  $sql = "INSERT INTO $table ($keys) VALUES($namedKeys)";
  $stm = $conn->prepare($sql);
  $result =  $stm->execute($data);
  return $result ? true : false;
}

// Function to update data in a table
function update($table, $data)
{
  global $conn;

  $pairs = [];
  foreach (array_keys($data) as $k) {
    $pairs[] = $k . "=:" . $k;
  }
  $keyEqualColonKey = implode(',', $pairs);
  $sql = "UPDATE $table SET $keyEqualColonKey WHERE id=:id";
  $stm = $conn->prepare($sql);
  $result =  $stm->execute($data);
  return $result ? true : false;
}

// Function to delete a record by ID
function delete($table, $id)
{
  global $conn;
  $sql = "DELETE FROM $table WHERE id=:id";
  $stm = $conn->prepare($sql);
  $result =  $stm->execute(["id" => $id]);
  return $result ? true : false;
}

// Function to escape HTML characters
function escape($input)
{
  return htmlspecialchars($input);
}

// Function to show a message (e.g., success or error messages)
function showMessage($ms)
{
  $text = $ms[0];
  $color = $ms[1];
  echo "<p class='text-$color p-3' style='text-align:center'> $text </p>";
  echo "<script> removeAlert(); </script>";
}

// Function to charge all members based on their membership price
function charge(){
  global $conn;

  foreach(read('members') as $member){
    $member_id = $member['id'];
    $remark = date("F, Y")." Charges";
    $price = read_column('memerships', 'Price', $member['MembershipID']);
    $user = $_SESSION['userId'];
  
    $sql = "INSERT INTO charges (`member_id`, `user_id`, `Price`, `remarks`) 
            VALUES($member_id, $user, $price, '$remark')";
    $stm = $conn->query($sql);
  }
  return $stm  ? true : false;
}


// Function to charge a single member based on their membership price
function chargeMember($member_id)
{
    global $conn, $message;

    // Get the membership ID of the member
    $membership_id = read_column('members', 'MembershipID', $member_id);

    // Check if the membership ID is valid
    if (empty($membership_id)) {
        // Handle case where membership is invalid
        $message = ["Invalid membership for member ID: $member_id", "danger"];
        // showMessage($message);
        return false;
    }

    // Check if the member has already been charged this month
    $current_month = date('Y-m'); // Format: YYYY-MM
    $sql_check = "SELECT COUNT(*) FROM charges WHERE member_id = :member_id AND DATE_FORMAT(date, '%Y-%m') = :current_month";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':member_id', $member_id, PDO::PARAM_INT);
    $stmt_check->bindParam(':current_month', $current_month, PDO::PARAM_STR);
    $stmt_check->execute();
    $already_charged = $stmt_check->fetchColumn();

    if ($already_charged > 0) {
        // If already charged, show a message using the showMessage function
        $member_name = read_column('members', 'FullName', $member_id);
        $message = ["The member $member_name has already been charged for this month.", "danger"];
        // showMessage($message);
        return false;
    }

    // Get the price for this membership
    $price = read_column('memberships', 'Price', $membership_id);

    // Check if price is found
    if ($price === false) {
        // Handle the case where no valid price is returned
        $message = ["Price not found for membership ID: $membership_id!", "danger"];
        showMessage($message);
        return false;
    }

    // Get the current user (the admin or the person applying the charge)
    $user = $_SESSION['userId'];

    // Generate the remark for the charge (e.g., for this month)
    $remark = date("F, Y") . " Charge";

    // SQL query to insert the charge for the member
    $sql = "INSERT INTO charges (`member_id`, `user_id`, `Price`, `remarks`) 
            VALUES(:member_id, :user_id, :price, :remarks)";
  
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user, PDO::PARAM_INT);
    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    $stmt->bindParam(':remarks', $remark, PDO::PARAM_STR);

    // Execute the statement
    $result = $stmt->execute();

    // Return whether the insert was successful
    if ($result) {
        $message = ["Member successfully charged!", "success"];
        // showMessage($message);
    } else {
        $message = ["Failed to charge the member.", "danger"];
        // showMessage($message);
    }

    return $result ? true : false;
}





// Function to check if charges have been applied for the current month
function checkIfCharged(){
  global $conn;
  $pattern = date('Y-m');
  $sql = "SELECT * FROM `charges` WHERE date LIKE '%$pattern%'";
  $result = $conn->query($sql)->fetchAll();
  return $result ? true : false;
}

function getgetStartTime_EndTim( $id)
{ 
  global $conn;
  $result = $conn->query("select concat(start_time ,'  - ', end_time) as Time from schedule where id=$id")->fetchColumn();
  return $result;
}


function getStatus($status){
  return $status == 'Unpaid' 
      ? "<span class='badge bg-danger'>Unpaid</span>" 
      : "<span class='badge bg-success'>Paid</span>";
}



// Function to get class schedules for a specific class (e.g., 'Yoga')
function getClassSchedules($conn, $class_name) {
    // Prepare the SQL query
    $sql = "
    SELECT s.schedule_id, c.class_name,  s.start_time, s.end_time
    FROM schedule s
    JOIN class c ON s.class_id = c.class_id
    WHERE c.class_name = ?
    ";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind the class_name parameter
    $stmt->bind_param("s", $class_name);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Fetch the data and store it in an array
    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }
    
    // Close the statement
    $stmt->close();
    
    // Return the schedules data
    return $schedules;
}


// Function to get the total number of classes in the system

function getTotalClasses($conn) {
  $sql = "SELECT COUNT(*) FROM class";
  $result = $conn->query($sql)->fetchColumn();
  return $result;
}

// Function to get the total number of members in the system

function getTotalMembers($conn) {
  $sql = "SELECT COUNT(*) FROM members";
  $result = $conn->query($sql)->fetchColumn();
  return $result;
}

// Function to get the total number of trainers in the system

function getTotalTrainers($conn) {
  $sql = "SELECT COUNT(*) FROM trainers";
  $result = $conn->query($sql)->fetchColumn();
  return $result;
}

// Function to get the total number of equipment items in the system

function getTotalEquipment($conn) {
  $sql = "SELECT COUNT(*) FROM equipments";
  $result = $conn->query($sql)->fetchColumn();
  return $result;
}




// Function to get the total number of charges made in the system

function getTotalCharges($conn) {
  $sql = "SELECT COUNT(*) FROM charges";
  $result = $conn->query($sql)->fetchColumn();
  return $result;
}


// Function to get the total number of charges made in the last month

function getTotalChargesLastMonth($conn) {
  $current_month = date('Y-m');
  $sql = "SELECT COUNT(*) FROM charges WHERE DATE_FORMAT(date, '%Y-%m') = '$current_month'";
  $result = $conn->query($sql)->fetchColumn();
  return $result;
}

//function to get sum of all months charges for   
function getSumCharges($table , $column ) {
  global $conn;
  $result = $conn->query("SELECT SUM($column) as sumCharge from $table ")->fetchColumn();
 
  return $result;
}

// Function to get the total of income made

function getTotalIncome($conn) {
  $sql = "SELECT SUM(amount) as totalIncome FROM payments";
  $result = $conn->query($sql)->fetchColumn();
  return $result;
}





// /**
//  * Count the number of members in a specific class.
//  *
//  * @param int $class_id The ID of the class to count members for.
//  * @return int The number of members in the specified class.
//  */
// function countMembers($class_id) {
//   global $conn;
//   // Prepare the SQL statement to count members
//   $stm = $conn->prepare("SELECT COUNT(*) AS member_count FROM members WHERE class_id = ?");
//   $stm->bind_param("i", $class_id);
  
//   // Execute the statement
//   $stm->execute();
  
//   // Get the result
//   $result = $stm->get_result();
//   $data = $result->fetch_assoc();
  
//   // Close the statement
//   $stm->close();
  
//   // Return the count of members
//   return $data['member_count'];
// } -->

?>
