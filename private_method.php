<?php
declare(strict_types=1);

class PrivateParent {
    private function secret(): string {
        return 'Parent private';
    }

    public function callParentSecret(): string {
        return $this->secret();
    }
}

class PrivateChild extends PrivateParent {
    public function secret(): string {
        return 'Child public';
    }
}

$obj = new PrivateChild();
echo $obj->callParentSecret() . ' ' . $obj->secret();