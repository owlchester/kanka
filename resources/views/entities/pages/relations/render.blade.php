
@includeWhen($mode == 'map' || (empty($mode) && $campaign->boosted()), 'entities.pages.relations._map')
@includeWhen($mode == 'table' || (empty($mode) && !$campaign->boosted()), 'entities.pages.relations._tables')
