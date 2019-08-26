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
        $data = [];
        // Extract links from the entry to foreign
        //preg_match_all('`href="([^"]*)"(.*?)>(.*?)</a>`i', $text, $segments);
        preg_match_all('`\[([a-z]+):(.*?)\]`i' , $text, $segments);

        foreach ($segments[1] as $id => $type) {
            $options = explode('|', $segments[2][$id]);
            $id = Arr::first($options);
            $type = Str::plural($type);

            $key = $type.'.' . $id;

            $data[$key] = [
                'type' => $type,
                'id' => $id,
            ];
        }

        return $data;
    }
}
