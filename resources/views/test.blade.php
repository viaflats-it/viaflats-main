<!DOCTYPE html>
<html>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
</head>
<body>

<div class="container">
    {!! Form::open(['url'=>'uploadFiles','class'=>'dropzone','id'=>'MyDropzone']) !!}
    {!! Form::close() !!}
</div>


<script type="text/javascript">

    Dropzone.options.MyDropzone = {
        dictDefaultMessage:'Here\'s the message',
        paramName: "file",
        maxFiles:1,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        }
    };

</script>
</body>
</html>
