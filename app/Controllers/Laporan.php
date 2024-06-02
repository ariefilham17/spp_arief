<?php

namespace App\Controllers;

use App\Models\KeuanganModel;
use App\Models\PembayaranModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends BaseController
{
    public function keuangan()
    {
        $data           = [
            'page'      => "Keuangan",
            'title'     => 'Keuangan',
        ];

        return view('page/laporan/keuangan', $data);
    }

    public function print($tipe = '')
    {
        if ($tipe == 'keuangan') {
            /* //////////////////////////////////////////////////// */
            $ds         = $this->request->getVar('ds');

            $explode    = explode('-', $ds);
            $tahun      = $explode[0] ?? false;
            $bulan      = $explode[1] ?? false;

            if (!$tahun || !$bulan) {
                return die('<script>alert(\'Data tidak ditemukan\'); window.close();</script>');
            }

            $pembayaranModel    = new PembayaranModel();
            $pembayaran         = $pembayaranModel
                ->select('tbl_siswa.nama as siswa, tbl_pembayaran_detail.nominal as nominal, tbl_pembayaran_detail.periode, tbl_pembayaran.tanggal, tbl_jenis.nama as pembayaran')
                ->where('tbl_pembayaran.status', 1)
                ->where('DATE_FORMAT(tbl_pembayaran.tanggal,"%Y-%m") =', $ds)
                ->join('tbl_siswa', 'tbl_siswa.id = tbl_pembayaran.siswa', 'left')
                ->join('tbl_pembayaran_detail', 'tbl_pembayaran.id = tbl_pembayaran_detail.pembayaran', 'left')
                ->join('tbl_jenis', 'tbl_pembayaran_detail.biaya = tbl_jenis.id', 'left')
                ->get()
                ->getResultArray();

            $data = [];
            if (count($pembayaran) > 0) {
                foreach ($pembayaran as $value) {
                    $data[] = [
                        'tanggal'       => date('d M Y', strtotime($value['tanggal'])),
                        'dt'            => strtotime($value['tanggal']),
                        'debit'         => NULL,
                        'kredit'        => $value['nominal'],
                        'tipe'          => "Pembayaran",
                        'keterangan'    => 'Pembayaran ' . $value['pembayaran'] . ' ' . $value['siswa'] . ($value['periode'] ? ' Periode ' . date('M Y', strtotime($value['periode'])) : '')
                    ];
                }
            }

            $keuanganModel      = new KeuanganModel();
            $keuangan           = $keuanganModel
                ->select('tbl_keuangan.*, tbl_jenis.nama as jenis')
                ->join('tbl_jenis', 'tbl_keuangan.jenis = tbl_jenis.id', 'left')
                ->where('DATE_FORMAT(tbl_keuangan.tanggal,"%Y-%m") =', $ds)
                ->where('tbl_keuangan.status', 1)
                ->get()
                ->getResultArray();

            if (count($keuangan) > 0) {
                foreach ($keuangan as $value) {
                    $data[] = [
                        'tanggal'       => date('d M Y', strtotime($value['tanggal'])),
                        'dt'            => strtotime($value['tanggal']),
                        'debit'         => $value['debit'],
                        'kredit'        => $value['kredit'],
                        'tipe'          => $value['debit'] != NULL ? "Pengeluaran" : "Pemasukan",
                        'keterangan'    => $value['jenis']
                    ];
                }
            }

            usort($data, fn ($a, $b) => $a['dt'] <=> $b['dt']);
            /* //////////////////////////////////////////////////// */
            $spreadsheet = new Spreadsheet();

            $activeWorkSheet = $spreadsheet->getActiveSheet();
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(50, 'px');
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(100, 'px');
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(100, 'px');
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(300, 'px');
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(100, 'px');
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(100, 'px');
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(100, 'px');

            $activeWorkSheet->getStyle("A1:G4")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $activeWorkSheet->getStyle("A1:G6")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFFFFFF'],
                    ],
                ]
            ]);
            $activeWorkSheet->getStyle('A1:G1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 14
                ]
            ]);


            $activeWorkSheet->mergeCells('A1:B4');
            $activeWorkSheet->mergeCells('C1:E1');
            $activeWorkSheet->mergeCells('C2:E2');
            $activeWorkSheet->mergeCells('C3:E3');
            $activeWorkSheet->mergeCells('C4:E4');
            $activeWorkSheet->mergeCells('F1:G4');

            $headerYayasan  = 'YAYASAN NURUL HAQ AL-MADINAH';
            $headerNama     = 'SMP NURUL HAQ KLATEN NSS:202031009217 NPSN:70027342';
            $headerAlamat   = 'Jln. Al-Madinah, Ngemplak, Prawatan, Jogonalan 57454';
            $headerTitle    = 'Rincian Uang Masuk dan Keluar Bulan ' . date('F Y', strtotime($ds . '-01'));

            $activeWorkSheet->setCellValue('C1', $headerYayasan);
            $activeWorkSheet->setCellValue('C2', $headerNama);
            $activeWorkSheet->setCellValue('C3', $headerAlamat);
            $activeWorkSheet->setCellValue('C4', $headerTitle);

            $start = $row = 7;
            /* //////////////////////////////////////////////////// */
            $activeWorkSheet->getStyle("A$row:G$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $activeWorkSheet->getStyle("A$row:G$row")->applyFromArray([
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => array('argb' => 'ff64813d')
                )
            ]);

            /* //////////////////////////////////////////////////// */
            /*                      TABLE DATA                      */
            /* //////////////////////////////////////////////////// */
            $activeWorkSheet->setCellValue('A' . $row, 'No');
            $activeWorkSheet->setCellValue('B' . $row, 'Tanggal');
            $activeWorkSheet->setCellValue('C' . $row, 'Tipe');
            $activeWorkSheet->setCellValue('D' . $row, 'Keterangan');
            $activeWorkSheet->setCellValue('E' . $row, 'Pemasukan');
            $activeWorkSheet->setCellValue('F' . $row, 'Pengeluaran');
            $activeWorkSheet->setCellValue('G' . $row, 'Saldo');

            $row++;
            /* //////////////////////////////////////////////////// */
            $no = 1;
            $tanggal_pos = false;
            $saldo = $pemasukan = $pengeluaran = 0;
            if (count($data) > 0) {
                foreach ($data as $value) {
                    $saldo = ($value['debit'] ? $saldo - $value['debit'] : $saldo + $value['kredit']);
                    $pemasukan += ($value['kredit'] ?? 0);
                    $pengeluaran += ($value['debit'] ?? 0);

                    $activeWorkSheet->setCellValue('A' . $row, $no);
                    $activeWorkSheet->setCellValue('B' . $row, $value['tanggal'] != $tanggal_pos ? $value['tanggal'] : "");
                    $activeWorkSheet->setCellValue('C' . $row, $value['tipe']);
                    $activeWorkSheet->setCellValue('D' . $row, $value['keterangan']);
                    $activeWorkSheet->setCellValue('E' . $row, number_format($value['kredit']) != 0 ? number_format($value['kredit']) : '');
                    $activeWorkSheet->setCellValue('F' . $row, number_format($value['debit']) != 0 ? number_format($value['debit']) : '');
                    $activeWorkSheet->setCellValue('G' . $row, number_format($saldo) != 0 ? number_format($saldo) : '');

                    $activeWorkSheet->getStyle("A$row:C$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $activeWorkSheet->getStyle("E$row:G$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                    $row++;
                    $no++;

                    $tanggal_pos = $value['tanggal'];
                }
            }
            /* //////////////////////////////////////////////////// */
            /*                  END TABLE  DATA                     */
            /* //////////////////////////////////////////////////// */

            /* //////////////////////////////////////////////////// */
            /*                       FOOTER                         */
            /* //////////////////////////////////////////////////// */
            $activeWorkSheet->mergeCells("A$row:D$row");

            $activeWorkSheet->getStyle("A$row:C$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $activeWorkSheet->getStyle("E$row:G$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

            $activeWorkSheet->setCellValue('A' . $row, "Total");
            $activeWorkSheet->setCellValue('E' . $row, number_format($pemasukan) != 0 ? number_format($pemasukan) : '');
            $activeWorkSheet->setCellValue('F' . $row, number_format($pengeluaran) != 0 ? number_format($pengeluaran) : '');
            $activeWorkSheet->setCellValue('G' . $row, number_format($pemasukan - $pengeluaran) != 0 ? number_format($pemasukan - $pengeluaran) : '');
            /* //////////////////////////////////////////////////// */
            /*                      END  FOOTER                     */
            /* //////////////////////////////////////////////////// */
            $activeWorkSheet->getStyle("A$start:G$row")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                ]
            ]);


            $writer = new Xlsx($spreadsheet);
            $filename = 'laporan_keuangan_' . $ds . '_' . time() . '.xlsx';
            $writer->save('export/' . $filename);

            if (file_exists('export/' . $filename)) {
                return redirect()->to(base_url('export/' . $filename));
            }
        }
    }
}
