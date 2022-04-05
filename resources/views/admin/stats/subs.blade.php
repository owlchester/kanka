@extends('layouts.admin', [
    'title' => 'Subs stats',
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('admin.home'), 'label' => 'Subs stats']
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>Period</th>
            <th>Count</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($stats as $period => $count)
            <tr>
                <td>{{ $period }}</td>
                <td>{{ $count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
