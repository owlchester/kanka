<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Illuminate\View\View;

/**
 * Class PluginVersion
 * @package App\Models
 *
 * @property int $plugin_id
 * @property string $uuid
 * @property string $version
 * @property string $entry
 * @property string $content
 * @property int $approved_by
 * @property Plugin $plugin
 */
class PluginVersion extends Model
{
    /** @var Entity */
    protected $entity;

    /** @var Attribute[] */
    protected $entityAttributes;

    protected $templateAttributes = [];

    /**
     * @var string[]
     */
    protected $casts = [
        'json' => 'Array'
    ];

    /**
     * Get the attributes (stored in the json)
     * @return array
     */
    public function getAttributesAttribute(): array
    {
        return Arr::get($this->json, 'attributes', []);
    }

    /**
     * Get the css (stored in the json)
     * @return string
     */
    public function getCssAttribute(): string
    {
        return Arr::get($this->json, 'css', '');
    }

    /**
     * @param Entity $entity
     * @return string|string[]|null
     */
    public function content(Entity $entity)
    {
        // Let people update their plugins before using the new syntax
        if ($this->updated_at->gt('2021-03-30 17:00:00')) {
            return $this->renderBlade($entity);
        }

        $this->entityAttributes = $entity->allAttributes;
        $html = preg_replace_callback('`\{(.*?)\}`i', function ($matches) {
            $name = (string) $matches[1];
            return $this->attribute($name);
        }, $this->content);


        // Replace < and > in logical blocks
        //$html = str_replace(['&lt;', '&gt;'], ['<', '>'], $html);

        //dump($html);
        //return $html;

        // If-Else condition

        $html = preg_replace_callback('`@if\((.*?)\)(.*?)@endif`si', function ($matches) {
            return $this->ifBlock($matches);
        }, $html);

        $html = preg_replace_callback('`@if\((.*?)\)(.*?)@else(.*?)@endif`si', function ($matches) {
            return $this->ifElseBlock($matches);
        }, $html);

        $html = preg_replace_callback('`@empty\((.*?)\)(.*?)@endempty`si', function ($matches) {
            return $this->emptyBlock($matches);
        }, $html);
        $html = preg_replace_callback('`@notempty\((.*?)\)(.*?)@endnotempty`si', function ($matches) {
            return !$this->emptyBlock($matches);
        }, $html);

        return $html;
    }

    public function css(): string
    {
        $css = (string) $this->css;



        return $css;
    }

    /**
     * @param Entity $entity
     * @return false|string
     */
    protected function renderBlade(Entity $entity)
    {
        $html = $this->content;
        $html = str_replace(['&lt;', '&gt;', '&amp;&amp;'], ['<', '>', '&&'], $html);


        $html = preg_replace_callback('`\{(.*?[^\!])\}`i', function ($matches) {
            $name = trim((string) $matches[1]);
            if(Str::startsWith($name, '{')) {
                return '{' . $name . ' }';
            }

            $this->templateAttributes[$name] = null;
            return '{{ $' . $name . ' }}';
        }, $html);

        $html = str_replace([
            '@php', '@dd', '@inject', '@yield', '@section', '@auth', '@guest', '@env', '@once', '@push', '@csrf',
            '@include', '\Illuminate\\',
        ], [
            '', '', '', '', '', '', '', '', '', '', ''
        ], $html);
        $html = preg_replace('`dd\((.*?)\)`i', '', $html);
        $html = preg_replace('`config\((.*?)\)`i', '', $html);


        //$html = preg_replace('`\\\\`i', '', $html);

        /*$html = preg_replace_callback('`$(\w+)`i', function ($matches) {
            $name = trim((string) $matches[1]);
            $this->templateAttributes[] = $name;
            return '{{ $' . $name . ' }}';
        }, $html);*/
        //dump($html);

        $html = Blade::compileString($html);

        // Prepare attributes
        $data = [];
        $ids = [];
        $this->entityAttributes = $entity->allAttributes;
        $allAttributes = [];
        foreach ($this->entityAttributes as $attr) {
            $name = str_replace(' ', null, $attr->name);
            $data[$name] = $attr->mappedValue();
            $ids[$name] = $attr->id;
            if ($attr->isText()) {
                $data[$name] = nl2br($data[$name]);
            }
            //dump('mapping ' . $name . ' to ' . $attr->mappedValue());

            $allAttributes[$name] = $data[$name];
            unset($this->templateAttributes[$name]);
        }

        // We need this for some blade directives like foreach
        $data['__env'] = app(\Illuminate\View\Factory::class);
        $data['attributes'] = $allAttributes;

        //dump($data);
        ///dump($this->templateAttributes);

        // Add any variables missing
        //dd($this->templateAttributes);
        foreach ($this->templateAttributes as $name) {
            $data[$name] = null;
        }


        $html = preg_replace_callback('`\@liveAttribute\(\'(.*?[^)])\'\)`i', function ($matches) use ($data, $ids) {
            $attr = trim((string) $matches[1]);
            if (!isset($data[$attr])) {
                return $matches[0];
            }
            return '<span class="live-edit" data-id="' . $ids[$attr] . '">' . $data[$attr] . '</span>';
        }, $html);
        //dd($html);

        $obLevel = ob_get_level();
        ob_start() and extract($data, EXTR_SKIP);

        $errors = null;

        try {

            eval('?' . '>' . $html);
            $blade = ob_get_clean();
            return $blade;
        } catch (\Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            $errors = $e->getMessage();
            //throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            $errors = $e->getMessage();

            //throw new FatalThrowableError($e);
        }

        return '<div class="alert alert-danger">
            ' . __('attributes/templates.errors.marketplace.rendering') . (!empty($errors) ?
                '<br /><br />' . __('attributes/templates.errors.marketplace.hint') . ': ' . $errors : null) . '
        </div>';
    }

    /**
     * @param string $name
     * @return string
     */
    protected function attribute(string $name): string
    {
        /** @var Attribute $attr */
        $attr = $this->entityAttributes->where('name', $name)->first();
        if (!empty($attr)) {
            if ($attr->isText()) {
                return nl2br($attr->mappedValue());
            }
            return $attr->mappedValue();
        }

        return '<i class="missing-attribute">' . $name . '</i>';
    }

    /**
     * If Else block
     * @param $matches
     * @return mixed
     */
    protected function ifElseBlock(array $matches)
    {
        // Test on a missing attribute always returns false
        $trimmed = trim($matches[1]);
        if (Str::contains($trimmed, '<i class="missing-attribute">')) {
            return $matches[3];
        }

        // Strip tags to remove html brs on multilines
        $condition = strip_tags(trim($matches[1]));
        if (Str::contains($condition, ['=', '>', '<'])) {
            if ($this->evaluateCondition($condition)) {
                return $matches[2];
            }
            return null;
        }
        if (!empty($condition)) {
            return $matches[2];
        } else {
            return $matches[3];
        }
    }

    /**
     * If block
     * @param $matches
     * @return mixed|null
     */
    protected function ifBlock(array $matches)
    {
        // If there is an else in the block, let the if-else block handle it later
        if (Str::contains($matches[2], '@else')) {
            return $matches[0];
        }
        // Test on a missing attribute always returns false
        $trimmed = trim($matches[1]);
        if (Str::contains($trimmed, '<i class="missing-attribute">')) {
            return null;
        }

        // Strip tags to remove html brs on multilines
        $condition = strip_tags(trim($matches[1]));
        if (Str::contains($condition, ['=', '>', '<', '&lt;', '&gt;'])) {
            if ($this->evaluateCondition($condition)) {
                return $matches[2];
            }
            return null;
        }
        if (!empty($condition)) {
            return $matches[2];
        }
        return null;
    }

    /**
     * Evaluate a condition
     * @param string $condition
     * @return bool
     */
    protected function evaluateCondition(string $condition): bool
    {
        // >=
        if (Str::contains($condition, '&gt;=')) {
            $segments = explode('&gt;=', $condition);
            return (int) trim($segments[0]) >= (int) trim($segments[1]);
        }
        elseif (Str::contains($condition, '&lt;=')) {
            $segments = explode('&lt;=', $condition);
            return (int) trim($segments[0]) <= (int) trim($segments[1]);
        }
        elseif (Str::contains($condition, '&gt;')) {
            $segments = explode('&gt;', $condition);
            return (int) trim($segments[0]) > (int) trim($segments[1]);
        }
        elseif (Str::contains($condition, '&lt;')) {
            $segments = explode('&lt;', $condition);
            return (int) trim($segments[0]) < (int) trim($segments[1]);
        }
        elseif (Str::contains($condition, '=')) {
            $segments = explode('=', $condition);
            return trim($segments[0]) == trim($segments[1]);
        }
        return false;
    }

    protected function emptyBlock(array $matches)
    {
        $condition = trim($matches[1]);
        if (Str::contains($condition, '<i class="missing">')) {
            return false;
        }
        elseif (empty($condition)) {
            return false;
        }
        return true;
    }

    /**
     * @param Builder $query
     * @param int $pluginCreator
     * @return Builder
     */
    public function scopePublishedVersions(Builder $query, int $pluginCreator)
    {
        if ($pluginCreator == auth()->user()->id) {
            return $query->whereIn('status_id', [1, 3]);
        } else {
            return $query->where('status_id', 3);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entities()
    {
        return $this->hasMany(PluginVersionEntity::class);
    }
}
