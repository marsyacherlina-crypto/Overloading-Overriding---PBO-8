<?php
declare(strict_types=1);
require __DIR__ . '/src/Student.php';

// EKSPERIMEN 1 (Skenario T10 & Latihan 4): Mencoba override method final getId()
// Jika dijalankan, PHP akan menghasilkan:
// Fatal error: Cannot override final method Student::getId()
class BrokenFinalStudent extends Student {
    public function getId(): string {
        return 'OVERRIDE-' . $this->id;
    }

    public function getType(): string {
        return 'broken';
    }

    public function calculateFee(): float {
        return $this->baseFee;
    }
}

/*
// EKSPERIMEN 2 (Latihan 3): Mengubah signature calculateFee() menjadi tidak kompatibel
// Cara uji: beri komentar (/* ... *\/) pada class BrokenFinalStudent di atas, lalu buka komentar blok ini.
// Jika dijalankan, PHP akan menghasilkan:
// Fatal error: Declaration of BrokenSignatureStudent::calculateFee(float $tax): float must be compatible with Student::calculateFee(): float
class BrokenSignatureStudent extends Student {
    public function getType(): string {
        return 'broken';
    }

    public function calculateFee(float $tax): float {
        return $this->baseFee + $tax;
    }
}
*/

