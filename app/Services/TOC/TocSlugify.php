<?php

namespace App\Services\TOC;

use Cocur\Slugify\Slugify;
use Cocur\Slugify\SlugifyInterface;

/**
 * This is a direct copy-paste of TOC\UniqueSlugify, because the MarkupFixer doesn't want to re-use the same slugifier
 * twice, while this is exactly what we want to not repeat heading ids between entities, posts, quest elements, etc.
 */
class TocSlugify implements SlugifyInterface
{
    /**
     * @var SlugifyInterface
     */
    private $slugify;

    /**
     * @var array
     */
    private $used;

    /**
     * Constructor
     *
     */
    public function __construct(?SlugifyInterface $slugify = null)
    {
        $this->used = [];
        $this->slugify = $slugify ?: new Slugify();
    }

    /**
     * Slugify
     *
     * @param string $string
     */
    public function slugify(string $string, array|string|null $options = null): string
    {
        $slugged = $this->slugify->slugify($string, $options);

        $count = 1;
        $orig = $slugged;
        while (in_array($slugged, $this->used)) {
            $slugged = $orig . '-' . $count;
            $count++;
        }

        $this->used[] = $slugged;
        return $slugged;
    }
}
