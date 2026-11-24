<?php
declare(strict_types=1);

/** PHP overloading: __call() menangani method yang TIDAK dideklarasikan. */
final class StudentPresenter {
    public function __call(string $method, array $args): string {
        if ($method !== 'showData') {
            throw new BadMethodCallException("Method tidak dikenal: $method");
        }

        $count = count($args);
        if ($count < 1 || $count > 4) {
            throw new InvalidArgumentException('showData menerima 1 sampai 4 argumen string.');
        }

        foreach ($args as $arg) {
            if (!is_string($arg) || trim($arg) === '') {
                throw new InvalidArgumentException('Semua argumen showData harus berupa string tidak kosong.');
            }
        }

        return match ($count) {
            1 => "Nama: {$args[0]}",
            2 => "NIM: {$args[0]}, Nama: {$args[1]}",
            3 => "NIM: {$args[0]}, Nama: {$args[1]}, Prodi: {$args[2]}",
            4 => "NIM: {$args[0]}, Nama: {$args[1]}, Prodi: {$args[2]}, Semester: {$args[3]}",
        };
    }
}