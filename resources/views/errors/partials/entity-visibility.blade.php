<section class="mx-auto w-full max-w-3xl rounded-lg bg-white/10 p-4 text-left sm:p-6" aria-labelledby="entity-visibility-title">
    <div class="flex flex-col gap-4">
        <h3 id="entity-visibility-title" class="text-lg font-semibold">{{ __('errors.entity-visibility.title', ['member' => $explanation['member']]) }}</h3>
        <p>{{ __('errors.entity-visibility.reasons.' . $explanation['reason'], ['member' => $explanation['member']]) }}</p>
        @if ($explanation['reason'] === 'role-deny')
            <ul class="list-disc ps-6">
                @foreach ($explanation['blockingRoles'] as $role)
                    <li>{{ $role }}</li>
                @endforeach
            </ul>
        @endif

        <div class="overflow-x-auto" role="region" aria-labelledby="entity-visibility-title" tabindex="0">
            <table class="w-full text-sm">
                <caption class="sr-only">{{ __('errors.entity-visibility.comparison') }}</caption>
                <thead>
                    <tr>
                        <th scope="col" class="p-2">{{ __('errors.entity-visibility.role') }}</th>
                        <th scope="col" class="p-2">{{ __('errors.entity-visibility.membership', ['member' => $explanation['member']]) }}</th>
                        <th scope="col" class="p-2">{{ __('errors.entity-visibility.module-view', ['module' => $explanation['module']]) }}</th>
                        <th scope="col" class="p-2">{{ __('errors.entity-visibility.entity-view') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($explanation['roles'] as $role)
                        <tr>
                            <th scope="row" class="p-2 font-medium">{{ $role['name'] }}</th>
                            <td class="p-2">{{ __('errors.entity-visibility.settings.' . $role['membership']) }}</td>
                            <td class="p-2">{{ __('errors.entity-visibility.settings.' . $role['module']) }}</td>
                            <td class="p-2">{{ __('errors.entity-visibility.settings.' . $role['entity']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p>{{ __('errors.entity-visibility.direct', [
            'member' => $explanation['member'],
            'setting' => __('errors.entity-visibility.settings.' . $explanation['direct']),
        ]) }}</p>
    </div>
</section>
