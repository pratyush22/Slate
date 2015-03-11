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
    this.editor = null;
    
    if (editor !== null)
        return editor;

    var options = {
        container: "epiceditor",
        textarea: null,
        basePath: "epiceditor",
        clientSideStorage: false,
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
            editor: "/themes/editor/epic-dark.css"
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
        autogrow: true
    };
    
    editor = new EpicEditor(options);
    
    var previewBtns = document.getElementsByName("preview");
    for (var i = 0; i < previewBtns.length; i++) {
        previewBtns[i].onclick = function() {
            if (editor.is("preview")) editor.edit();
            else editor.preview();
        }
    }
    
    var clearBtns = document.getElementsByName("clear");
    for (var i = 0; i < clearBtns.length; i++) {
        clearBtns[i].onclick = function() {
            if (confirm("Are you sure?"))
                editor.getElement('editor').body.innerHTML = "";
        }
    }
    
    return editor;
}