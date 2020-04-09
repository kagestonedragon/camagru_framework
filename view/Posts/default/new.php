<form enctype="multipart/form-data"
      method="post">
    <label>
        image file: <input type="file" id="file" name="image_file" value="">
        <div id="output">

        </div>
    </label>
    <br>
    <label>
        mask proportion -
        x: <input type="text" name="mask_size_x" value="">
        y: <input type="text" name="mask_size_y" value="">
        posX: <input type="text" name="mask_pos_x" value="">
        poxY: <input type="text" name="mask_pos_y" value="">
    </label>
    <br>
    <label>
        description: <input type="text" name="description" value="">
    </label>
    <br>
    <input type="submit" name="submit" value="Отправить">
</form>
<script>
    function handleFileSelect(evt) {
        var file = evt.target.files; // FileList object
        var f = file[0];
        // Only process image files.
        if (!f.type.match('image.*')) {
            alert("Image only please....");
        }
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
                // Render thumbnail.
                var span = document.createElement('span');
                span.innerHTML = ['<img height="100" src="', e.target.result, '" />'].join('');
                document.getElementById('output').insertBefore(span, null);
            };
        })(f);
        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }
    document.getElementById('file').addEventListener('change', handleFileSelect, false);
</script>