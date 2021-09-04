<?php 
require_once __DIR__ . '/vendor/autoload.php';
use MathPHP\Finance;
class Financial {

    public function proteksiJiwa($penghasilanPerTahun = 240000000, $pengeluaranPerBulan = 15000000, $asumsiBungaInvestasi = 6/100,  $kpr = null, $kpm = null, $cc = null, $creditBussiness = 500000000, $otherCredit = null)
    {

        $total = $kpr + $kpm + $cc + $creditBussiness + $otherCredit;
        $upIdeal = ($penghasilanPerTahun / $asumsiBungaInvestasi) + $total;
        $upMinimal = (($pengeluaranPerBulan * 12) / $asumsiBungaInvestasi) + $total;
        return [
            'ideal' => $upIdeal,
            'minimal' => $upMinimal
        ];
    }

    public function danaPendidikan()
    {
        $umurAnak = 10;
        $waktuSimpanan = 18-$umurAnak; //96 bulan atau 8 tahun
        $biayaPendidikan = 50000000; //biaya pendidikan sekarang
        $inflasiPendidikan = 10/100;
        $biayaPendidikanNantiNya = $biayaPendidikan * (1+$inflasiPendidikan) ** $waktuSimpanan; //future value
        $asumsiBungaInvestasi = 10/100;
        $tabunganPerBulan = Finance::pmt(0.1/12, $waktuSimpanan*12, 0, $biayaPendidikanNantiNya, 1);
        $tabunganPerBulan = str_replace("-", "", $tabunganPerBulan);
        return $tabunganPerBulan;
    }

    public function danaPensiun()
    {
      $danaPensiunPerbulan = 10000000;
      $tingkatBunga = 0.06;
      $jumlahIdeal = ($danaPensiunPerbulan * 12) / $tingkatBunga;
      $jumlahInginDicapai = $jumlahIdeal;
      $asumsiBungaInvestasi = 0.2;
      $usiaSekarang = 45;
      $usiaPensiun  = 55;
      $jangkaWaktuSimpanan = $usiaPensiun - $usiaSekarang;
      $result = Finance::pmt($asumsiBungaInvestasi/12, $jangkaWaktuSimpanan*12, 0, $jumlahInginDicapai, 1);
      $result = str_replace("-", "", $result);
      return $result;
    }


    public static function rupiah($angka)
    {
      return "Rp " . number_format($angka,0,',','.');
    }

    public static function line()
    {
        return PHP_EOL . "===========================" . PHP_EOL;
    }
}

$finance = new Financial();

echo PHP_EOL . "###### Perhitungan Proteksi Jiwa ######" . PHP_EOL;
// echo $finance::rupiah($finance->proteksiJiwa());
echo "UP Ideal : " . $finance::rupiah($finance->proteksiJiwa()['ideal']) . "\n"; 
echo "UP Minimal : " . $finance::rupiah($finance->proteksiJiwa()['minimal']) . "\n";

echo $finance->line();

echo PHP_EOL . "###### Perhitungan Dana Pendidikan ######" . PHP_EOL;
echo "Tabungan Reguler Perbulan : " . $finance::rupiah($finance->danaPendidikan());

echo $finance->line();

echo PHP_EOL . "###### Perhitungan Dana Pensiun ######" . PHP_EOL;
echo "Tabungan Reguler Bulanan : " . $finance::rupiah($finance->danaPensiun());
