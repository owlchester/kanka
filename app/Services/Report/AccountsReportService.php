<?php

namespace App\Services\Report;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccountsReportService extends BaseReportService
{
    public function name(): string
    {
        return 'Accounts Report';
    }

    public function getStats(Carbon $start, Carbon $end): array
    {
        $newAccounts = DB::table('users')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        if ($newAccounts === 0) {
            return [
                'new_accounts' => 0,
                'accounts_with_entities' => 0,
                'entities_created' => 0,
            ];
        }

        $accountsWithEntities = DB::table('users')
            ->join('entities', function ($join) {
                $join->on('entities.created_by', '=', 'users.id')
                    ->where('entities.source', '=', 'user');
            })
            ->whereBetween('users.created_at', [$start, $end])
            ->distinct()
            ->count('users.id');

        $entitiesCreated = DB::table('entities')
            ->join('users', 'users.id', '=', 'entities.created_by')
            ->whereBetween('users.created_at', [$start, $end])
            ->where('entities.source', 'user')
            ->count();

        return [
            'new_accounts' => $newAccounts,
            'accounts_with_entities' => $accountsWithEntities,
            'entities_created' => $entitiesCreated,
        ];
    }

    public function buildTerminalLines(array $current, array $previous): array
    {
        return [
            $this->formatMetricLine('New Accounts', $current['new_accounts'], $previous['new_accounts']),
            $this->formatMetricLine('Accounts that Created Entities', $current['accounts_with_entities'], $previous['accounts_with_entities'], $current['new_accounts']),
            $this->formatMetricLine('Entities Created by New Accounts', $current['entities_created'], $previous['entities_created']),
        ];
    }

    public function buildDiscordBody(array $current, array $previous): string
    {
        return implode("\n", [
            $this->formatMetricText('New Accounts', $current['new_accounts'], $previous['new_accounts']),
            $this->formatMetricText('Accounts that Created Entities', $current['accounts_with_entities'], $previous['accounts_with_entities'], $current['new_accounts']),
            $this->formatMetricText('Entities Created by New Accounts', $current['entities_created'], $previous['entities_created']),
        ]);
    }
}
