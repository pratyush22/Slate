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


    if (window.File && window.FileReader) {
        if (!files[0].type.match("image.*")) {
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
            editor: "/themes/editor/epic-light.css"
        },
        button: {
            edit: false,
            preview: false,
            fullscreen: false,
            bar: "auto"
        },
        focusOnLoad: true,
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
    
    this.editor.load();
    var string = text.value;
    string = string.trim();
    if (string !== "") {
        this.editor.importFile("epiceditor", string);
    }
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

/**
 * Ajax helper function
 * @param string method
 * @param string url
 * @param DOM object element
 * @param string string
 * @returns {undefined}
 */
function xmlRequest(method, url, element, string) {
    var xml = new XMLHttpRequest();
    xml.open(method, url, true);
    
    if (method === "GET") xml.send();
    else {
        xml.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xml.send(string);
    }

    xml.onreadystatechange = function () {
        if (xml.readyState === 4 && xml.status === 200) {
            element.innerHTML = xml.responseText;
        }
    };
}

/**
 * Function to display users post.
 */
function getMyPosts() {
    var element = document.getElementById("display-container");
    xmlRequest("GET", "myposts.php", element);
}

/**
 * Function to delete post with specific id.
 * @param number id
 */
function deletePost(id) {
    if (confirm("Are you sure?")) {
        xmlRequest("GET", "deletepost.php?pid=" + id);
        getMyPosts();
    }
}

/**
 * Function to save the post
 */
function savePost() {
    var title = document.getElementById("title").value;
    title = title.trim();
    
    var content = document.getElementById("text").value;
    content = content.trim();
    
    if (content.length > 1200)
    {
        alert("Character limit crossed, can't save");
        return;
    }
    
    var pid = document.getElementById("pid").value;
    var uid = document.getElementById("uid").value;
    
    var string = "title=" + title + "&content=" + content + "&pid=" + pid + "&uid=" + uid;
    var xml = new XMLHttpRequest();
    xml.open("POST", "savepost.php", true);
    xml.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xml.send(string);
    
    xml.onreadystatechange = function() {
        if (xml.readyState === 4 && xml.status === 200) {
            alert("Saved");
        }
    };
}

/**
 * Function to open writer page with edit options.
 * @param numeric pid
 * @param numeric uid
 * @returns {undefined}
 */
function editPost(pid, uid) {
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "writer.php");
    
    var field = document.createElement("input");
    field.setAttribute("type", "hidden");
    field.setAttribute("name", "pid");
    field.setAttribute("value", pid);
    form.appendChild(field);
    
    field = document.createElement("input");
    field.setAttribute("type", "hidden");
    field.setAttribute("name", "uid");
    field.setAttribute("value", uid);
    form.appendChild(field);
    
    field = document.createElement("input");
    field.setAttribute("type", "hidden");
    field.setAttribute("name", "action");
    field.setAttribute("value", "edit");
    form.appendChild(field);
    
    document.body.appendChild(form);
    form.submit();
}

function publishPost(element) {
    var pid = document.getElementById("pid").value;
    var string = "pid=" + pid;
    xmlRequest("POST", "publishpost.php", element, string);
    element.onclick = function () {
        revertPost(element);
    };
    alert("Post published");
}

function revertPost(element) {
    var pid = document.getElementById("pid").value;
    var string = "pid=" + pid;
    xmlRequest("POST", "revertpost.php", element, string);
    element.onclick = function () {
        publishPost(element);
    };
    alert("Post reverted");
}

function recentPosts() {
    var element = document.getElementById("display-container");
    xmlRequest("GET", "recentposts.php", element);
}

function loadEpicEditor() {
    this.editor = null;
    
    var options = {
        container: "epiceditor",
        textarea: 'text',
        basePath: "epiceditor",
        clientSideStorage: false,
        localStorageName: "epiceditor",
        useNativeFullScreen: false,
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
    
    this.editor = new EpicEditor(options);
    this.editor.load();
    
    var text = document.getElementById("text").value;
    text = text.trim();
    this.editor.importFile("epiceditor", text);
    this.editor.preview();
}