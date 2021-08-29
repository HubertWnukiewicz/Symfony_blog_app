
function addNewComment(blogId)
{
    //TODO: add loader-start
    let textAreaValue = $('#comment_textarea').val();

    if (textAreaValue.trim().length < 1) {
        //TODO: additional validation on backend side
        alert("You can't send empty comment!");
        return;
    }

    $.ajax({
        url:        '/blog/insert',
        type:       'POST',
        async:      true,
        data:        { blogId: blogId, comment: textAreaValue },  // data to submit

        success: function(data, status) {
            //TODO: add loader-stop
            let commentsSectionHeader = $('#comments_section_start');
            $(data).insertAfter(commentsSectionHeader);
            $('#comment_textarea').val("")
        },
        error : function(xhr, textStatus, errorThrown) {
            //TODO: add loader-stop
            alert('Ajax request failed.');
        }
    });
}
