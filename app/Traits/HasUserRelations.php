<?php
namespace App\Traits;

trait HasUserRelations {

    public function loadRelations() : void
    {
        $this->with[] = 'created_by';
        $this->with[] = 'updated_by';
    }
}
