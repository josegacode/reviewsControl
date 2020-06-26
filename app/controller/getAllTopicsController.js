function getAllTopics() {
    $.ajax({
        type: "POST",
        url: 'app/model/getAllTopics.php',
        success: function(result) {
            if (result != 0) {
                $("#mainSection #topicMaker").html(' ');

                // Check if exists the table container, if not, creates it.
                // This case is used when the user is on edit section.
                if($("#tableContainer").length < 1) {
                    $("#mainSection")
                        .html('<div id="tableContainer" class="p-4 table-responsive"></div>');
                }
                $("#tableContainer").attr("class", "p-4 table-responsive");
                $("#mainSection #tableContainer").html(result);
            } else {
                alert("getAllTopicsController says: error at load all topics.");
            }

        }
    });
}