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

/**
 * Epic Editor initialization
 * @returns {EpicEditor|getEpicEditorForWriting.editor}
 */
function getEpicEditorForWriting() {
    this.editor = null;
    this.maxChars = 1200;
    
    if (editor !== null)
        return editor;

    var options = {
        container: "epiceditor",
        textarea: 'text',
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
            edit: false,
            preview: false,
            fullscreen: false,
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
    
    var previewButton = document.getElementById("preview");
    previewButton.onclick = function() {
        if (editor.is('preview')) editor.edit();
        else editor.preview();
    }
    
    var clearButton = document.getElementById("clear");
    var text = document.getElementById('text');
    clearButton.onclick = function() {
        if (confirm("Are you sure?")) {
            editor.getElement("editor").body.innerHTML = "";
            text.innerHTML = "";
            updateCharLeft(maxChars, 0);
        }
    }
    
    var fullScreenButton = document.getElementById("full");
    fullScreenButton.onclick = function() {
        editor.enterFullscreen();
    }
    
    var charLeft = document.getElementById('char-left');
    function updateCharLeft(max, used) {
        charLeft.innerHTML = (max - used) + " left";
    }
    
    editor.on('load', function() {
        editor.getElement('editor').body.innerHTML = "";
        editor.getElement('editor').body.onkeyup = function() {
            var string = text.value;
            string = string.trim();
            updateCharLeft(maxChars, string.length);
        }
    });
    
    editor.load();
}

function savePost() {
    
}

/**
 * Function to redirect to 'page' with 'value'
 */
function redirect(value, page) {
    var form = document.getElementById("operation");
    var input = document.getElementsByName("action");
    
    input[0].value = value;
    form.action = page;
    form.submit();
}

function xmlRequest(method, url, element) {
    var xml = new XMLHttpRequest();
    xml.open(method, url, true);
    xml.send();

    xml.onreadystatechange = function () {
        if (xml.readyState == 4 && xml.status == 200) {
            element.innerHTML = xml.responseText;
        }
    }
}

function getMyPosts() {
    var element = document.getElementById("display-container");
    xmlRequest("GET", "myposts.php", element);
}

function deletePost(id) {
    xmlRequest("GET", "deletepost.php?pid=" + id);
    getMyPosts();
}