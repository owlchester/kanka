<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityMention;
use App\Models\EntityNote;
use App\Models\MiscModel;

use Exception;

class EntityMappingService
{

    /**
     * Map of urls to actual entity
     * Todo: move this out of a static array
     * @var array
     */
    protected $typeMapping = [
        'characters' => 'character',
        'calendars' => 'calendar',
        'conversations' => 'conversation',
        'events' => 'event',
        'families' => 'family',
        'items' => 'item',
        'journals' => 'journal',
        'locations' => 'location',
        'notes' => 'note',
        'organisations' => 'organisation',
        'quests' => 'quest',
        'tags' => 'tag',
        'sections' => 'tag',
        'attribute_templates' => 'attribute_template',
        'dice_rolls' => 'dice_roll',
        'menu_links' => 'menu_link',
        'races' => 'race',
    ];

    public $verbose = false;

    /**
     * @param MiscModel $model
     * @return int
     * @throws Exception
     */
    public function mapModel(MiscModel $model)
    {
        $mentions = $this->extract($model->entry);

        $createdMappings = 0;
        foreach ($mentions as $data) {
            $type = $data['type'];
            $id = $data['id'];

            $singularType = array_get($this->typeMapping, $type, false);
            if ($singularType === false) {
                throw new Exception("Unknown type $type");
            }

            /** @var Entity $entity */
            $entity = Entity::where(['type' => $singularType, 'entity_id' => $id])->first();
            if ($entity) {
                $this->log("- Mentions " . $entity->id);

                $mention = new EntityMention();
                $mention->entity_id = $model->entity->id;
                $mention->target_id = $entity->id;
                $mention->save();

                $createdMappings++;
            } else {
                $this->log("- Unknown entity of type $singularType and id $id");
            }
        }

        return $createdMappings;
    }


    /**
     *
     * @param Entity $entity
     * @return $this
     */
    public function mapEntity(Entity $entity)
    {
        return $this->map($entity);
    }

    /**
     * @param EntityNote $entityNote
     * @return $this
     * @throws Exception
     */
    public function mapEntityNote(EntityNote $entityNote)
    {
        return $this->map($entityNote);
    }

    public function mapCampaign(Campaign $campaign)
    {
        return $this->map($campaign);
    }

    /**
     * @param $model
     * @return int
     * @throws Exception
     */
    protected function map($model)
    {
        $existingTargets = [];
        foreach ($model->mentions as $map) {
            $existingTargets[$map->target_id] = $map;
        }
        $createdMappings = 0;
        $existingMappings = 0;

        if ($model instanceof Entity) {
            $mentions = $this->extract($model->child->entry);
        } else {
            $mentions = $this->extract($model->entry);
        }
        foreach ($mentions as $data) {
            $type = $data['type'];
            $id = $data['id'];

            $singularType = array_get($this->typeMapping, $type, false);
            if ($singularType === false) {
                throw new Exception("Unknown type $type");
            }

            /** @var Entity $entity */
            $target = Entity::where(['type' => $singularType, 'entity_id' => $id])->first();
            if ($target) {
                $this->log("- Mentions " . $model->id);

                // Do we already have this mention mapped?
                if (!empty($existingTargets[$target->id])) {
                    $this->log("- already have mapping");
                    unset($existingTargets[$target->id]);
                    $existingMappings++;
                } else {
                    $mention = new EntityMention();
                    if ($model instanceof Campaign) {
                        $mention->campaign_id = $model->id;
                    } elseif ($model instanceof EntityNote) {
                        $mention->entity_note_id = $model->id;
                    } else {
                        $mention->entity_id = $model->id;
                    }
                    $mention->target_id = $target->id;
                    $mention->save();

                    $createdMappings++;
                }
            } else {
                $this->log("- Unknown entity of type $singularType and id $id");
            }
        }

        // Existing mappings that are no longer needed
        $deletedMappings = 0;
        foreach ($existingTargets as $targetId => $map) {
            $map->delete();
            $deletedMappings++;
        }

        return $createdMappings;
    }

    /**
     * Update mentions where the target
     * @param Entity $entity
     * @param null $url
     */
    public function updateMentions(Entity $entity, $url = null)
    {
        // Let's figure out the new text we're going to inject
        $tooltip = $entity->tooltipWithName();
        $name = $entity->name;

        $entityLink = !empty($url) ? $url : $entity->url();
        // Replace the link's locale to avoid issues when people use several languages
        $entityLinkSegments = explode('/', $entityLink);
        $entityLinkSegments[3] = '(.){2,5}';
        $entityLinkSearch = implode('/', $entityLinkSegments);
        //$entityLink = str_replace('.', '\.', $entityLink);

        // Just text, no tooltip
        $patternNoTooltip = '<a href=\"' . $entityLinkSearch . '\">(.*?)</a>';
        // We need to go 0.300 as the text is encoded, so some html entities will make it longer. It's not great
        $patternTooltip = '<a title="([^"]*)" href="' . $entityLinkSearch . '" data-toggle="tooltip" data-html="true">(.*?)</a>';

        $replace = '<a href=\"' . $entityLink . '\">' . $name . '</a>';
        if (!empty($tooltip)) {
            $replace = '<a title="' . $tooltip . '" href="' . $entityLink . '" data-toggle="tooltip" data-html="true">' . $name . '</a>';
        }

//        dump($patternNoTooltip);
//        dump($patternTooltip);
//        dump($replace);

        /** @var EntityMention $target */
        foreach ($entity->targetMentions()->with(['entity', 'campaign', 'entityNote'])->get() as $target) {
            // We've got a target, we need to update its entry field
            $realTarget = $target->isEntityNote() ? $target->entityNote : ($target->isCampaign() ? $target->campaign : $target->entity->child);
            $text = $realTarget->entry;
//            dump($text);
            $text = preg_replace("`$patternNoTooltip`i", $replace, $text);
            $text = preg_replace("`$patternTooltip`i", $replace, $text);
//            dump($text);

            $realTarget->entry = $text;
            $realTarget->timestamps = false; // We don't want to trigger the updated_at to change.
            $realTarget->save();
        }
    }

    /**
     * Extract the mentions from a text
     * @param String $entry
     * @return mixed
     */
    protected function extract($text)
    {
        $data = [];
        // Extract links from the entry to foreign
        preg_match_all('`href="([^"]*)"(.*?)>(.*?)</a>`i', $text, $segments);

        foreach ($segments[1] as $key => $url) {

            // If it's an internal link, we want to "map" id
            $domain = parse_url($url, PHP_URL_HOST);
            if (!in_array($domain, ['kanka.io', 'kanka.loc', 'dev.kanka.io'])) {
                continue;
            }

            $url = parse_url($url, PHP_URL_PATH);
            $urlSegments = explode('/', $url);
            $urlCount = count($urlSegments);
            $type = $urlSegments[$urlCount - 2];
            $id = $urlSegments[$urlCount - 1];
            $name = $segments[2][$key];

            $key = $type.'.' . $id;

            $data[$key] = [
                'type' => $type,
                'id' => $id,
                'name' => $name
            ];
        }

        return $data;
    }

    /**
     * @param string $message
     */
    protected function log($message = '')
    {
        if ($this->verbose === true) {
            echo $message;
            if (app()->runningInConsole()) {
                echo "\n";
            } else {
                echo "<br />";
            }
        }
    }
}