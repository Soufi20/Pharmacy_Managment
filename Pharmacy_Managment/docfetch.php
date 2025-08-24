<?php

include('connect.php');

if(isset($_POST['view'])) {

    if($_POST["view"] != '') {
        // Update status for all rows with status 0 to 1
        $update_query = "UPDATE transaction SET status = 1 WHERE status = 0";
        mysqli_query($con, $update_query);
    }

    // Retrieve latest transactions
    $query = "SELECT * FROM transaction GROUP BY transaction_id ORDER BY transaction_id DESC LIMIT 5";
    $result = mysqli_query($con, $query);
    $output = '';

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
           
            $transaction_id = $row["transaction_id"];
            $nam="Soufi Oussama";
            $output .= '
            <li>
                <a href="transactiondoctor.php?id=' . $transaction_id . '">
                    <strong>DR ' . $nam . '</strong><br />
                    <small>Patient <em>' . $row["pname"] . '</em></small>
                </a>
            </li>';
        }
    } else {
        $output .= '<li><a href="#" class="text-bold text-italic">No Notifications Found</a></li>';
    }

    // Count unseen notifications
    $status_query = "SELECT COUNT(DISTINCT transaction_id) AS unseen_count FROM transaction WHERE status = 0";
    $result_query = mysqli_query($con, $status_query);
    $count = 0;

    if ($result_row = mysqli_fetch_assoc($result_query)) {
        $count = $result_row['unseen_count'];
    }

    // Prepare data to be sent as JSON response
    $data = array(
        'notification' => $output,
        'unseen_notification' => $count
    );

    echo json_encode($data);
}
?>
