<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class PluginVersion
 * @package App\Models
 *
 * @property int $plugin_id
 * @property string $version
 * @property string $entry
 * @property string $content
 * @property int $approved_by
 * @property Plugin $plugin
 */
class PluginVersion extends Model
{

}
