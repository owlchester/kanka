@if ($campaign->image)
![image]({!! $campaign->thumbnail(0) !!})
@endif

# {!! $campaign->name !!}

@if ($campaign->type)
**{!! __('crud.fields.type') !!}:** {{ $campaign->type }}

@endif

**{!! __('crud.fields.visibility') !!}:** {{ $campaign->isUnlisted() ? 'Discreet' : ($campaign->isPublic() ? 'Public' : 'Private') }}

@if ($campaign->is_hidden)
**{!! __('export.hidden_campaign') !!}**
@endif

@if($campaign->hasEntry())
---
## {!! __('fields.description.label') !!}
{!! $converter->convert((string) $campaign->entry) !!}

---

@endif
