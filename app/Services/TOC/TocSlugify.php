<?php

namespace App\Services\TOC;

use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface as SymfonyStringSluggerInterface;
use TOC\SluggerInterface;

/**
 * This is a direct copy-paste of TOC\UniqueSlugify, because the MarkupFixer doesn't want to re-use the same slugifier
 * twice, while this is exactly what we want to not repeat heading ids between entities, posts, quest elements, etc.
 */
class TocSlugify implements SluggerInterface
{
    private SymfonyStringSluggerInterface $slugger;

    /**
     * @var array
     */
    private $used;

    /**
     * Constructor
     *
     */
    public function __construct(?SymfonyStringSluggerInterface $slugger = null)
    {
        $this->used = [];
        $this->slugger = $slugger ?: new AsciiSlugger();
    }

    /**
     * Slugify
     *
     */
    public function makeSlug(string $string): string
    {
        $slugged = $this->slugger->slug($string)->lower()->toString();

        $count = 1;
        $orig = $slugged;
        while (in_array($slugged, $this->used)) {
            $slugged = $orig . '-' . $count;
            $count++;
        }

        $this->used[] = $slugged;
        return $slugged;
    }

    public function reset(): void
    {
        $this->used = [];
    }
}
