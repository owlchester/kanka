@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->render(
    $filterService,
    // Columns
    [
        // Name
        'name',
       [
            'label' => trans('attribute_templates.fields.attributes'),
            'render' => function($model) {
                return $model->entity->attributes()->count();
            }
        ],
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'attribute_templates.index',
        'baseRoute' => 'attribute_templates',
        'trans' => 'attribute_templates.fields.',
        'campaign' => $campaign
    ]
) !!}