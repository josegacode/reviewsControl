<!-- Retrieves all topics from DB and select 
a subgroup of them based on the index and topics 
per page values given by the controller of this API. -->

<?php
    include("connection.php");
    // var_dump($_POST);
    if(isset($_POST['userId']) && 
        isset($_POST['topicsPerPage']) &&
        isset($_POST['indexBegin'])) {
        // var_dump($_POST);

        $userId = $_POST['userId'];
        $topicsPerPage = $_POST['topicsPerPage'];
        $indexBegin = $_POST['indexBegin']; // First index of page required
        $getTopicsQuery = 
            "SELECT 
                review.review_id,
                review.name,
                review.fk_subject,
                review.review_date,
                review.number_of_review 
            FROM 
                review, 
                subject
            WHERE 
                review.fk_subject = subject.id AND 
                subject.user = '$userId' AND 
                review.review_date <= curdate()";    

        // Returns a mysql_result object
        $getTopicsResult = $connection->query($getTopicsQuery);
        
        if($getTopicsResult) {
            // var_dump($getTopicsResult);
            $htmlContent = ""; // Table which contains the new topics
            // $topics = [];
            // while($topic = $getTopicsResult->fetch_array(MYSQLI_ASSOC)) $topics = $topic;
            // var_dump(count($topics));

            // echo "Ok ----- ";
            $limitFlag = 0; // For know how many topics was displayed
            // $topic = $getTopicsResult->fetch_array(MYSQLI_BOTH);
            // var_dump($topic);
            // for($i = $indexBegin; $limitFlag <= $topicsPerPage && $i < $getTopicsResult->num_rows; $i++) {
            while($topic = $getTopicsResult->fetch_array(MYSQLI_BOTH)) {
                switch($topic['number_of_review']) {
                    case 0: 
                        $progressBarWidth = 'width: 10%'; 
                        $progress = 1;
                    break;
                    case 1: 
                        $progressBarWidth = 'width: 20%'; 
                        $progress = 2;
                    break;
                    case 2: 
                        $progressBarWidth = 'width: 30%'; 
                        $progress = 3;
                    break;
                    case 3: 
                        $progressBarWidth = 'width: 40%'; 
                        $progress = 4;
                    break;
                    case 4: 
                        $progressBarWidth = 'width: 50%'; 
                        $progress = 5;
                    break;
                    case 5: 
                        $progressBarWidth = 'width: 60%'; 
                        $progress = 6;
                    break;
                    case 6: 
                        $progressBarWidth = 'width: 70%'; 
                        $progress = 7;
                    break;
                    case 7: 
                        $progressBarWidth = 'width: 80%'; 
                        $progress = 8;
                    break;
                    case 8: 
                        $progressBarWidth = 'width: 90%'; 
                        $progress = 9;
                    break;
                    case 9: 
                        $progressBarWidth = 'width: 100%';
                        $progress = 10;
                     break;
                } 

                if(date('Y-m-d', strtotime($topic['review_date'])) >= date('Y-m-d')) $showRestoreButton = 'd-none';
                else $showRestoreButton = '';

                // Construction of each topic row
                $htmlContent .= '
                    <tr>
                        <td class="align-middle">' . $topic['name'] . '</td>
                        <td class="align-middle">' . '[subject name]' . '</td>
                        <td class="align-middle"> 
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="' . $progressBarWidth . '"' . 
                                'aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">' .
                        '</td>' .

                        '<td class="align-middle">
                        <a onclick="completeTopic( ' .
                            $topic['review_id'] . ', ' .
                            $topic['review_date'] . ', ' .
                            $topic['number_of_review'] . ')" class="mx-2 btn btn-lg btn-success">
                            <i class="fas fa-check mx-1"></i> Review 
                        </a>

                        <a onclick="restoreTopicStatus(' . $topic['review_id'] . ', "reviewTable")" class=" ' .
                           $showRestoreButton . 
                        'text-light mx-2 btn btn-lg btn-danger" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            <i class="fas fa-redo-alt mx-1"></i> Restore
                        </a>
                    </td>' .

                    '</tr>';
                $limitFlag++;
            }
            
            echo $htmlContent;
        } else echo -2;
    } else {
        echo "Error: some variable of POST isn't defined -> " . var_dump($_POST);
        echo -1;
    } 

?>