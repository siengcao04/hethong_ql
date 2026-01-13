<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Kiểm tra dữ liệu ===\n";
echo "Tổng điểm: " . App\Models\Diem::count() . "\n";
echo "Có DTB: " . App\Models\Diem::whereNotNull('diem_trung_binh')->count() . "\n";
echo "Có trang_thai: " . App\Models\Diem::whereNotNull('trang_thai')->count() . "\n";

$first = App\Models\Diem::first();
if ($first) {
    echo "\nDiểm đầu tiên:\n";
    echo "  CC: {$first->diem_chuyen_can}\n";
    echo "  GK: {$first->diem_giua_ky}\n";
    echo "  CK: {$first->diem_cuoi_ky}\n";
    echo "  DTB: " . ($first->diem_trung_binh ?? 'NULL') . "\n";
    echo "  Trạng thái: " . ($first->trang_thai ?? 'NULL') . "\n";
}

echo "\n=== Thống kê trạng thái ===\n";
$stats = App\Models\Diem::select('trang_thai', \DB::raw('count(*) as total'))
    ->groupBy('trang_thai')
    ->get();
foreach ($stats as $stat) {
    echo "{$stat->trang_thai}: {$stat->total}\n";
}
