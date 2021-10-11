@if (!auth()->guest())
@includeWhen(!isset($noBulkPermissions), 'cruds.datagrids.bulks.modals.permissions')
@includeWhen(isset($bulk), 'cruds.datagrids.bulks.modals.batch')
@includeWhen(isset($bulk), 'cruds.datagrids.bulks.modals.transform')
@include('cruds.datagrids.bulks.modals.delete')
@endif
