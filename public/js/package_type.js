function buyPackage(packageId)
{
    $.ajax({
        url:        '/packages/buy',
        type:       'POST',
        async:      true,
        data:        { packageId: packageId },  // data to submit

        success: function(data, status) {
            alert(data);
        },
        error : function(xhr, textStatus, errorThrown) {
            alert('Ajax request failed.');
        }
    });
}
