@if ($campaign->image)
![image]({!! $campaign->thumbnail(0) !!})
@endif

# {!! $campaign->name !!}

@if ($campaign->type)
**Type:** {{ $campaign->type }}

@endif

**Visibility:** {{ $campaign->isUnlisted() ? 'Discreet' : ($campaign->isPublic() ? 'Public' : 'Private') }}

@if ($campaign->is_hidden)
**Hidden Campaign**
@endif

@if($campaign->hasEntry())
---
## Entry
{!! $converter->convert((string) $campaign->entry) !!}
---

@endif