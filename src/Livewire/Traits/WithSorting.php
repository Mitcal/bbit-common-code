<?php

namespace BBIT\Livewire\Traits;

trait WithSorting {
    public $sortBy;
    public $sortDirection = 'desc';

    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->updated('sortBy', $this->sortBy);
        $this->updated('sortDirection', $this->sortDirection);
    }
}
