@include('cruds.datagrids.bulks.modals.ajax')
@include('cruds.datagrids.bulks.modals.delete')
@includeWhen(isset($bulk), 'cruds.datagrids.bulks.modals.batch')
