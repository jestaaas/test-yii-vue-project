<?php

namespace app\repositories;
use app\models\Filling;

class FillingRepository {
    public function findAll(): array {
        return Filling::find()->all();
    }
    public function save(Filling $filling): bool {
        return $filling->save();
    }
}