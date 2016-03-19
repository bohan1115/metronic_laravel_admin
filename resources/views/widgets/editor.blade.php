<div class="form-group">
    <label class="control-label col-md-3">{{$options['label']}}</label>
    <div class="col-md-6">
        <script id="editor" style="height:300px;" name="{{$options['real_name']}}" type="text/plain">
            <?php
                if($options['value'])
                {
                    echo $options['value'];
                }
            ?>
        </script>
    </div>
</div>