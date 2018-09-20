<tr>
    @foreach ($days as $day)
        @include('calendar._day')
    @endforeach
</tr>