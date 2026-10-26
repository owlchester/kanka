<?php /** @var \App\Models\Conversation $model */?>
| {{ __('conversations.fields.participants') }} | {{ __('conversations.targets.' . ($model->forEntities() ? 'entities' : 'members')) }} |
@include('entities.pages.print.profile._type')
