<?php

namespace App\Services\Campaign\Import;

class ImportIdMapper
{
    protected array $misc = [];

    protected array $customEntityTypes = [];

    protected array $customEntityTypeNames = [];

    protected array $entities = [];

    protected array $gallery = [];

    protected array $posts = [];

    protected array $timelineElements = [];

    protected array $questElements = [];

    public function put(string $type, int $old, int $new): self
    {
        $this->misc[$type][$old] = $new;

        return $this;
    }

    public function putEntity(int $old, int $new): self
    {
        $this->entities[$old] = $new;

        return $this;
    }

    public function putCustomEntityType(int $old, int $new): self
    {
        $this->customEntityTypes[$old] = $new;

        return $this;
    }

    public function putCustomEntityTypeName(string $old, int $new): self
    {
        $this->customEntityTypeNames[$old] = $new;

        return $this;
    }

    public function putGallery(string $old, string $new): self
    {
        $this->gallery[$old] = $new;

        return $this;
    }

    public function putPost(int $old, int $new): self
    {
        $this->posts[$old] = $new;

        return $this;
    }

    public function putQuestElement(int $old, int $new): self
    {
        $this->questElements[$old] = $new;

        return $this;
    }

    public function putTimelineElement(int $old, int $new): self
    {
        $this->timelineElements[$old] = $new;

        return $this;
    }

    public function get(string $type, int $old): int
    {
        return $this->misc[$type][$old];
    }

    public function has(string $type, int $old): bool
    {
        return ! empty($this->misc[$type][$old]);
    }

    public function getEntity(int $old): int
    {
        return $this->entities[$old];
    }

    public function hasEntity(int $old): bool
    {
        return ! empty($this->entities[$old]);
    }

    public function getCustomEntityType(int $old): int
    {
        return $this->customEntityTypes[$old];
    }

    public function getCustomEntityTypes(): array
    {
        return $this->customEntityTypeNames;
    }

    public function hasOldEntityType(int $old): bool
    {
        return ! empty($this->customEntityTypes[$old]);
    }

    public function getGallery(string $old): string
    {
        return $this->gallery[$old];
    }

    public function hasGallery(string $old): bool
    {
        return ! empty($this->gallery[$old]);
    }

    public function getPost(int $old): int
    {
        return $this->posts[$old];
    }

    public function getTimelineElement(int $old): int
    {
        return $this->timelineElements[$old];
    }

    public function getQuestElement(int $old): int
    {
        return $this->questElements[$old];
    }
}
