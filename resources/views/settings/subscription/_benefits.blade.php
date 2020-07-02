<tbody>
<tr>
    <td>{{ __('tiers.features.file_size', ['size' => '1 MB']) }}</td>
    <td>{{ __('tiers.features.file_size', ['size' => '8 MB']) }}</td>
    <td>{{ __('tiers.features.file_size', ['size' => '25 MB']) }}</td>
</tr>
<tr>
    <td>{{ __('tiers.features.map_size', ['size' => '3 MB']) }}</td>
    <td>{{ __('tiers.features.map_size', ['size' => '10 MB']) }}</td>
    <td>{{ __('tiers.features.map_size', ['size' => '25 MB']) }}</td>
</tr>
<tr>
    <td>{{ __('tiers.features.pagination', ['amount' => 45]) }}</td>
    <td>{{ __('tiers.features.pagination', ['amount' => 100]) }}</td>
    <td>{{ __('tiers.features.pagination', ['amount' => 100]) }}</td>
</tr>
<tr>
    <td></td>
    <td><i class="fa fa-check"></i> 3 {!! link_to_route('front.features', __('tiers.features.boosters'), '#boost', ['target' => '_blank']) !!}</td>
    <td><i class="fa fa-check"></i> 10 {!! link_to_route('front.features', __('tiers.features.boosters'), '#boost', ['target' => '_blank']) !!}</td>
</tr>
<tr>
    <td></td>
    <td><i class="fa fa-check"></i> {{ __('tiers.features.discord') }}</td>
    <td><i class="fa fa-check"></i> {{ __('tiers.features.discord') }}</td>
</tr>
<tr>
    <td></td>
    <td><i class="fa fa-check"></i> {!! link_to_route('front.about', __('tiers.features.hall_of_fame'), '#patreon', ['target' => '_blank']) !!}</td>
    <td><i class="fa fa-check"></i> {!! link_to_route('front.about', __('tiers.features.hall_of_fame'), '#patreon', ['target' => '_blank']) !!}</td>
</tr>
<tr>
    <td></td>
    <td><i class="fa fa-check"></i> {{ __('tiers.features.nice_image') }}</td>
    <td><i class="fa fa-check"></i> {{ __('tiers.features.nice_image') }}</td>
</tr>
<tr>
    <td></td>
    <td><i class="fa fa-check"></i> {!! link_to_route('community-votes.index', __('tiers.features.community_vote'), ['target' => '_blank']) !!}</td>
    <td><i class="fa fa-check"></i> {!! link_to_route('community-votes.index', __('tiers.features.community_vote'), ['target' => '_blank']) !!}</td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td><i class="fa fa-check"></i> {{ __('tiers.features.vote_influence') }}</td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td><i class="fa fa-check"></i> {{ __('tiers.features.feature_influence') }}</td>
</tr>
<tr>
    <td>{{ __('tiers.features.api_requests', ['amount' => 30]) }}</td>
    <td>{{ __('tiers.features.api_requests', ['amount' => 90]) }}</td>
    <td>{{ __('tiers.features.api_requests', ['amount' => 90]) }}</td>
</tr>
</tbody>
