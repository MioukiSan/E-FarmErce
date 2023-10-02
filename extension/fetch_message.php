<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sellerId = $_POST['sellerId'];
    $userId = $_POST['userId'];
    $output = "";


    $sql = "SELECT * FROM messages WHERE (incoming_msg_id = ? AND outgoing_msg_id = ?) OR (incoming_msg_id = ? AND outgoing_msg_id = ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'iiii', $sellerId, $userId, $userId, $sellerId);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)) {
                   if($row['outgoing_msg_id'] == $userId){ //user is the sender
                    $output .= '<div class="chat outgoing mb-3 w-75 ms-auto d-flex justify-content-end text-break">
                                    <div class="details rounded outgoing-text p-2">
                                        <p class=" mb-0">
                                            '. $row['msg'].'
                                        </p>
                                    </div>
                                </div> ';
                   } else { //user is receiver
                    $output .=  '<div class="chat incoming mb-3 w-75 d-flex text-break">
                                    <i class="bi bi-person-circle fs-5 align-self-end me-2"></i>
                                    <div class="details bg-white rounded incoming-text p-2">
                                        <p class=" mb-0">
                                           '.$row['msg'] .'
                                        </p>
                                    </div>
                                </div>';
                   }
                }
            }


            echo $output;
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>
