@if (Auth::check() && Auth::user()->isAdmin())
    <td class="text-center">
    @if ($model->is_private)
            <i class="fa fa-lock" title="{{ __('crud.is_private') }}"></i>
    @endif
    </td>
@endif