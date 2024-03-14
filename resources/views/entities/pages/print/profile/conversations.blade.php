<?php /** @var \App\Models\Conversation $model */?>
| {{ __('conversations.fields.participants') }} | {{ __('conversations.targets.' . ($model->forCharacters() ? 'characters' : 'members')) }} |
@include('entities.pages.print.profile._type')
