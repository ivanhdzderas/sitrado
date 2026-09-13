<?php
$nombre_actividad="";

foreach ($general as $pro) {
    $nombre_actividad=$pro->solucion;
}
$query=login_model()->buscar_archivo_8d($solucion,$tipo);
$cuantos=$query->getNumRows();

if ($cuantos==0){
?>


    <link href="<?php echo base_url()?>assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url()?>assets/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
  
    <script src="<?php echo base_url()?>assets/js/plugins/sortable.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>assets/js/fileinput.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>assets/js/locales/fr.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>assets/js/locales/es.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>assets/themes/explorer/theme.js" type="text/javascript"></script>
    



<center><b>Nombre Actividad: <?php echo $nombre_actividad ?></b>

</center>
 <form enctype="multipart/form-data">

        <input id="file-es" multiple="multiple" name="solucion=<?php echo $solucion?>" name="file-es[]" value="<?php echo $solucion?>" type="file" multiple>
    </form>
    <script>
    
    $('#file-es').fileinput({
        language: 'es',
        uploadUrl: '<?php echo base_url()?>login/subir3',
        showRemove: false,
        method: "POST",
        allowedFileExtensions: ['jpg', 'png', 'gif','doc','docx','pdf','xls','xlsx','zip','rar']
    });
    $("#file-0").fileinput({
        'allowedFileExtensions': ['jpg', 'png', 'gif','doc','docx','pdf','xls','xlsx','zip','rar']
    });
    $("#file-1").fileinput({
        uploadUrl: '#', // you must set a valid URL here else you will get an error
        allowedFileExtensions: ['jpg', 'png', 'gif','doc','docx','pdf','xls','xlsx','zip','rar'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 10,
        //allowedFileTypes: ['image', 'video', 'flash'],
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });
    /*
     $(".file").on('fileselect', function(event, n, l) {
     alert('File Selected. Name: ' + l + ', Num: ' + n);
     });
     */
    $("#file-3").fileinput({
        showUpload: false,
        showCaption: false,
        browseClass: "btn btn-primary btn-lg",
        fileType: "any",
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: [
            "http://lorempixel.com/1920/1080/transport/1",
            "http://lorempixel.com/1920/1080/transport/2",
            "http://lorempixel.com/1920/1080/transport/3"
        ],
        initialPreviewConfig: [
            {caption: "transport-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1},
            {caption: "transport-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2},
            {caption: "transport-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3}
        ]
    });
    $("#file-4").fileinput({
        uploadExtraData: {kvId: '10'}
    });
    $(".btn-warning").on('click', function () {
        var $el = $("#file-4");
        if ($el.attr('disabled')) {
            $el.fileinput('enable');
        } else {
            $el.fileinput('disable');
        }
    });
    $(".btn-info").on('click', function () {
        $("#file-4").fileinput('refresh', {previewClass: 'bg-info'});
    });
    /*
     $('#file-4').on('fileselectnone', function() {
     alert('Huh! You selected no files.');
     });
     $('#file-4').on('filebrowse', function() {
     alert('File browse clicked for #file-4');
     });
     */
    $(document).ready(function () {
        $("#test-upload").fileinput({
            'showPreview': false,
            'allowedFileExtensions': ['jpg', 'png', 'gif','doc','docx','pdf','xls','xlsx','zip','rar'],
            'elErrorContainer': '#errorBlock'
        });
        $("#kv-explorer").fileinput({
            'theme': 'explorer',
            'uploadUrl': '#',
            overwriteInitial: false,
            initialPreviewAsData: true,
            initialPreview: [
                "http://lorempixel.com/1920/1080/nature/1",
                "http://lorempixel.com/1920/1080/nature/2",
                "http://lorempixel.com/1920/1080/nature/3"
            ],
            initialPreviewConfig: [
                {caption: "nature-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1},
                {caption: "nature-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2},
                {caption: "nature-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3}
            ]
        });
        /*
         $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
         alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
         });
         */
    });
</script>
<?php
}else{
    print_r("<center><b>En espera de autorizacion</b></center>");
}
?>