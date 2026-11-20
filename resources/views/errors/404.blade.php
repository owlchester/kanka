@extends('layouts.error', [
    'error' => 404
])

@isset($visibilityExplanation)
    @section('error-details')
        @include('errors.partials.entity-visibility', ['explanation' => $visibilityExplanation])
    @endsection
@endisset
