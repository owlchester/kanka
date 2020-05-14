<?php /**
 * @var \App\Models\MenuLink $model
 * @var \App\Services\EntityService $entityService
 * @var \App\Services\CampaignService $campaign
 */

$tab = empty($model) || old('entity_id') || $model->entity_id ? 'entity' : 'type';
?>

@include('cruds.fields.name', ['trans' => 'menu_links'])
@include('cruds.fields.position', ['trans' => 'menu_links'])

@include('cruds.fields.private')
