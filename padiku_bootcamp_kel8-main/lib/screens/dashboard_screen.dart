import 'package:flutter/material.dart';
import '../utils/app_colors.dart';
import '../utils/routes.dart';

class DashboardScreen extends StatefulWidget {
  const DashboardScreen({super.key});

  @override
  State<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> {
  int _selectedIndex = 0;

  final List<Widget> _screens = [
    const HomeDashboard(),
    const DataLahanModule(),
    const JadwalTanamModule(),
    const PrediksiPanenModule(),
    const MenuModule(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('PADIKU'),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        elevation: 0,
        actions: [
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: () {
              Navigator.pushReplacementNamed(context, Routes.login);
            },
          ),
        ],
      ),
      body: _screens[_selectedIndex],
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _selectedIndex,
        onTap: (index) {
          setState(() {
            _selectedIndex = index;
          });
        },
        type: BottomNavigationBarType.fixed,
        selectedItemColor: AppColors.riceGreen,
        unselectedItemColor: Colors.grey,
        items: const [
          BottomNavigationBarItem(
            icon: Icon(Icons.home),
            label: 'Home',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.landscape),
            label: 'Lahan',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.calendar_today),
            label: 'Jadwal',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.grain),
            label: 'Panen',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.menu),
            label: 'Menu',
          ),
        ],
      ),
    );
  }
}

class HomeDashboard extends StatelessWidget {
  const HomeDashboard({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Welcome Card
          Card(
            elevation: 4,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            child: Container(
              decoration: BoxDecoration(
                gradient: AppColors.riceGradient,
                borderRadius: BorderRadius.circular(12),
              ),
              padding: const EdgeInsets.all(20),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Selamat Datang di PADIKU',
                    style: TextStyle(
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                      color: AppColors.riceWhite,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    'Sistem Informasi Tanaman Padi Kabupaten Karawang',
                    style: TextStyle(
                      fontSize: 14,
                      color: AppColors.riceCream,
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 20),

          // Statistics Cards
          const Text(
            'Statistik Utama',
            style: TextStyle(
              fontSize: 20,
              fontWeight: FontWeight.bold,
              color: AppColors.textPrimary,
            ),
          ),
          const SizedBox(height: 12),
          GridView.count(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            crossAxisCount: 2,
            mainAxisSpacing: 12,
            crossAxisSpacing: 12,
            children: [
              _buildStatCard(
                'Statistik Sawah',
                Icons.landscape,
                AppColors.riceGreen,
                Routes.daftarLahan,
                context,
              ),
              _buildStatCard(
                'Statistik Produksi',
                Icons.agriculture,
                AppColors.riceYellow,
                Routes.laporanProduksi,
                context,
              ),
              _buildStatCard(
                'Prediksi Panen',
                Icons.grain,
                AppColors.riceOrange,
                Routes.estimasiTanggal,
                context,
              ),
              _buildStatCard(
                'Neraca Pangan',
                Icons.restaurant,
                AppColors.riceGold,
                Routes.surplusDefisit,
                context,
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildStatCard(
    String title,
    IconData icon,
    Color color,
    String route,
    BuildContext context,
  ) {
    return Card(
      elevation: 4,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: InkWell(
        onTap: () {
          Navigator.pushNamed(context, route);
        },
        borderRadius: BorderRadius.circular(12),
        child: Container(
          padding: const EdgeInsets.all(16),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                icon,
                size: 48,
                color: color,
              ),
              const SizedBox(height: 12),
              Text(
                title,
                textAlign: TextAlign.center,
                style: const TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.bold,
                  color: AppColors.textPrimary,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

// Placeholder widgets for each module
class DataLahanModule extends StatelessWidget {
  const DataLahanModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(
      context,
      'Data Lahan',
      Icons.landscape,
      [
        {'title': 'Daftar Lahan', 'route': Routes.daftarLahan},
        {'title': 'Tambah Lahan', 'route': Routes.tambahLahan},
        {'title': 'Detail Lahan', 'route': Routes.detailLahan},
        {'title': 'Peta Sebaran Lahan', 'route': Routes.petaSebaranLahan},
      ],
    );
  }
}

class JadwalTanamModule extends StatelessWidget {
  const JadwalTanamModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(
      context,
      'Jadwal Tanam',
      Icons.calendar_today,
      [
        {'title': 'Input Jadwal Tanam', 'route': Routes.inputJadwalTanam},
        {'title': 'Kalender Tanam', 'route': Routes.kalenderTanam},
        {'title': 'Monitoring Fase Tanam', 'route': Routes.monitoringFase},
        {'title': 'Rekomendasi Waktu Tanam', 'route': Routes.rekomendasiWaktu},
      ],
    );
  }
}

class PrediksiPanenModule extends StatelessWidget {
  const PrediksiPanenModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(
      context,
      'Prediksi Panen',
      Icons.grain,
      [
        {'title': 'Estimasi Tanggal Panen', 'route': Routes.estimasiTanggal},
        {'title': 'Estimasi Produksi', 'route': Routes.estimasiProduksi},
        {'title': 'Panen Per Kecamatan', 'route': Routes.panenPerKecamatan},
        {'title': 'Peringatan Panen Serempak', 'route': Routes.peringatanPanen},
      ],
    );
  }
}

class PupukSubsidiModule extends StatelessWidget {
  const PupukSubsidiModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(
      context,
      'Pupuk Subsidi',
      Icons.eco,
      [
        {'title': 'Kebutuhan Pupuk', 'route': Routes.kebutuhanPupuk},
        {'title': 'Distribusi Pupuk', 'route': Routes.distribusiPupuk},
        {'title': 'Jadwal Penyaluran', 'route': Routes.jadwalPenyaluran},
        {'title': 'Riwayat Penyaluran', 'route': Routes.riwayatPenyaluran},
      ],
    );
  }
}

class NeracaPanganModule extends StatelessWidget {
  const NeracaPanganModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(
      context,
      'Neraca Pangan',
      Icons.restaurant,
      [
        {'title': 'Produksi Beras', 'route': Routes.produksiBeras},
        {'title': 'Kebutuhan Beras', 'route': Routes.kebutuhanBeras},
        {'title': 'Surplus & Defisit', 'route': Routes.surplusDefisit},
        {'title': 'Prediksi Ketersediaan Pangan', 'route': Routes.prediksiKetersediaan},
      ],
    );
  }
}

class PetaPertanianModule extends StatelessWidget {
  const PetaPertanianModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(
      context,
      'Peta Pertanian Karawang',
      Icons.map,
      [
        {'title': 'Sebaran Sawah', 'route': Routes.sebaranSawah},
        {'title': 'Sebaran Produksi', 'route': Routes.sebaranProduksi},
        {'title': 'Sebaran Panen', 'route': Routes.sebaranPanen},
        {'title': 'Wilayah Rawan Alih Fungsi', 'route': Routes.wilayahRawanAlihFungsi},
      ],
    );
  }
}

class LaporanModule extends StatelessWidget {
  const LaporanModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(
      context,
      'Laporan',
      Icons.assessment,
      [
        {'title': 'Laporan Produksi', 'route': Routes.laporanProduksi},
        {'title': 'Laporan Panen', 'route': Routes.laporanPanen},
        {'title': 'Laporan Pupuk', 'route': Routes.laporanPupuk},
        {'title': 'Laporan Ketahanan Pangan', 'route': Routes.laporanKetahananPangan},
      ],
    );
  }
}

class PengaturanModule extends StatelessWidget {
  const PengaturanModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(
      context,
      'Pengaturan',
      Icons.settings,
      [
        {'title': 'Profil', 'route': Routes.profil},
        {'title': 'Kelola Pengguna', 'route': Routes.kelolaPengguna},
        {'title': 'Hak Akses', 'route': Routes.hakAkses},
      ],
    );
  }
}

class MenuModule extends StatelessWidget {
  const MenuModule({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'Menu Lainnya',
            style: TextStyle(
              fontSize: 20,
              fontWeight: FontWeight.bold,
              color: AppColors.textPrimary,
            ),
          ),
          const SizedBox(height: 16),
          _buildMenuItem(
            context,
            'Pupuk Subsidi',
            Icons.eco,
            AppColors.riceGreen,
            const PupukSubsidiModule(),
          ),
          _buildMenuItem(
            context,
            'Neraca Pangan',
            Icons.restaurant,
            AppColors.riceYellow,
            const NeracaPanganModule(),
          ),
          _buildMenuItem(
            context,
            'Peta Pertanian Karawang',
            Icons.map,
            AppColors.riceOrange,
            const PetaPertanianModule(),
          ),
          _buildMenuItem(
            context,
            'Laporan',
            Icons.assessment,
            AppColors.riceGold,
            const LaporanModule(),
          ),
          _buildMenuItem(
            context,
            'Pengaturan',
            Icons.settings,
            AppColors.riceBrown,
            const PengaturanModule(),
          ),
        ],
      ),
    );
  }

  Widget _buildMenuItem(
    BuildContext context,
    String title,
    IconData icon,
    Color color,
    Widget screen,
  ) {
    return Card(
      elevation: 4,
      margin: const EdgeInsets.only(bottom: 12),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: InkWell(
        onTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(builder: (context) => screen),
          );
        },
        borderRadius: BorderRadius.circular(12),
        child: Container(
          padding: const EdgeInsets.all(16),
          child: Row(
            children: [
              Container(
                width: 50,
                height: 50,
                decoration: BoxDecoration(
                  color: color.withOpacity(0.2),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Icon(icon, color: color, size: 28),
              ),
              const SizedBox(width: 16),
              Expanded(
                child: Text(
                  title,
                  style: const TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                    color: AppColors.textPrimary,
                  ),
                ),
              ),
              const Icon(Icons.arrow_forward_ios, color: AppColors.textSecondary),
            ],
          ),
        ),
      ),
    );
  }
}

Widget _buildModuleContent(
  BuildContext context,
  String title,
  IconData icon,
  List<Map<String, String>> items,
) {
  return SingleChildScrollView(
    padding: const EdgeInsets.all(16),
    child: Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Card(
          elevation: 4,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
          child: Container(
            decoration: BoxDecoration(
              gradient: AppColors.riceGradient,
              borderRadius: BorderRadius.circular(12),
            ),
            padding: const EdgeInsets.all(20),
            child: Row(
              children: [
                Icon(
                  icon,
                  size: 48,
                  color: AppColors.riceWhite,
                ),
                const SizedBox(width: 16),
                Expanded(
                  child: Text(
                    title,
                    style: const TextStyle(
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                      color: AppColors.riceWhite,
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
        const SizedBox(height: 20),
        ...items.map((item) => Card(
              elevation: 2,
              margin: const EdgeInsets.only(bottom: 12),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
              ),
              child: ListTile(
                leading: Icon(icon, color: AppColors.riceGreen),
                title: Text(item['title']!),
                trailing: const Icon(Icons.arrow_forward_ios),
                onTap: () {
                  Navigator.pushNamed(context, item['route']!);
                },
              ),
            )),
      ],
    ),
  );
}
