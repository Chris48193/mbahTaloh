<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Upload</title>
    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/acd1bbd1c0.js" crossorigin="anonymous"></script>
    <link href="../css/index.css" rel="stylesheet">
</head>
<body>

<?php
        if (isset($_vmf))
        {
            $number_of_files = count($_FILES['model']['name']);
            print_r($_FILES['model']['name']);
            echo $number_of_files;

            for ($i=0; $i < $number_of_files; $i++)
            {
                $filename = $_FILES['model']['name'][$i];
                // Testons si le fichier n'est pas trop gros
                if ($_FILES['model']['size'][$i] <= 10000000)
                {
                    // Testons si l'extension est autorisée
                    $infosfichier = pathinfo($_FILES['model']['name'][$i]);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                    if (in_array($extension_upload, $extensions_autorisees))
                    {
                        move_uploaded_file($_FILES['model']['tmp_name'][$i], '../files/'.$filename);
                        echo "L'envoi a bien été effectué !";
                    }
                }
            }
        }
?>

    <div id = "app" class = "container">
        <form enctype="multipart/form-data" method = "post" v-on:submit.prevent>
            <div class="form-group">
                <label for="model">Add files</label>
                <input type="file" name = "model[]" v-on:change="init_app" class="form-control-file" id="model" multiple>
            </div>
            <div v-for="file_name in file_names">
                {{ file_name }}
            </div>
            <div v-for="file in files">
                {{ file }}
            </div>
            <button type="submit" v-on:click="send_files" name = "submit" class="btn btn-primary mb-2">Send file</button>
        </form>
    </div>

    
    <!-- Calling jquery, popper and bootstrap's javascript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        new Vue({
                el: '#app',
                mounted:function(){
                    },
                data: {
                    error: false,
                    file_names: [],
                    selectedFile: [],
                    files: [],
                    formData: new FormData(),
                },
                methods: {
                    init_app:function(){
                        var vm = this;
                        vm.selectedFile = document.querySelector('[type=file]').files;
                        for (let i = 0; i < vm.selectedFile.length; i++) 
                        {
                            vm.file_names.push(vm.selectedFile[i].name);
                            vm.formData.append('model[]', vm.selectedFile[i]);
                        }
                    },
                    send_files:function(){
                        var vm = this;
                        fetch("process_upload.php", {
                            method: 'POST',
                            body: vm.formData,
                        })
                        .then((response) => {
                            console.log(response)
                        })
                    },
                }
            })
    </script>
</body>
</html>