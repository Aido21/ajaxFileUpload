<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<input type="file" multiple="multiple" accept="image/*">
<a href="#" class="upload_files button">Загрузить файлы</a>
<div class="ajax-reply"></div>


<script>
    $(document).ready(function () {
        let files; // for files data
        //if file is changed let's fill files
        $('input[type=file]').on('change', function () {
            files = this.files;

        });

        function render(response) {
            let path_to_images;
            path_to_images = response.files;
            let html = '';
            $.each(path_to_images, function (key, val) {
                console.log(val);
                html += '<img src="' + val + '">';
            })

            $('.ajax-reply').html(html);
        }

        $('.upload_files').on('click', function (event) {

            event.stopPropagation();
            event.preventDefault();

            if (typeof files != 'undefined') {

                let data = new FormData(); //new FormmData object - we will use it to make the object to transfer to the server as it was generated by the form

                //fill the object with data to send
                $.each(files, function (key, value) {
                    console.log(value);
                    data.append(key, value);
                });


                data.append('images', 1); //add variavble to identified the request on the server side

                //and now the AJAX
            $.ajax({
                    url: './submit.php',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    cache: false,
                    processData: false, // to avoid that jQuery make a string from data
                    contentType: false, // tell jQuery to not set any content type header.
                })
                    .done(function (response) {
                        if (typeof response.error === 'undefined') {

                            render(response);
                        } else {
                            console.log('Error from server: ' + response.data);
                        }
                    })
                    .fail(function (jqxhr, status) {
                        console.log('Error in AJAX : ' + status, jqxhr);
                    });

            }
            //do nothing if files is empty
        });
    });
</script>
