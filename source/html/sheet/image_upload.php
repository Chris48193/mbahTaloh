<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image upload</title>
</head>
<body>
    <form>
        <input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
    </form>

    <script>
        let files_global = [];
        function handleFiles(files){
            files = [...files];
            files_global = [...files];
            (files).forEach(uploadFile);
        }

        function uploadFile(file){
            let url = 'process_upload2.php';
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
                
            })
            .catch((error) => {
                console.log(error)
            })
        }
    </script>
</body>
</html>