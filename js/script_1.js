/**
 * Function to confirm account deletion.
 * @returns boolean
 */
function deleteAccount() {
    var choice = confirm("Are you sure?");
    return choice;
}

/**
 * Function to display image when user choose an image for upload.
 * @returns Nothing
 */
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

function getEpicEditorForWriting() {
    var options = {
        container: "epiceditor",
        textarea: null,
        basePath: "epiceditor",
        clientSideStorage: true,
        localStorageName: "epiceditor",
        useNativeFullScreen: true,
        parser: marked,
        file: {
            name: "epiceditor",
            defaultContent: "",
            autoSave: 100
        },
        theme: {
            base: "/themes/base/epiceditor.css",
            preview: "/themes/preview/github.css",
            editor: "/themes/editor/epic-light.css"
        },
        button: {
            preview: true,
            fullscreen: true,
            bar: "auto"
        },
        focusOnLoad: false,
        shortcut: {
            modifier: 18,
            fullscreen: 70,
            preview: 80
        },
        string: {
            togglePreview: "Toggle Preview Mode",
            toggleEdit: "Toggle Edit Mode",
            toggleFullScreen: "Enter Full Screen"
        },
        autogrow: false
    }
    
    var editor = new EpicEditor(options);
    return editor;
}