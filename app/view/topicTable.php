<!-- Topic managment view -->

<table class="rounded table table-hover table-dark text-center">
        <!-- Header of the table, shows the colmun's name. -->
        <thead class="thead-dark">
            <tr class="">
                <th scope="col">Name</th>
                <th scope="col">Subject</th>
                <th scope="col"># Reviews</th>
                <th scope="col">Next review on</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>

        <!-- The topic data area, main content of the table. -->
        <tbody>
			<?php
				include('../model/connection.php');
                // var_dump($_COOKIE['id']);
                $userId = $_COOKIE['id']; // possible fail after ajax petition
                $reviewQuery = 
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
                        subject.user = '$userId'";    
                $reviewResult = $connection->query($reviewQuery);
                if(!$reviewResult) {
                    echo "Error in query to get user's reviews";
                }

                while($reviewRow = $reviewResult->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
                    <th class="align-middle" scope="row">
                        <?php 
                            if(date('Y-m-d',strtotime($reviewRow['review_date'])) < date('Y-m-d')) {
                                echo '<i class="fas fa-exclamation-triangle mr-3 text-warning"></i>';
                            }
                            echo $reviewRow['name']; 
                        ?>
                    </th>
                    <td class="align-middle">
                        <?php 
                            $subjectId = $reviewRow['fk_subject'];
                            $subjectNameQuery = "SELECT name FROM subject WHERE id = '$subjectId'";
                            $subjectNameResult = $connection->query($subjectNameQuery);
                            $subjectNameRow = $subjectNameResult->fetch_array(MYSQLI_ASSOC);
                            echo $subjectNameRow['name'];
                        ?>

                    </td>

                    <!-- Progress of mastering the topic -->
                    <td class="align-middle">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" role="progressbar" style=
                        "
                            <?php
                                $progress = $reviewRow['number_of_review']; 
                                switch($progress) {
                                    case 0: echo 'width: 10%'; break;
                                    case 1: echo 'width: 20%'; break;
                                    case 2: echo 'width: 30%'; break;
                                    case 3: echo 'width: 40%'; break;
                                    case 4: echo 'width: 50%'; break;
                                    case 5: echo 'width: 60%'; break;
                                    case 6: echo 'width: 70%'; break;
                                    case 7: echo 'width: 80%'; break;
                                    case 8: echo 'width: 90%'; break;
                                    case 9: echo 'width: 100%'; break;
                                }
                            ?>
                        "
                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <?php 
                                $progress = $reviewRow['number_of_review'];
                                switch($progress) {
                                    // case 0: echo '10%'; break;
                                    case 1: echo '2'; break;
                                    case 2: echo '3'; break;
                                    case 3: echo '4'; break;
                                    case 4: echo '5'; break;
                                    case 5: echo '6'; break;
                                    case 6: echo '7'; break;
                                    case 7: echo '8'; break;
                                    case 8: echo '9'; break;
                                    case 9: echo '10'; break;
                                }
                                ?>
                        </div>
                    </div>
					</td>
					
					<td class="align-middle">
						<?php echo $reviewRow['review_date']; ?>
					</td>

                    <td class="align-middle">
                        <!-- * The result of an echo of PHP inside HTML must be bounded in '' 
                                in order to be manipulated as a string. * -->
                        <a onclick="loadEditView('<?php echo $reviewRow['review_id']?>')" class="text-dark mx-2 btn btn-warning">
                            <i class="fas fa-edit mx-1"></i> Edit
                        </a>
                        <a onclick="restoreTopicStatus('<?php echo $reviewRow['review_id']?>', 'topicTable')" class="
                        <?php
                            if(date('Y-m-d', strtotime($reviewRow['review_date'])) >= date('Y-m-d')) {
                                echo 'd-none';
                            }
                        ?>
                        text-light mx-2 btn btn-danger" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            <i class="fas fa-redo-alt mx-1"></i> Reset progress
                        </a>
                        <a onclick="deleteTopic('<?php echo $reviewRow['review_id']?>')" class="mx-2 btn btn-danger">
                            <i class="fas fa-trash-alt mx-1"></i> Delete
                        </a>

                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>

    <nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
    </nav>

    <div id="topicAlert" class="mx-auto mt-2 text-center"></div>