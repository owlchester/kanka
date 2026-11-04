<?php /** @var \App\Models\Conversation $model */?>
| {{ __('conversations.fields.participants') }} | {{ $model->forEntities() ? __('entities.entries') : __('conversations.targets.members') }} |
@include('entities.pages.print.profile._type')
