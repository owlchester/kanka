<?php

namespace App\Renderers\CharacterSheets;

use Exception;
use Illuminate\Support\Str;

class Blade extends Renderer
{
    public function render(): string
    {
        $html = $this->campaignPlugin->version->content;
        $html = str_replace(['&lt;', '&gt;', '&amp;&amp;'], ['<', '>', '&&'], $html);

        // Get all the referenced attributes in the character sheet so that they are set to null if an entity
        // doesn't have the attribute
        $html = preg_replace_callback('`\{\{(.*?[^(\!])\}\}`i', function ($matches) {
            $attribute = mb_trim((string) $matches[1]);
            // If it's a comment, we can safely ignore it
            if (Str::startsWith($attribute, '--') && Str::endsWith($attribute, '--')) {
                return '{{' . $attribute . '}}';
            }
            // Flag this as an attribute that is referenced
            $name = Str::after($attribute, '$');
            $this->templateAttributes[$name] = null;

            return '{{ ' . $attribute . ' }}';
        }, $html);

        $html = preg_replace_callback('`\{\!\!(.*?[^(\!])\!\!\}`i', function ($matches) {
            $attribute = mb_trim((string) $matches[1]);
            $name = Str::after($attribute, '$');
            // Flag this as an attribute that is referenced
            $this->templateAttributes[$name] = null;

            return '{!! ' . $attribute . ' !!}';
        }, $html);

        // Blacklisted commands
        $html = str_replace([
            '@php', '@dd', '@inject', '@yield', '@section', '@session', '@env', '@once', '@push', '@csrf',
            '@use',
            '@include', '\Illuminate\\',
        ], [
            '', '', '', '', '', '', '', '', '', '', '', '', '',
        ], $html);

        // Remove more blacklisted stuff than can go unnoticed
        $html = preg_replace('`dd\((.*?)\)`i', '', $html);
        $html = preg_replace('`config\((.*?)\)`i', '', $html);

        // First loop to replace i18n with ()) in the texts
        $regexp = '`\@i18n(\((?:[^)(]++|(?1))*\))`i';
        $html = preg_replace_callback($regexp, function ($matches) {
            return '{{ trans' . $matches[1] . ' }}';
        }, $html);

        // Next loop on the easy non complicated i18n calls without ()
        $regexp = '`\@i18n\((.*?)\)`i';
        $html = preg_replace_callback($regexp, function ($matches) {
            return '{{ trans' . $matches[1] . ' }}';
        }, $html);

        $this->loadTranslations();

        $html = \Illuminate\Support\Facades\Blade::compileString($html);

        [$data, $ids, $checkboxes] = $this->prepareEntityData();

        $html = preg_replace_callback('`\@liveAttribute\(\'(.*?[^)])\'\)`i', function ($matches) use ($data, $ids, $checkboxes) {
            $attr = mb_trim((string) $matches[1]);
            if (! isset($data[$attr])) {
                return $matches[0];
            }
            $value = $data[$attr];
            if (in_array($attr, $checkboxes)) {
                if ($data[$attr] === 'on' || $data[$attr] === '1') {
                    $value = '<i class="fa-solid fa-check" aria-hidden="true" aria-label="checked"></i>';
                } else {
                    $value = '<i class="fa-solid fa-times" aria-hidden="true" aria-label="unchecked"></i>';
                }
            }

            return '<span class="live-edit" data-id="' . $ids[$attr] . '">' . $value . '</span>';
        }, $html);

        $obLevel = ob_get_level();
        ob_start() && extract($data, EXTR_SKIP);

        $errors = null;

        try {
            eval('?' . '>' . $html);
            $blade = ob_get_clean();

            return $blade;
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            $errors = $e->getMessage();
            // throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            $errors = $e->getMessage();

            // throw new FatalThrowableError($e);
        }

        return '<div class="alert alert-danger">
            ' . __('attributes/templates.errors.marketplace.rendering') . (! empty($errors) ?
                '<br /><br />' . __('attributes/templates.errors.marketplace.hint') . ': ' . $errors . ' (line ' . $e->getLine() . ')' : null) . '
        </div>' . $this->debug($data);
    }

    /**
     * Build a html list of all variables
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function debug(mixed $data): string
    {
        $html = '<div class="m-2 p-2 text-xs">
            <h4 class="mb-5">Debug info - the following variables are available</h4>
            ';

        foreach ($data as $key => $val) {
            if (! is_array($val) && ! is_object($val)) {
                $html .= '<dtk>$' . $key . '</dtk> <code>' . (empty($val) ? null : e($val)) . '</code><br />';
            } elseif (is_array($val)) {
                $html .= '<dtk class="">$' . $key . '</dtk>';
                if (empty($val)) {
                    $html .= '<code>NULL</code><br />';
                } else {
                    $html .= '<ul class="m-0">';
                    foreach ($val as $k => $v) {
                        if (is_array($v)) {
                            $html .= '<li><dtk>' . $k . '</dtk></li>';

                            continue;
                        }
                        $html .= '<li><dtk>' . $k . '</dtk> <code>' . $v . '</code></li>';
                    }
                    $html .= '</ul>';
                }
            }
        }

        return $html . '</div>';
    }
}
