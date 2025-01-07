@includeWhen($post->layout_id && $campaign->superboosted(), 'entities.components.posts.custom')
@includeWhen(!$post->layout_id, 'entities.components.posts.standard')
