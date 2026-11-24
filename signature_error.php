<?php
declare(strict_types=1);

class FeeParent {
    public function calculateFee(): float {
        return 5000000.0;
    }
}

class FeeChild extends FeeParent {
    public function calculateFee(float $tax): float {
        return 5000000.0 + $tax;
    }
}