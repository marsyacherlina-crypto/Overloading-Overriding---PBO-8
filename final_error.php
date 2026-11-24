<?php
declare(strict_types=1);

class FinalParent {
    final public function getId(): string {
        return 'M001';
    }
}

class FinalChild extends FinalParent {
    public function getId(): string {
        return 'OVERRIDE';
    }
}