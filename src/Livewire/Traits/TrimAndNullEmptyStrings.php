<?php

namespace BBIT\Livewire\Traits;

/**
 * Replace empty strings with nulls.
 * Livewire, unlike Laravel, does not replace empty strings with null values by default.
 */
trait TrimAndNullEmptyStrings
{
    public function updatedTrimAndNullEmptyStrings($name, $value)
    {
        if (is_string($value)) {
            if (empty($this->skipTrim))
                $value = trim($value);
            $value = $value === '' ? null : $value;

            data_set($this, $name, $value);
        }
    }
}
