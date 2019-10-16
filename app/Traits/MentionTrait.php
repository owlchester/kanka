<?php


namespace App\Traits;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait MentionTrait
{

    /**
     * Extract the mentions from a text
     * @param String $entry
     * @return mixed
     */
    public function extract($text)
    {
        $mentions = [];

        preg_match_all('`\[([a-z]+):(.*?)\]`i' , $text, $segments);

        foreach ($segments[1] as $id => $type) {
            $options = explode('|', $segments[2][$id]);
            $id = Arr::first($options);
            $key = $type.'.' . $id;

            $data = [
                'type' => $type,
                'id' => $id,
            ];

            if (count($options) > 1) {
                // Skip the first segment
                Arr::forget($options, 0);
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
                    } elseif ($type == 'tab') {
                        $data['tab'] = $value;
                    }
                }
            }

            $mentions[$key] = $data;
        }

        return $mentions;
    }

    /**
     * Extract the formatting for a mention
     * @param array $matches
     * @return array
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

        if (count($segments) > 1) {
            // Skip the first segment
            Arr::forget($segments, 0);
            foreach ($segments as $option) {
                $subSegments = explode(':', $option);
                if (count($subSegments) === 1) {
                    $data['text'] = Arr::first($subSegments);
                    $data['custom'] = true;
                    continue;
                }

                $type = Arr::first($subSegments);
                $value = Arr::last($subSegments);
                if ($type == 'page') {
                    $data['page'] = strtolower($value);
                    $data['custom'] = true;
                } elseif ($type == 'tab') {
                    $data['tab'] = strtolower($value);
                    $data['custom'] = true;
                }
            }
        }

        return $data;
    }
}
