<?php

namespace App\Services\Mentions;

use App\Models\EntityType;
use App\Services\Entity\NewService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use DOMDocument;
use DomElement;
use DOMXPath;
use Illuminate\Support\Str;

class SaveService
{
    use CampaignAware;
    use UserAware;

    protected ?string $text;

    protected DOMDocument $document;

    protected DOMXPath $xpath;

    /** @var array Created new mentions to avoid duplicates */
    protected array $newEntityMentions = [];

    /** @var bool New entities have been created from the mention parsing */
    protected bool $createdNewEntities = false;

    protected string $advancedMentionClass = 'advanced-mention';
    protected string $advancedMentionNameClass = 'advanced-mention-name';

    public function __construct(
        protected NewService $newService,
    ) {}

    /**
     * Might be a 600,000 word html document. Might be a <p><br /></p>.
     * Who knows what we'll get, but we'll do our best to be useful.
     */
    public function text(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * If new entities were created from the mentions
     */
    public function hasNewEntities(): bool
    {
        return $this->createdNewEntities;
    }

    /**
     * Transform the html from the text editor with its weird mention syntax into mentions that can be parsed later on
     */
    public function save(): string
    {
        if (empty($this->text)) {
            return '';
        }

        return $this
            ->parseNewEntities()
            ->prepareDocument()
            ->parseMentions()
            ->cleanup()
            ->html();
    }

    /**
     * The user can type @NewEntity and create a bunch of new things on the fly. This function
     * supports that.
     */
    protected function parseNewEntities(): self
    {
        $this->text = preg_replace_callback(
            '`\[new:([a-z_-]+)\|(.*?)\]`i',
            function ($data) {
                if (count($data) !== 3) {
                    return $data[0];
                }

                // check type is valid
                return $this->newEntityMention($data[1], $data[2]);
            },
            $this->text
        );

        return $this;
    }

    /**
     * We have a text of html, transform that into a DomDocument and DomXPath to be able to loop on various html
     * elements easily.
     */
    protected function prepareDocument(): self
    {
        // Parse all links and transform them into advanced mentions [] if needed
        $this->document = new DOMDocument;
        libxml_use_internal_errors(true); // Suppress warnings for malformed HTML
        $this->document->loadHTML(mb_convert_encoding($this->text, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $this->xpath = new DOMXPath($this->document);

        return $this;
    }

    /**
     * Mentions come in different shapes and sizes. Handle them all in a single function call.
     */
    protected function parseMentions(): self
    {
        $nodes = $this->xpath->query('//a[
            contains(concat(" ", normalize-space(@class), " "), " mention ") or
            contains(concat(" ", normalize-space(@class), " "), " post-mention ") or
            contains(concat(" ", normalize-space(@class), " "), " attribute-mention ")
        ]');

        foreach ($nodes as $element) {
            if ($element instanceof DomElement) {
                $this->parseMention($element);
            }
        }

        return $this;
    }

    /**
     * We have a mention link, do some magic
     */
    protected function parseMention(DomElement $mentionLink): void
    {
        $text = $mentionLink->nodeValue;

        $name = html_entity_decode($mentionLink->getAttribute('data-name'));

        // Now you can compare $name with $text to check for edits
        $mentionName = Str::replace(['&amp;'], ['&'], $text);
        $advancedMention = $mentionLink->getAttribute('data-mention');
        $advancedAttribute = $mentionLink->getAttribute('data-attribute');
        // It's not a mention or attribute, keep it as is
        if (empty($advancedMention) && empty($advancedAttribute)) {
            $this->replace($name, $mentionLink);

            return;
        }

        // Advanced attribute [attribute:123], use that
        if (! empty($advancedAttribute)) {
            $this->replace($advancedAttribute, $mentionLink);

            return;
        }

        // If the name isn't the target name, transform it into an advanced mention
        $originalName = $mentionLink->getAttribute('data-name');
        if (! empty($originalName) && $originalName != Str::replace('&quot;', '"', $mentionName)) {
            $mention = Str::replace(']', '|' . $mentionName . ']', $advancedMention);
            $this->replace($mention, $mentionLink);

            return;
        }

        $this->replace($advancedMention, $mentionLink);
    }

    /**
     * Get rid of any fancy <ins> and special <span> elements leftover from mentions with custom names
     */
    protected function cleanup(): self
    {
        // Remove legacy <ins> and <span> advanced-mention elements
        $advancedNodes = $this->xpath->query('//ins[@class="' . $this->advancedMentionNameClass . '" and @data-name] | //span[@class="' . $this->advancedMentionNameClass . '" and @data-name]');
        foreach ($advancedNodes as $node) {
            $node->parentNode->removeChild($node);
        }

        return $this;
    }

    protected function replace(string $text, DomElement $node): void
    {
        $textNode = $this->document->createTextNode($text);
        $node->parentNode->replaceChild($textNode, $node);
    }

    /**
     * Create a new entity based on a mention
     */
    protected function newEntityMention(string $type, string $name): string
    {
        if (empty($type) || empty($name)) {
            return $name;
        }

        $types = $this->newService->campaign($this->campaign)->user($this->user)->available();

        /** @var ?EntityType $entityType */
        $entityType = $types->where('code', $type)->first();
        if (! $entityType) {
            return $name;
        }

        // Do we already have it cached?
        $key = $type . ':' . mb_strtolower($name);
        if (isset($this->newEntityMentions[$key])) {
            return "[{$type}:" . $this->newEntityMentions[$key] . ']';
        }

        // Create the new model
        $newEntity = $this->newService
            ->user($this->user)
            ->entityType($entityType)
            ->create($name);
        $this->newEntityMentions[$key] = $newEntity->id;
        $this->createdNewEntities = true;

        return '[' . $type . ':' . $newEntity->id . ']';
    }

    /**
     * When all is said and done, get the body content of DomDocument and save that to the db
     */
    protected function html(): string
    {
        $body = $this->document->getElementsByTagName('body')->item(0);
        if (empty($body)) {
            return '';
        }
        $newHtml = '';
        foreach ($body->childNodes as $child) {
            $newHtml .= $this->document->saveHTML($child);
        }

        return $newHtml;
    }
}
