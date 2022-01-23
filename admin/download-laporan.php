<?php

session_start();

//cek login jika gagal lempar kembali ke login.php
if (!isset($_SESSION["login"])){
    echo "<script>
    alert('Anda harus login terlebih dahulu');
    document.location.href = 'login.php';
    </script>";
exit;
}

require 'vendor/autoload.php';

require 'config/core.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A4', 'No ')->getColumnDimension('A')->setAutoSize('true');
$sheet->setCellValue('B4', 'NIP')->getColumnDimension('B')->setAutoSize('true');
$sheet->setCellValue('C4', 'Nama')->getColumnDimension('C')->setAutoSize('true');
$sheet->setCellValue('d4', 'Bidang')->getColumnDimension('D')->setAutoSize('true');
$sheet->setCellValue('E4', 'Jenis Kelamin')->getColumnDimension('E')->setAutoSize('true');
$sheet->setCellValue('F4', 'Alamat')->getColumnDimension('F')->setAutoSize('true');
$sheet->setCellValue('G4', 'Email')->getColumnDimension('G')->setAutoSize('true');
$sheet->setCellValue('H4', 'telepon')->getColumnDimension('H')->setAutoSize('true');
$sheet->setCellValue('I4', 'Golongan')->getColumnDimension('I')->setAutoSize('true');
$sheet->setCellValue('J4', 'Gaji')->getColumnDimension('J')->setAutoSize('true');
$sheet->setCellValue('K4', 'Status')->getColumnDimension('K')->setAutoSize('true');
$sheet->setCellValue('L4', 'Terhitung Masa Kerja')->getColumnDimension('L')->setAutoSize('true');
$sheet->setCellValue('M4', 'tanggal Input')->getColumnDimension('M')->setAutoSize('true');

// query ke database
$query = query("SELECT * FROM pegawai JOIN bidang ON pegawai.id_bidang = bidang.id_bidang ORDER BY nama ASC");

// tampil data
$no =1;
$m =5;

foreach($query as $data){
    $sheet-> setCellValue('A'. $m, $no++);
    $sheet-> setCellValue('B'. $m, $data['nip']);
    $sheet-> setCellValue('C'. $m, $data['nama']);
    $sheet-> setCellValue('D'. $m, $data['nama_bidang']);
    $sheet-> setCellValue('E'. $m, $data['jk']);
    $sheet-> setCellValue('F'. $m, $data['alamat']);
    $sheet-> setCellValue('G'. $m, $data['email']);
    $sheet-> setCellValue('H'. $m, $data['no_telepon']);
    $sheet-> setCellValue('I'. $m, $data['golongan']);
    $sheet-> setCellValue('J'. $m, $data['gaji']);
    $sheet-> setCellValue('K'. $m, $data['status']);
    $sheet-> setCellValue('L'. $m, date('d/m/Y',strtotime($data['tmk'])));
    $sheet-> setCellValue('M'. $m, date('d/m/Y H:i:s', strtotime($data['tanggal'])));

    $m++;

}

// styling
$style = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \phpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$baris = $m -1;
$sheet ->getStyle('A4:L' . $baris)->applyFromArray($style);

$writer = new Xlsx($spreadsheet);
$fileName = 'Contoh Laporan.xlsx';
$writer->save($fileName);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length: ' . filesize($fileName));
header('Content-Disposition: attachment;filename="' . $fileName . '"');
readfile($fileName); // send file
unlink($fileName); // delete file
exit;