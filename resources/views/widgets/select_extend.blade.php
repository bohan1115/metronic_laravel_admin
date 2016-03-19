<div class="form-group">
    <label class="control-label col-md-3">{{$options['label_select']}}</label>
    <div class="col-md-6">
        <select class="form-control" id="{{$options['select_name']}}" name="{{$options['select_name']}}" onchange="selChanged()">
            @foreach($options['type_data'] as $key=>$value)
                <option value="{{$key}}"
                <?php
                        if($options['value'])
                        {
                            if($options['value']['type'] == $key)
                            {
                                echo 'selected';
                            }
                        }
                        ?>
                        >{{$value}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">{{$options['label_follow']}}</label>
    <div class="col-md-6" id="follow_control">
        <input class="form-control" name="{{$options['follow_name']}}" id="{{$options['follow_name']}}" value="<?php
            if($options['value'])
            {
                echo $options['value']['content'];
            }
        ?>">
        <div id="follow_block"></div>

    </div>
</div>