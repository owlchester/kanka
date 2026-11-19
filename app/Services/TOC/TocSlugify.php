<?php

namespace App\Services\TOC;

use TOC\UniqueSlugger;

/**
 * Keeps heading slugs unique across multiple MarkupFixer::fix() calls on the
 * same page (entity entry, posts, quest elements, etc.).
 *
 * MarkupFixer::fix() calls $slugger->reset() on every invocation, so this
 * subclass intentionally leaves reset() as a no-op for the request lifecycle.
 */
class TocSlugify extends UniqueSlugger
{
    public function reset(): void
    {
        // Intentionally preserve used slugs across fix() calls within the same request.
    }
}
