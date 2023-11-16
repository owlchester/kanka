<?php

namespace App\Traits;

use App\Models\CreatureLocation;
use Exception;

trait ExportableTrait
{
    protected array $exportData;
    /**
     * Prepares the data of an entity to json.
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
        if (!isset($this->exportFields)) {
            $this->exportData = $this->toArray();
            return $this;
        }
        $this->exportData = [];
        $baseFields = [
            'id',
            'name',
            'type',
            'entry',
            'created_at',
            'updated_at',
            'is_private',
        ];
        foreach ($this->exportFields as $field) {
            if (!$field === 'base') {
                $this->exportData[$field] = $field;
                continue;
            }
            foreach ($baseFields as $baseField) {
                $this->exportData[$baseField] = $this->$baseField;
            }
        }
        if (method_exists($this, 'getParentIdName')) {
            $this->exportData[$this->getParentIdName()] = $this->getAttribute($this->getParentIdName());
        }

        return $this;
    }

    protected function entityExportData(): self
    {
        if ($this->entity) {
            $this->exportData['entity'] = $this->entity->export();
        }
        return $this;
    }

    protected function foreignExportData(): self
    {
        if (!property_exists($this, 'foreignExport')) {
            return $this;
        }
        foreach ($this->foreignExport as $foreign) {
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
                    dd('e');
                    throw new Exception("Unknown relation '{$foreign}' on model " . get_class($this));
                }
            }
        }
        return $this;
    }
}
