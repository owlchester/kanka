<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait MentionTrait
{
    /**
     * Extract the mentions from a text
     */
    public function extract(?string $text = null): array
    {
        $mentions = [];

        preg_match_all('`\[([a-z]+):(.*?)\]`i', $text, $segments);

        foreach ($segments[1] as $id => $type) {
            $options = explode('|', $segments[2][$id]);
            // Force numbers in case someone copy-pasts mentions with <ins> tags
            $id = Str::numbers(Arr::first($options));
            $key = $type . '.' . $id;

            $data = [
                'type' => $type,
                'id' => $id,
            ];

            if (count($options) > 1) {
                // Skip the first segment
                unset($options[0]);
                foreach ($options as $option) {
                    $subSegments = explode(':', $option);
                    if (count($subSegments) === 1) {
                        $data['text'] = Arr::first($subSegments);
                        continue;
                    }

                    $type = Arr::first($subSegments);
                    $value = Arr::last($subSegments);
                    if ($type == 'page') {
                        $data['page'] = $value;
                    }
                }
            }

            $mentions[$key] = $data;
        }

        return $mentions;
    }

    /**
     * Extract the Images from a text
     */
    public function extractImages(?string $text = null): array
    {
        $images = [];

        preg_match_all('/data-gallery-id="[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}"/i', $text, $segments);

        foreach ($segments[0] as $key => $type) {
            $id = mb_substr($type, 17, -1);
            if (!in_array($id, $images)) {
                $images[$key] = $id;
            }
        }
        return $images;
    }

    /**
     * Extract the formatting for a mention
     */
    protected function extractData(array $matches): array
    {
        $segments = explode('|', $matches[2]);

        // The first block should always be type:id
        $id = (int) Arr::first($segments);
        $type = $matches[1];

        $data = [
            'type' => $type,
            'id' => (int) $id,
        ];

        // Nothing else, we can go back
        if (count($segments) < 2) {
            return $data;
        }

        // Skip the first segment
        unset($segments[0]);
        foreach ($segments as $option) {
            $subSegments = explode(':', $option);
            if (count($subSegments) === 1) {
                $data['text'] = Arr::first($subSegments);
                $data['custom'] = true;
                continue;
            }

            $type = Arr::first($subSegments);
            $value = Arr::last($subSegments);
            if (in_array($type, ['page', 'field', 'transclude'])) {
                $data[$type] = mb_strtolower($value);
                $data['custom'] = true;
            } elseif (in_array($type, ['anchor', 'params', 'tooltip'])) {
                $data[$type] = $value;
                $data['custom'] = true;
            } elseif ($type == 'alias') {
                $data['alias'] = (int)$value;
                $data['custom'] = true;
            }
        }

        return $data;
    }
}
