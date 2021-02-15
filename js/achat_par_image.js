let dropArea = document.getElementById('dropArea_factures');
let progressBar = document.getElementById('progress_bar_factures');
let upload_names = document.getElementById('uploads_names_factures');
url = '../../../php/process_upload.php'


let filesDone = 0;
let filesToDo = 0;
let files_global = [];

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false)
});

['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false)
});

['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false)
});

dropArea.addEventListener('drop', handleDrop, false);

//Function qui gere l'upload de plusieurs fichiers
function handleFiles(files){
    files = [...files];
    files_global = [...files];
    initializeProgress(files.length);
    (files).forEach(uploadFile);
}

//Function d'upload
function uploadFile(file){
    let formData = new FormData;

    formData.append('file', file);
    //When a data from a form is appended to this object, the data can be retrieved
    //from php according to the data type. Files are retrieved from the superglobal
    //FILE and text types are retrieved from superglobal POST or GET according to the
    //sending method

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then((response) => {
        progressDone();
    })
    .catch((error) => {
        console.log(error)
    })
}

function handleDrop(e) {
    let dt = e.dataTransfer; //used to hold the data that is being dragged during a drag and drop operation.
    let files = dt.files;

    handleFiles(files);
}

function highlight(e){
    dropArea.classList.add('highlight')
}

function unhighlight(e){
    dropArea.classList.remove('highlight')
}

function preventDefaults(e){
    e.preventDefault()
    e.stopPropagation()
}

function initializeProgress(numfiles){
    progressBar.value = 0;
    filesDone = 0;
    filesToDo = numfiles;
}

function progressDone() {
    filesDone++
    console.log(files_global[filesDone-1].name);
    upload_names.innerHTML += files_global[filesDone-1].name + '<br>';
    progressBar.value = filesDone / filesToDo * 100;
}

//Reste du formulaire (nombre de jour et info additionelle)

/*number_of_days = 1;
additional_information = "sd";
let formData = new FormData;

function numb_days(e)
{
    number_of_days = e.value;
    formData.append('number_of_days', number_of_days);
    console.log(number_of_days);
}

function additional_info(e)
{
    additional_information = e.value;
    formData.append('additional_information', additional_information);
    console.log(additional_information);
}

function submit_form()
{
    url = '../php/process_upload.php';
    this.preventDefaults;
    fetch(url, {
            method: 'POST',
            body: formData
        })
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error)
        })
}*/