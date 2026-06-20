import 'package:flutter/material.dart';
import '../screens/login_screen.dart';
import '../screens/dashboard_screen.dart';
import '../screens/data_lahan/daftar_lahan_screen.dart';
import '../screens/data_lahan/tambah_lahan_screen.dart';
import '../screens/data_lahan/detail_lahan_screen.dart';
import '../screens/data_lahan/peta_sebaran_lahan_screen.dart';
import '../screens/jadwal_tanam/input_jadwal_screen.dart';
import '../screens/jadwal_tanam/kalender_tanam_screen.dart';
import '../screens/jadwal_tanam/monitoring_fase_screen.dart';
import '../screens/jadwal_tanam/rekomendasi_waktu_screen.dart';
import '../screens/prediksi_panen/estimasi_tanggal_screen.dart';
import '../screens/prediksi_panen/estimasi_produksi_screen.dart';
import '../screens/prediksi_panen/panen_per_kecamatan_screen.dart';
import '../screens/prediksi_panen/peringatan_panen_screen.dart';
import '../screens/pupuk_subsidi/kebutuhan_pupuk_screen.dart';
import '../screens/pupuk_subsidi/distribusi_pupuk_screen.dart';
import '../screens/pupuk_subsidi/jadwal_penyaluran_screen.dart';
import '../screens/pupuk_subsidi/riwayat_penyaluran_screen.dart';
import '../screens/neraca_pangan/produksi_beras_screen.dart';
import '../screens/neraca_pangan/kebutuhan_beras_screen.dart';
import '../screens/neraca_pangan/surplus_defisit_screen.dart';
import '../screens/neraca_pangan/prediksi_ketersediaan_screen.dart';
import '../screens/peta_pertanian/sebaran_sawah_screen.dart';
import '../screens/peta_pertanian/sebaran_produksi_screen.dart';
import '../screens/peta_pertanian/sebaran_panen_screen.dart';
import '../screens/peta_pertanian/wilayah_rawan_alih_fungsi_screen.dart';
import '../screens/laporan/laporan_produksi_screen.dart';
import '../screens/laporan/laporan_panen_screen.dart';
import '../screens/laporan/laporan_pupuk_screen.dart';
import '../screens/laporan/laporan_ketahanan_pangan_screen.dart';
import '../screens/pengaturan/profil_screen.dart';
import '../screens/pengaturan/kelola_pengguna_screen.dart';
import '../screens/pengaturan/hak_akses_screen.dart';

class Routes {
  static const String login = '/login';
  static const String dashboard = '/dashboard';
  
  // Data Lahan
  static const String daftarLahan = '/data-lahan/daftar';
  static const String tambahLahan = '/data-lahan/tambah';
  static const String detailLahan = '/data-lahan/detail';
  static const String petaSebaranLahan = '/data-lahan/peta';
  
  // Jadwal Tanam
  static const String inputJadwalTanam = '/jadwal-tanam/input';
  static const String kalenderTanam = '/jadwal-tanam/kalender';
  static const String monitoringFase = '/jadwal-tanam/monitoring';
  static const String rekomendasiWaktu = '/jadwal-tanam/rekomendasi';
  
  // Prediksi Panen
  static const String estimasiTanggal = '/prediksi-panen/estimasi-tanggal';
  static const String estimasiProduksi = '/prediksi-panen/estimasi-produksi';
  static const String panenPerKecamatan = '/prediksi-panen/per-kecamatan';
  static const String peringatanPanen = '/prediksi-panen/peringatan';
  
  // Pupuk Subsidi
  static const String kebutuhanPupuk = '/pupuk-subsidi/kebutuhan';
  static const String distribusiPupuk = '/pupuk-subsidi/distribusi';
  static const String jadwalPenyaluran = '/pupuk-subsidi/jadwal';
  static const String riwayatPenyaluran = '/pupuk-subsidi/riwayat';
  
  // Neraca Pangan
  static const String produksiBeras = '/neraca-pangan/produksi';
  static const String kebutuhanBeras = '/neraca-pangan/kebutuhan';
  static const String surplusDefisit = '/neraca-pangan/surplus-defisit';
  static const String prediksiKetersediaan = '/neraca-pangan/prediksi';
  
  // Peta Pertanian
  static const String sebaranSawah = '/peta-pertanian/sebaran-sawah';
  static const String sebaranProduksi = '/peta-pertanian/sebaran-produksi';
  static const String sebaranPanen = '/peta-pertanian/sebaran-panen';
  static const String wilayahRawanAlihFungsi = '/peta-pertanian/rawan-alih-fungsi';
  
  // Laporan
  static const String laporanProduksi = '/laporan/produksi';
  static const String laporanPanen = '/laporan/panen';
  static const String laporanPupuk = '/laporan/pupuk';
  static const String laporanKetahananPangan = '/laporan/ketahanan-pangan';
  
  // Pengaturan
  static const String profil = '/pengaturan/profil';
  static const String kelolaPengguna = '/pengaturan/kelola-pengguna';
  static const String hakAkses = '/pengaturan/hak-akses';

  static Map<String, WidgetBuilder> getRoutes() {
    return {
      login: (context) => const LoginScreen(),
      dashboard: (context) => const DashboardScreen(),
      
      // Data Lahan
      daftarLahan: (context) => const DaftarLahanScreen(),
      tambahLahan: (context) => const TambahLahanScreen(),
      detailLahan: (context) => const DetailLahanScreen(),
      petaSebaranLahan: (context) => const PetaSebaranLahanScreen(),
      
      // Jadwal Tanam
      inputJadwalTanam: (context) => const InputJadwalTanamScreen(),
      kalenderTanam: (context) => const KalenderTanamScreen(),
      monitoringFase: (context) => const MonitoringFaseScreen(),
      rekomendasiWaktu: (context) => const RekomendasiWaktuScreen(),
      
      // Prediksi Panen
      estimasiTanggal: (context) => const EstimasiTanggalScreen(),
      estimasiProduksi: (context) => const EstimasiProduksiScreen(),
      panenPerKecamatan: (context) => const PanenPerKecamatanScreen(),
      peringatanPanen: (context) => const PeringatanPanenScreen(),
      
      // Pupuk Subsidi
      kebutuhanPupuk: (context) => const KebutuhanPupukScreen(),
      distribusiPupuk: (context) => const DistribusiPupukScreen(),
      jadwalPenyaluran: (context) => const JadwalPenyaluranScreen(),
      riwayatPenyaluran: (context) => const RiwayatPenyaluranScreen(),
      
      // Neraca Pangan
      produksiBeras: (context) => const ProduksiBerasScreen(),
      kebutuhanBeras: (context) => const KebutuhanBerasScreen(),
      surplusDefisit: (context) => const SurplusDefisitScreen(),
      prediksiKetersediaan: (context) => const PrediksiKetersediaanScreen(),
      
      // Peta Pertanian
      sebaranSawah: (context) => const SebaranSawahScreen(),
      sebaranProduksi: (context) => const SebaranProduksiScreen(),
      sebaranPanen: (context) => const SebaranPanenScreen(),
      wilayahRawanAlihFungsi: (context) => const WilayahRawanAlihFungsiScreen(),
      
      // Laporan
      laporanProduksi: (context) => const LaporanProduksiScreen(),
      laporanPanen: (context) => const LaporanPanenScreen(),
      laporanPupuk: (context) => const LaporanPupukScreen(),
      laporanKetahananPangan: (context) => const LaporanKetahananPanganScreen(),
      
      // Pengaturan
      profil: (context) => const ProfilScreen(),
      kelolaPengguna: (context) => const KelolaPenggunaScreen(),
      hakAkses: (context) => const HakAksesScreen(),
    };
  }
}