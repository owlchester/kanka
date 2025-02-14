<?php /** @var \App\Models\Entity $entity **/
$map = $entity->child;
?>
@extends('layouts.map', [
    'title' => $entity->name,
    'map' => $entity->child,
    'noHeader' => true,
])

@section('content')
    @include('maps._preview')
@endsection
