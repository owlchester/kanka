@includeWhen($post->layout_id && $campaign->superboosted(), 'entities.components._post_layouts')
@includeWhen(!$post->layout_id, 'entities.components._post')
