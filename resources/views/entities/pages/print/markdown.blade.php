<?php /**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Entity $entity
 */
use Illuminate\Support\Str;
$converter = new League\HTMLToMarkdown\HtmlConverter();
$converter->getConfig()->setOption('strip_tags', true);
$converter->getEnvironment()->addConverter(new League\HTMLToMarkdown\Converter\TableConverter());
?>
<head>
  <title>{!! Str::slug($entity->name) !!}</title>
</head>

# {!! $entity->name !!}

@if ($model instanceof \App\Models\Character && $model->isDead())
    {{ __('characters.hints.is_dead') }}
@endif
@if ($model instanceof \App\Models\Quest && $model->isCompleted())
    {{ __('quests.fields.is_completed') }}
@endif
@if ($model instanceof \App\Models\Organisation && $model->isDefunct())
    {{ __('organisations.hints.is_defunct') }}
@endif
@if ($model instanceof \App\Models\Creature && $model->isExtinct())
    {{ __('creatures.hints.is_extinct') }}
@endif

@if ($model instanceof \App\Models\Character && !empty($model->title))
    {{ $model->title }}
@endif

@if (!empty($model->type))
    {{ $model->type }}
@endif

{!! $converter->convert($model->entry) !!}            

@foreach ($entity->posts as $post)
   # {!! $post->name !!}
   {!! $converter->convert($post->entry) !!}
@endforeach
