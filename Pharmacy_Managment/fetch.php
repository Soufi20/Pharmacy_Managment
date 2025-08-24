<?php

include('connect.php');

if(isset($_POST['view'])){

    if($_POST["view"] != '') {
        // Update status for all rows with the same prescription_id where status is 0
        $update_query = "UPDATE prescription SET status = 1 WHERE status=0";
        mysqli_query($con, $update_query);
    }

   
    $query = "SELECT * FROM prescription GROUP BY id ORDER BY id DESC LIMIT 5";
    $result = mysqli_query($con, $query);
    $output = '';
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $prescription_id = $row["id"];
            $output .= '
            <li>
                <a href="validp.php?id=' . $prescription_id . '">
                    <strong>DR ' . $row["doctor"] . '</strong><br />
                    <small>Patient <em>' . $row["pname"] . '</em></small>
                </a>
            </li>';
        }
    } else {
        $output .= '<li><a href="#" class="text-bold text-italic">No Notifications Found</a></li>';
    }

    $status_query = "SELECT COUNT(DISTINCT id) AS unseen_count FROM prescription WHERE status = 0";
    $result_query = mysqli_query($con, $status_query);
    $count = 0;
    if ($result_row = mysqli_fetch_assoc($result_query)) {
        $count = $result_row['unseen_count'];
    }


    $data = array(
        'notification' => $output,
        'unseen_notification' => $count
    );

    echo json_encode($data);
}
?>
