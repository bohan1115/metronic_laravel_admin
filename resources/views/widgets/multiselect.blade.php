<div class="form-group">
    <label class="control-label col-md-3">{{$options['label']}}</label>
    <div class="col-md-6">
        <select multiple="multiple" class="multi-select" id="{{$options['real_name']}}" name="{{$options['real_name']}}[]">
            @foreach($options['data'] as $key=>$value)
                <option value="{{$key}}"
                        <?php
                                if($options['value'])
                                {
                                    foreach($options['value'] as $item)
                                    {
                                        if($item['id'] == $key)
                                        {
                                            echo 'selected';
                                            break;
                                        }
                                    }
                                }
                                ?>
                        >{{$value}}</option>
            @endforeach
        </select>
        <button type="button" class="btn btn-primary allchoice"><i class="glyphicon glyphicon-arrow-right"></i></button>
        <button type="button" class="btn btn-primary alldelete"><i class="glyphicon glyphicon-arrow-left"></i></button>
        @if($options['help_block']['text'])
            <{{$options['help_block']['tag']}} {!! $options['help_block']['helpBlockAttrs'] !!}>{{$options['help_block']['text']}}</{{$options['help_block']['tag']}}>
        @endif
    </div>
</div>
