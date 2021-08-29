$( document ).ready(function() {
    var dialog, form;

    dialog = $( "#change-title-form" ).dialog({
        autoOpen: false,
        height: 400,
        width: 350,
        modal: true,
        buttons: {
            "Rename title": changeTitle,
            Cancel: function() {
                dialog.dialog( "close" );
            }
        },
        close: function() {
            form[ 0 ].reset();
        }
    });

    form = dialog.find( "form" ).on("submit", function( event ) {
        event.preventDefault();
    });

    $( "#rename-title" ).button().on( "click", function() {
        dialog.dialog( "open" );
    });

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
                dialog.dialog( "close" );
            },
            error : function(xhr, textStatus, errorThrown) {
                //TODO: add loader-stop
                alert('Ajax request failed.');
            }
        });
    }

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

});





