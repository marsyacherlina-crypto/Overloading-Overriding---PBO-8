<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';

$pass = 0;
function check(bool $ok, string $label): void {
    global $pass;
    if (!$ok) throw new RuntimeException('FAIL: ' . $label);
    $pass++;
    echo "PASS: $label\n";
}

function fails(callable $fn, string $exception, string $label): void {
    try {
        $fn();
    } catch (Throwable $e) {
        check($e instanceof $exception, $label);
        return;
    }
    throw new RuntimeException('FAIL: ' . $label);
}

// T01: Variadic pada Calculator
$calc = new Calculator();
check($calc->add(10, 20) === 30, 'T01a: Variadic add(10, 20) === 30');
check($calc->add(10, 20, 30) === 60, 'T01b: Variadic add(10, 20, 30) === 60');

// T06, T07, T09 & Tugas 3: Inheritance & Overriding
$r = new StudentRepository();
$a = new RegularStudent('M01', 'Alya', 'Informatika', 5000000);
$b = new ScholarshipStudent('M02', 'Bima', 'SI', 5000000, 40);
$c = new InternationalStudent('M03', 'Kenji', 'Informatika', 5000000, 2500000);

check($a instanceof Student, 'Inheritance RegularStudent');
check($b instanceof Student, 'Inheritance ScholarshipStudent');
check($c instanceof Student, 'Inheritance InternationalStudent');

check($a->calculateFee() === 5000000.0, 'T06: Overriding biaya reguler (5 juta)');
check($b->calculateFee() === 3000000.0, 'T07: Overriding biaya beasiswa diskon 40% (3 juta)');
check($c->calculateFee() === 7500000.0, 'Tugas 3: Overriding biaya internasional (7.5 juta)');

check($a->summary() === 'M01 - Alya', 'T09a: summary() reguler');
check(str_contains($b->summary(), '[Beasiswa]'), 'T09b: summary() beasiswa + parent::');
check(str_contains($c->summary(), '[Internasional]'), 'T09c: summary() internasional + parent::');

// CRUD Polymorphic tanpa mengubah StudentRepository
$r->create($a);
$r->create($b);
$r->create($c);
check(count($r->all()) === 3, 'CRUD Create 3 tipe student berbeda');
check($r->find('M02') === $b, 'CRUD Read');
fails(fn() => $r->create($a), InvalidArgumentException::class, 'NIM duplikat ditolak');

$r->update('M01', new RegularStudent('M04', 'Cici', 'Informatika', 4000000));
check($r->find('M01') === null && $r->find('M04') !== null, 'CRUD Update NIM');
$r->delete('M04');
check(count($r->all()) === 2, 'CRUD Delete');

// T02, T03, T04, T05, Tugas 2 & Latihan 2: Overloading __call()
$p = new StudentPresenter();
check($p->showData('Ahmad') === 'Nama: Ahmad', 'T02: __call 1 argumen');
check($p->showData('2026001', 'Ahmad') === 'NIM: 2026001, Nama: Ahmad', 'T03: __call 2 argumen');
check($p->showData('2026001', 'Ahmad', 'TI') === 'NIM: 2026001, Nama: Ahmad, Prodi: TI', 'Tugas 2: __call 3 argumen');
check($p->showData('2026001', 'Ahmad', 'TI', 'Semester 4') === 'NIM: 2026001, Nama: Ahmad, Prodi: TI, Semester: Semester 4', 'Latihan 2: __call 4 argumen');

fails(fn() => $p->showData(), InvalidArgumentException::class, 'T04: showData() tanpa argumen -> InvalidArgumentException');
fails(fn() => $p->showData(123), InvalidArgumentException::class, 'Validasi non-string -> InvalidArgumentException');
fails(fn() => $p->unknown(), BadMethodCallException::class, 'T05: Method tidak dikenal -> BadMethodCallException');

// T08 & Final check
fails(fn() => new ScholarshipStudent('M05', 'Dina', 'TI', 1000, -1), InvalidArgumentException::class, 'T08a: Diskon -1 invalid');
fails(fn() => new ScholarshipStudent('M05', 'Dina', 'TI', 1000, 101), InvalidArgumentException::class, 'T08b: Diskon 101 invalid');
check((new ReflectionMethod(Student::class, 'getId'))->isFinal(), 'Final method terverifikasi');

echo "TOTAL: $pass tests passed\n";