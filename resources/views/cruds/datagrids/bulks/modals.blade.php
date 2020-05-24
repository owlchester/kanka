@if (!auth()->guest())
@include('cruds.datagrids.bulks.modals.permissions')
@include('cruds.datagrids.bulks.modals.batch')
@include('cruds.datagrids.bulks.modals.delete')
@endif
