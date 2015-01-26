function deleteAccount() {
    var choice = confirm("Are you sure?");
    return choice;
}

function showImage() {
    var files = document.getElementById("file_upload").files;
    var imageHolder = document.getElementById("user_pic");


    if (window.File && window.FileReader)
    {
        if (!files[0].type.match("image.*"))
        {
            alert("Selected file is not an image");
            document.getElementById("file_upload").value = "";
            return;
        }
        
        var reader = new FileReader();
        
        reader.onload = function() {
            imageHolder.src = reader.result;
        };
        
        reader.readAsDataURL(files[0]);
    }
    else
        alert("File API's are not supported by your browser");
}