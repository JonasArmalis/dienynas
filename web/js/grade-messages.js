
function updateMessage() {
    var gradeID = $('#gradeSelect').find(":selected").val();

    $.ajax({
        url: "fetch-message.php",
        type: 'GET',
        dataType: 'json', // added data type
        data: {id: gradeID},
        success: function(res) {
            var data = JSON.parse(res);
            $('#message').val(data.message);
        }
    });
}
