$( document ).ready(function() {
    //***************************************************************
    const dialogTitle = $( "#change_title_form" ).dialog({
        autoOpen: false,
        height: 400,
        width: 350,
        modal: true,
        buttons: {
            "Rename title": changeTitle,
            Cancel: function() {
                dialogTitle.dialog( "close" );
            }
        },

    });
    const dialogBlogContent = $( "#change_blog_content_form" ).dialog({
        autoOpen: false,
        height: 400,
        width: 450,
        modal: true,
        buttons: {
            "Change content": changeBlogContent,
            Cancel: function() {
                dialogBlogContent.dialog( "close" );
            }
        },
        // close: function() {
        //     formBlogContent[ 0 ].reset();
        // }
    });

    $("#edit_blog_content").button().on( "click", function() {
        dialogBlogContent.dialog( "open" );
    });

    //***************************************************************

    // const formTitle = dialogTitle.find( "change_title_form" ).on("submit", function( event ) {
    //     event.preventDefault();
    // });
    // const formBlogContent = dialogBlogContent.find( "change_blog_content_form" ).on("submit", function( event ) {
    //     event.preventDefault();
    // });

    function changeTitle()
    {
        let newTitle = $('#title_input').val();
        if (newTitle.trim().length < 1) {
            //TODO: additional validation on backend side
            alert("You can't send empty title!");
            return;
        }
        $.ajax({
            url:        '/blog/changeTitle',
            type:       'POST',
            async:      true,
            data:        { blogId: blogId, title: newTitle },  // data to submit

            success: function(data, status) {
                //TODO: add loader-stop
                $('#title_input').val(data);
                $('#blog_title_header').innerText = data;
                dialogTitle.dialog( "close" );
            },
            error : function(xhr, textStatus, errorThrown) {
                //TODO: add loader-stop
                alert('Ajax request failed.');
            }
        });
    }

    function changeBlogContent()
    {
        let newContent = $('#blog_content_input').val();
        if (newContent.trim().length < 1) {
            //TODO: additional validation on backend side
            alert("You can't send empty title!");
            return;
        }
        $.ajax({
            url:        '/blog/changeContent',
            type:       'POST',
            async:      true,
            data:        { blogId: blogId, blogContent: newContent },  // data to submit

            success: function(data, status) {
                //TODO: add loader-stop
                $('#blog_content')[0].innerHTML = data;
                $('#blog_content_input').val(data);
                dialogBlogContent.dialog( "close" );
            },
            error : function(xhr, textStatus, errorThrown) {
                //TODO: add loader-stop
                alert('Ajax request failed.');
            }
        });
    }

});


function addNewComment()
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

function hideComment(element, commentId)
{
    var button = $('#' + element.id);
    $.ajax({
        url:        '/comment/hide',
        type:       'POST',
        async:      true,
        data:        { commentId: commentId},  // data to submit

        success: function(data, status) {
            //TODO: add loader-stop
            button.attr("onClick","showComment(this, " + commentId + " )");
            button.text('Show');
        },
        error : function(xhr, textStatus, errorThrown) {
            //TODO: add loader-stop
            alert('Ajax request failed.');
        }
    });
}

function showComment(element, commentId)
{
    var button = $('#' + element.id);
    $.ajax({
        url:        '/comment/show',
        type:       'POST',
        async:      true,
        data:        { commentId: commentId},  // data to submit

        success: function(data, status) {
            //TODO: add loader-stop
            button.attr("onClick","hideComment(this, " + commentId + " )");
            button.text('Hide');
        },
        error : function(xhr, textStatus, errorThrown) {
            //TODO: add loader-stop
            alert('Ajax request failed.');
        }
    });
}
function removeComment(commentId)
{
    $.ajax({
        url:        '/comment/remove',
        type:       'POST',
        async:      true,
        data:        { commentId: commentId },  // data to submit

        success: function(data, status) {
            $('#comment_section_' +commentId).remove();
        },
        error : function(xhr, textStatus, errorThrown) {
            //TODO: add loader-stop
            alert('Ajax request failed.');
        }
    });
}


