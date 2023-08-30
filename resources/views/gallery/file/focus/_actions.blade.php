
        {!! Form::model($image, ['route' => ['campaign.gallery.save-focus', $campaign, $image], 'method' => 'POST']) !!}
        <input type="submit" class="btn2 btn-error btn-outline" value="{{ __('campaigns/gallery.actions.reset_focus') }}">
        {!! Form::close() !!}

        {!! Form::model($image, ['route' => ['campaign.gallery.save-focus', $campaign, $image], 'method' => 'POST']) !!}
        {!! Form::hidden('focus_x', null) !!}
        {!! Form::hidden('focus_y', null) !!}
        <input type="submit" class="btn2 btn-primary" value="{{ __('entities/image.actions.save_focus') }}">
        {!! Form::close() !!}

