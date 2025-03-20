<?php

namespace App\Traits;

use Exception;

trait ExportableTrait
{
    protected array $exportData;

    /**
     * Prepares the data of an entity to json.
     *
     * @throws Exception
     */
    public function export(): string
    {
        $this
            ->baseExportData()
            ->entityExportData()
            ->foreignExportData();

        return json_encode($this->exportData);
    }

    protected function baseExportData(): self
    {
        if (! isset($this->exportFields)) {
            $this->exportData = $this->toArray();

            return $this;
        }
        $this->exportData = [];
        $baseFields = [
            'id',
            'name',
            'created_at',
            'updated_at',
            'is_private',
        ];
        foreach ($this->exportFields as $field) {
            if ($field !== 'base') {
                $this->exportData[$field] = $this->$field;

                continue;
            }
            foreach ($baseFields as $baseField) {
                // @phpstan-ignore-next-line
                $this->exportData[$baseField] = $this->$baseField;
            }
        }
        // @phpstan-ignore-next-line
        if (method_exists($this, 'getParentKeyName')) {
            $this->exportData[$this->getParentKeyName()] = $this->getAttribute($this->getParentKeyName());
        }

        return $this;
    }

    protected function entityExportData(): self
    {
        if (isset($this->entity) && $this->entity) {
            $this->exportData['entity'] = $this->entity->export();
        }

        return $this;
    }

    public function exportRelations(): array
    {
        if (! property_exists($this, 'foreignExport')) {
            return [];
        }

        return $this->foreignExport;
    }

    protected function foreignExportData(): self
    {
        foreach ($this->exportRelations() as $foreign) {
            $this->exportData[$foreign] = [];
            foreach ($this->$foreign as $model) {
                try {
                    if (method_exists($model, 'exportFields')) {
                        $foreignData = [];
                        foreach ($model->exportFields() as $field) {
                            $foreignData[$field] = $model->$field;
                        }
                        $this->exportData[$foreign][] = $foreignData;
                    } else {
                        $this->exportData[$foreign][] = $model->toArray();
                    }
                } catch (Exception $e) {
                    throw new Exception("Unknown relation '{$foreign}' on model " . get_class($this) . '(' . $e->getMessage() . ')');
                }
            }
        }

        return $this;
    }
}
