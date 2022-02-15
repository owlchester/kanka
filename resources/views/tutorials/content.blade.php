<div class="modal-header">
    <h4 class="modal-title" id="tutorialModalTitle">@yield('title')</h4>
</div>
<div class="modal-body">
    @yield('body')
</div>

@if (view()->hasSection('footer'))
<div class="modal-footer">
    @yield('footer')
</div>
@endif
