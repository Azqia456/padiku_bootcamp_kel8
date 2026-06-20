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
    const LaporHamaModule(),
    const MenuModule(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        elevation: 0,
        leading: Stack(
          children: [
            IconButton(
              icon: const Icon(Icons.notifications),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => const PupukSubsidiModule(),
                  ),
                );
              },
            ),
            Positioned(
              right: 8,
              top: 8,
              child: Container(
                width: 8,
                height: 8,
                decoration: const BoxDecoration(
                  color: AppColors.riceYellow,
                  shape: BoxShape.circle,
                ),
              ),
            ),
          ],
        ),
        actions: [
          const Text(
            'Petani',
            style: TextStyle(
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(width: 8),
          PopupMenuButton<String>(
            icon: Container(
              width: 36,
              height: 36,
              decoration: BoxDecoration(
                color: AppColors.riceYellow,
                shape: BoxShape.circle,
              ),
              child: const Center(
                child: Text(
                  'P',
                  style: TextStyle(
                    color: AppColors.riceGreen,
                    fontWeight: FontWeight.bold,
                    fontSize: 18,
                  ),
                ),
              ),
            ),
            onSelected: (String choice) {
              if (choice == 'logout') {
                Navigator.pushReplacementNamed(context, Routes.login);
              } else if (choice == 'profile') {
                // Navigate to profile
              }
            },
            itemBuilder: (BuildContext context) {
              return [
                const PopupMenuItem<String>(
                  value: 'profile',
                  child: Row(
                    children: [
                      Icon(Icons.person),
                      SizedBox(width: 8),
                      Text('Profil'),
                    ],
                  ),
                ),
                const PopupMenuItem<String>(
                  value: 'logout',
                  child: Row(
                    children: [
                      Icon(Icons.logout),
                      SizedBox(width: 8),
                      Text('Keluar'),
                    ],
                  ),
                ),
              ];
            },
          ),
          const SizedBox(width: 8),
        ],
      ),
      body: _screens[_selectedIndex],
      bottomNavigationBar: Container(
        height: 80,
        decoration: BoxDecoration(
          color: Colors.white,
          boxShadow: [
            BoxShadow(
              color: Colors.grey.withOpacity(0.2),
              blurRadius: 10,
              offset: const Offset(0, -2),
            ),
          ],
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceAround,
          children: [
            // Left side: Lahan and Jadwal
            _buildNavItem(
              Icons.landscape,
              'Lahan',
              1,
              context,
            ),
            _buildNavItem(
              Icons.calendar_today,
              'Jadwal',
              2,
              context,
            ),
            // Center: Home button with background
            GestureDetector(
              onTap: () {
                setState(() {
                  _selectedIndex = 0;
                });
              },
              child: Container(
                width: 60,
                height: 60,
                decoration: BoxDecoration(
                  color: AppColors.riceYellow,
                  shape: BoxShape.circle,
                  boxShadow: [
                    BoxShadow(
                      color: AppColors.riceYellow.withOpacity(0.4),
                      blurRadius: 10,
                      offset: const Offset(0, 4),
                    ),
                  ],
                ),
                child: const Icon(
                  Icons.home,
                  color: AppColors.riceGreen,
                  size: 32,
                ),
              ),
            ),
            // Right side: Lapor Hama and Settings
            _buildNavItem(
              Icons.bug_report,
              'Lapor',
              3,
              context,
            ),
            _buildNavItem(
              Icons.settings,
              'Setelan',
              4,
              context,
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildNavItem(
    IconData icon,
    String label,
    int index,
    BuildContext context,
  ) {
    final isSelected = _selectedIndex == index;
    return GestureDetector(
      onTap: () {
        setState(() {
          _selectedIndex = index;
        });
      },
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Icon(
              icon,
              color: isSelected ? AppColors.riceGreen : Colors.grey,
              size: 24,
            ),
            const SizedBox(height: 4),
            Text(
              label,
              style: TextStyle(
                fontSize: 11,
                color: isSelected ? AppColors.riceGreen : Colors.grey,
                fontWeight: isSelected ? FontWeight.w600 : FontWeight.normal,
              ),
            ),
          ],
        ),
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
            elevation: 2,
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
                    'Selamat Datang, Petani!',
                    style: TextStyle(
                      fontSize: 22,
                      fontWeight: FontWeight.bold,
                      color: AppColors.riceWhite,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    'Kelola lahan dan tanaman Anda dengan mudah',
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

          // Bar Chart Section
          Card(
            elevation: 2,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'Luas Lahan Aktif per Tahun',
                    style: TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 16),
                  _buildBarChart(),
                  const SizedBox(height: 12),
                  Container(
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      color: Colors.orange.shade50,
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: Row(
                      children: [
                        Icon(
                          Icons.trending_down,
                          color: Colors.orange.shade700,
                          size: 20,
                        ),
                        const SizedBox(width: 8),
                        Expanded(
                          child: Text(
                            'Penurunan luas lahan aktif: -7.4% dari 2024 ke 2026',
                            style: TextStyle(
                              fontSize: 12,
                              color: Colors.orange.shade900,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 20),

          // Two Columns: Jadwal Tanam and Status Tanaman
          Row(
            children: [
              Expanded(
                child: _buildInfoCard(
                  'Jadwal Tanam',
                  '15 Juli 2026',
                  Icons.calendar_today,
                  AppColors.riceGreen,
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: _buildInfoCard(
                  'Status Tanaman',
                  'Fase Vegetatif',
                  Icons.grass,
                  AppColors.riceYellow,
                ),
              ),
            ],
          ),
          const SizedBox(height: 20),

          // Notifications
          const Text(
            'Notifikasi Penting',
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: AppColors.textPrimary,
            ),
          ),
          const SizedBox(height: 12),
          _buildNotificationCard(
            '⚠️ Peringatan Hama',
            'Terdapat laporan wereng dalam radius 3 km dari lahan Anda',
            Icons.warning,
            Colors.orange,
          ),
          const SizedBox(height: 12),
          _buildNotificationCard(
            '💡 Rekomendasi',
            'Waktunya melakukan pemupukan tahap 2',
            Icons.lightbulb,
            AppColors.riceGreen,
          ),
          const SizedBox(height: 20),

          // Rekomendasi Budidaya Section
          const Text(
            'Rekomendasi Budidaya',
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: AppColors.textPrimary,
            ),
          ),
          const SizedBox(height: 12),
          _buildRecommendationCard(
            'Gunakan Mulsa Jerami',
            'Menjaga kelembaban tanah dan menekan pertumbuhan gulma',
            Icons.grass,
            AppColors.riceGreen,
          ),
          const SizedBox(height: 8),
          _buildRecommendationCard(
            'Hindari Pembakaran Jerami',
            'Jerami dapat dijadikan kompos untuk kesuburan tanah',
            Icons.block,
            Colors.red,
          ),
          const SizedBox(height: 8),
          _buildRecommendationCard(
            'Tambah Bahan Organik',
            'Pupuk kandang atau kompos untuk meningkatkan struktur tanah',
            Icons.compost,
            AppColors.riceYellow,
          ),
        ],
      ),
    );
  }

  Widget _buildBarChart() {
    return Container(
      height: 220,
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceAround,
        crossAxisAlignment: CrossAxisAlignment.end,
        children: [
          _buildBar('2024', 27, AppColors.riceGreen, 0.85),
          _buildBar('2025', 26, AppColors.riceYellow, 0.82),
          _buildBar('2026', 23, AppColors.riceOrange, 0.73),
        ],
      ),
    );
  }

  Widget _buildBar(String year, int value, Color color, double percentage) {
    return Column(
      children: [
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
          decoration: BoxDecoration(
            color: color.withOpacity(0.15),
            borderRadius: BorderRadius.circular(12),
          ),
          child: Text(
            '$value Ha',
            style: TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.bold,
              color: color,
            ),
          ),
        ),
        const SizedBox(height: 12),
        Container(
          width: 60,
          height: 140 * percentage,
          decoration: BoxDecoration(
            gradient: LinearGradient(
              begin: Alignment.topCenter,
              end: Alignment.bottomCenter,
              colors: [
                color,
                color.withOpacity(0.7),
              ],
            ),
            borderRadius: BorderRadius.circular(12),
            boxShadow: [
              BoxShadow(
                color: color.withOpacity(0.3),
                blurRadius: 8,
                offset: const Offset(0, 4),
              ),
            ],
          ),
        ),
        const SizedBox(height: 12),
        Text(
          year,
          style: const TextStyle(
            fontSize: 14,
            fontWeight: FontWeight.w700,
            color: AppColors.textPrimary,
          ),
        ),
      ],
    );
  }

  Widget _buildInfoCard(
    String title,
    String value,
    IconData icon,
    Color color,
  ) {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            Container(
              width: 45,
              height: 45,
              decoration: BoxDecoration(
                color: color.withOpacity(0.2),
                borderRadius: BorderRadius.circular(12),
              ),
              child: Icon(icon, color: color, size: 24),
            ),
            const SizedBox(height: 8),
            Text(
              title,
              textAlign: TextAlign.center,
              style: const TextStyle(
                fontSize: 12,
                color: Colors.grey,
              ),
            ),
            const SizedBox(height: 4),
            Text(
              value,
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
    );
  }

  Widget _buildNotificationCard(
    String title,
    String message,
    IconData icon,
    Color color,
  ) {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            Container(
              width: 45,
              height: 45,
              decoration: BoxDecoration(
                color: color.withOpacity(0.2),
                borderRadius: BorderRadius.circular(10),
              ),
              child: Icon(icon, color: color, size: 24),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: const TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    message,
                    style: const TextStyle(
                      fontSize: 12,
                      color: Colors.grey,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildRecommendationCard(
    String title,
    String description,
    IconData icon,
    Color color,
  ) {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
        padding: const EdgeInsets.all(14),
        child: Row(
          children: [
            Container(
              width: 45,
              height: 45,
              decoration: BoxDecoration(
                color: color.withOpacity(0.2),
                borderRadius: BorderRadius.circular(10),
              ),
              child: Icon(icon, color: color, size: 24),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: const TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    description,
                    style: const TextStyle(
                      fontSize: 12,
                      color: Colors.grey,
                    ),
                  ),
                ],
              ),
            ),
          ],
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
    return SingleChildScrollView(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Card(
            elevation: 2,
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
                  const Icon(
                    Icons.landscape,
                    size: 48,
                    color: AppColors.riceWhite,
                  ),
                  const SizedBox(width: 16),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Text(
                          'Data Lahan',
                          style: TextStyle(
                            fontSize: 22,
                            fontWeight: FontWeight.bold,
                            color: AppColors.riceWhite,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          'Kelola lahan pertanian Anda',
                          style: TextStyle(
                            fontSize: 14,
                            color: AppColors.riceCream,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 20),
          _buildLahanCard(
            context,
            'Tambah Lahan',
            'Tambah lahan baru ke dalam sistem',
            Icons.add_circle_outline,
            AppColors.riceGreen,
          ),
          const SizedBox(height: 12),
          _buildLahanCard(
            context,
            'Detail Lahan',
            'Lihat detail informasi lahan',
            Icons.info_outline,
            AppColors.riceYellow,
          ),
          const SizedBox(height: 12),
          _buildLahanCard(
            context,
            'Lokasi Lahan',
            'Lihat lokasi lahan di peta',
            Icons.map_outlined,
            AppColors.riceOrange,
          ),
        ],
      ),
    );
  }

  Widget _buildLahanCard(
    BuildContext context,
    String title,
    String subtitle,
    IconData icon,
    Color color,
  ) {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: InkWell(
        onTap: () {
          // Navigate to respective screen
        },
        borderRadius: BorderRadius.circular(12),
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Row(
            children: [
              Container(
                width: 55,
                height: 55,
                decoration: BoxDecoration(
                  color: color.withOpacity(0.2),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Icon(icon, color: color, size: 30),
              ),
              const SizedBox(width: 16),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: const TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        color: AppColors.textPrimary,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      subtitle,
                      style: const TextStyle(
                        fontSize: 13,
                        color: Colors.grey,
                      ),
                    ),
                  ],
                ),
              ),
              const Icon(
                Icons.arrow_forward_ios,
                color: Colors.grey,
                size: 18,
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class JadwalTanamModule extends StatelessWidget {
  const JadwalTanamModule({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Card(
            elevation: 2,
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
                  const Icon(
                    Icons.calendar_today,
                    size: 48,
                    color: AppColors.riceWhite,
                  ),
                  const SizedBox(width: 16),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Text(
                          'Jadwal Tanam',
                          style: TextStyle(
                            fontSize: 22,
                            fontWeight: FontWeight.bold,
                            color: AppColors.riceWhite,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          'Pantau fase pertumbuhan tanaman',
                          style: TextStyle(
                            fontSize: 14,
                            color: AppColors.riceCream,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 20),
          _buildJadwalCard(
            context,
            'Input Tanggal Tanam',
            'Catat tanggal mulai tanam',
            Icons.event_available,
            AppColors.riceGreen,
          ),
          const SizedBox(height: 12),
          _buildJadwalCard(
            context,
            'Kalender Tanam',
            'Lihat jadwal tanaman',
            Icons.calendar_month,
            AppColors.riceYellow,
          ),
          const SizedBox(height: 20),
          const Text(
            'Fase Pertumbuhan',
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: AppColors.textPrimary,
            ),
          ),
          const SizedBox(height: 12),
          _buildGrowthPhase(
            'Tanam',
            'Fase awal penanaman',
            Icons.grain,
            AppColors.riceGreen,
            true,
          ),
          const SizedBox(height: 8),
          _buildGrowthPhase(
            'Vegetatif',
            'Pertumbuhan daun dan batang',
            Icons.grass,
            AppColors.riceYellow,
            true,
          ),
          const SizedBox(height: 8),
          _buildGrowthPhase(
            'Pembungaan',
            'Fase pembentukan bunga',
            Icons.local_florist,
            AppColors.riceOrange,
            false,
          ),
          const SizedBox(height: 8),
          _buildGrowthPhase(
            'Panen',
            'Siap untuk dipanen',
            Icons.agriculture,
            AppColors.riceGold,
            false,
          ),
        ],
      ),
    );
  }

  Widget _buildJadwalCard(
    BuildContext context,
    String title,
    String subtitle,
    IconData icon,
    Color color,
  ) {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: InkWell(
        onTap: () {
          // Navigate to respective screen
        },
        borderRadius: BorderRadius.circular(12),
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Row(
            children: [
              Container(
                width: 55,
                height: 55,
                decoration: BoxDecoration(
                  color: color.withOpacity(0.2),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Icon(icon, color: color, size: 30),
              ),
              const SizedBox(width: 16),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: const TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        color: AppColors.textPrimary,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      subtitle,
                      style: const TextStyle(
                        fontSize: 13,
                        color: Colors.grey,
                      ),
                    ),
                  ],
                ),
              ),
              const Icon(
                Icons.arrow_forward_ios,
                color: Colors.grey,
                size: 18,
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildGrowthPhase(
    String title,
    String description,
    IconData icon,
    Color color,
    bool isCompleted,
  ) {
    return Card(
      elevation: 1,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(10),
      ),
      child: Padding(
        padding: const EdgeInsets.all(14),
        child: Row(
          children: [
            Container(
              width: 45,
              height: 45,
              decoration: BoxDecoration(
                color: isCompleted ? color : color.withOpacity(0.3),
                borderRadius: BorderRadius.circular(10),
              ),
              child: Icon(
                icon,
                color: isCompleted ? AppColors.riceWhite : color,
                size: 24,
              ),
            ),
            const SizedBox(width: 14),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: TextStyle(
                      fontSize: 15,
                      fontWeight: FontWeight.bold,
                      color: isCompleted
                          ? AppColors.textPrimary
                          : Colors.grey,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    description,
                    style: TextStyle(
                      fontSize: 12,
                      color: isCompleted ? Colors.grey[700] : Colors.grey[500],
                    ),
                  ),
                ],
              ),
            ),
            if (isCompleted)
              const Icon(
                Icons.check_circle,
                color: AppColors.riceGreen,
                size: 20,
              ),
          ],
        ),
      ),
    );
  }
}

class LaporHamaModule extends StatefulWidget {
  const LaporHamaModule({super.key});

  @override
  State<LaporHamaModule> createState() => _LaporHamaModuleState();
}

class _LaporHamaModuleState extends State<LaporHamaModule> {
  String? _selectedPestType;
  final List<String> _pestTypes = [
    'Wereng',
    'Walang Sangit',
    'Belalang',
    'Ulat Grayak',
    'Penyakit Blas',
    'Lainnya',
  ];

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Card(
            elevation: 2,
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
                  const Icon(
                    Icons.bug_report,
                    size: 48,
                    color: AppColors.riceWhite,
                  ),
                  const SizedBox(width: 16),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Text(
                          'Lapor Hama',
                          style: TextStyle(
                            fontSize: 22,
                            fontWeight: FontWeight.bold,
                            color: AppColors.riceWhite,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          'Laporkan serangan hama di sekitar Anda',
                          style: TextStyle(
                            fontSize: 14,
                            color: AppColors.riceCream,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 20),
          const Text(
            'Jenis Hama',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.bold,
              color: AppColors.textPrimary,
            ),
          ),
          const SizedBox(height: 12),
          GridView.count(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            crossAxisCount: 2,
            mainAxisSpacing: 10,
            crossAxisSpacing: 10,
            children: _pestTypes.map((pest) {
              final isSelected = _selectedPestType == pest;
              return Card(
                elevation: isSelected ? 4 : 1,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                  side: BorderSide(
                    color: isSelected ? AppColors.riceGreen : Colors.transparent,
                    width: 2,
                  ),
                ),
                child: InkWell(
                  onTap: () {
                    setState(() {
                      _selectedPestType = pest;
                    });
                  },
                  borderRadius: BorderRadius.circular(12),
                  child: Container(
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      color: isSelected
                          ? AppColors.riceGreen.withOpacity(0.1)
                          : Colors.white,
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Icon(
                          Icons.bug_report,
                          color: isSelected
                              ? AppColors.riceGreen
                              : Colors.grey,
                          size: 32,
                        ),
                        const SizedBox(height: 8),
                        Text(
                          pest,
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontSize: 13,
                            fontWeight: FontWeight.w600,
                            color: isSelected
                                ? AppColors.riceGreen
                                : Colors.grey[700],
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              );
            }).toList(),
          ),
          const SizedBox(height: 20),
          _buildUploadSection(),
          const SizedBox(height: 20),
          _buildLocationSection(),
          const SizedBox(height: 20),
          SizedBox(
            width: double.infinity,
            height: 50,
            child: ElevatedButton(
              onPressed: _selectedPestType != null ? () {} : null,
              style: ElevatedButton.styleFrom(
                backgroundColor: AppColors.riceGreen,
                foregroundColor: Colors.white,
                elevation: 0,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
              ),
              child: const Text(
                'Kirim Laporan',
                style: TextStyle(fontWeight: FontWeight.w600),
              ),
            ),
          ),
          const SizedBox(height: 20),
          const Text(
            'Notifikasi Hama Terdekat',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.bold,
              color: AppColors.textPrimary,
            ),
          ),
          const SizedBox(height: 12),
          _buildPestNotification(
            '🐛 Wereng',
            '📍 Desa Lemahabang',
            '2.5 km dari lahan Anda',
            Colors.orange,
          ),
          const SizedBox(height: 8),
          _buildPestNotification(
            '🦗 Walang Sangit',
            '📍 Desa Telukjambe',
            '4.2 km dari lahan Anda',
            Colors.red,
          ),
        ],
      ),
    );
  }

  Widget _buildUploadSection() {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                Icon(
                  Icons.photo_camera,
                  color: AppColors.riceGreen,
                  size: 24,
                ),
                const SizedBox(width: 12),
                const Text(
                  'Upload Foto',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                    color: AppColors.textPrimary,
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            Container(
              width: double.infinity,
              height: 120,
              decoration: BoxDecoration(
                color: Colors.grey.shade100,
                borderRadius: BorderRadius.circular(10),
                border: Border.all(color: Colors.grey.shade300),
              ),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(
                    Icons.add_photo_alternate,
                    size: 40,
                    color: Colors.grey.shade400,
                  ),
                  const SizedBox(height: 8),
                  Text(
                    'Tap untuk upload foto',
                    style: TextStyle(
                      fontSize: 13,
                      color: Colors.grey.shade600,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildLocationSection() {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            Container(
              width: 50,
              height: 50,
              decoration: BoxDecoration(
                color: AppColors.riceGreen.withOpacity(0.2),
                borderRadius: BorderRadius.circular(12),
              ),
              child: const Icon(
                Icons.location_on,
                color: AppColors.riceGreen,
                size: 28,
              ),
            ),
            const SizedBox(width: 16),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'Lokasi Otomatis',
                    style: TextStyle(
                      fontSize: 15,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Row(
                    children: [
                      Icon(
                        Icons.check_circle,
                        color: AppColors.riceGreen,
                        size: 16,
                      ),
                      const SizedBox(width: 4),
                      Text(
                        'GPS Aktif',
                        style: TextStyle(
                          fontSize: 12,
                          color: AppColors.riceGreen,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildPestNotification(
    String pest,
    String location,
    String distance,
    Color color,
  ) {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(10),
      ),
      child: Padding(
        padding: const EdgeInsets.all(14),
        child: Row(
          children: [
            Container(
              width: 45,
              height: 45,
              decoration: BoxDecoration(
                color: color.withOpacity(0.2),
                borderRadius: BorderRadius.circular(10),
              ),
              child: Center(
                child: Text(
                  pest.split(' ')[0],
                  style: TextStyle(
                    fontSize: 20,
                  ),
                ),
              ),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    pest,
                    style: const TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    location,
                    style: const TextStyle(
                      fontSize: 12,
                      color: Colors.grey,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    distance,
                    style: TextStyle(
                      fontSize: 11,
                      color: color,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ],
              ),
            ),
            Icon(
              Icons.warning,
              color: color,
              size: 20,
            ),
          ],
        ),
      ),
    );
  }
}

class RekomendasiBudidayaModule extends StatelessWidget {
  const RekomendasiBudidayaModule({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Card(
            elevation: 2,
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
                  const Icon(
                    Icons.lightbulb,
                    size: 48,
                    color: AppColors.riceWhite,
                  ),
                  const SizedBox(width: 16),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Text(
                          'Rekomendasi Budidaya',
                          style: TextStyle(
                            fontSize: 22,
                            fontWeight: FontWeight.bold,
                            color: AppColors.riceWhite,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          'Tips untuk hasil panen yang lebih baik',
                          style: TextStyle(
                            fontSize: 14,
                            color: AppColors.riceCream,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 20),
          _buildRecommendationCard(
            'Gunakan Mulsa Jerami',
            'Menjaga kelembaban tanah dan menekan pertumbuhan gulma',
            Icons.grass,
            AppColors.riceGreen,
          ),
          const SizedBox(height: 12),
          _buildRecommendationCard(
            'Hindari Pembakaran Jerami',
            'Jerami dapat dijadikan kompos untuk kesuburan tanah',
            Icons.block,
            Colors.red,
          ),
          const SizedBox(height: 12),
          _buildRecommendationCard(
            'Tambah Bahan Organik',
            'Pupuk kandang atau kompos untuk meningkatkan struktur tanah',
            Icons.compost,
            AppColors.riceYellow,
          ),
          const SizedBox(height: 12),
          _buildRecommendationCard(
            'Waspada Kekeringan',
            'Pastikan sistem irigasi berfungsi baik saat musim kemarau',
            Icons.water_drop,
            Colors.blue,
          ),
          const SizedBox(height: 12),
          _buildRecommendationCard(
            'Rotasi Tanaman',
            'Tanam tanaman berbeda setiap musim untuk menjaga kesuburan',
            Icons.autorenew,
            AppColors.riceOrange,
          ),
        ],
      ),
    );
  }

  Widget _buildRecommendationCard(
    String title,
    String description,
    IconData icon,
    Color color,
  ) {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
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
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: const TextStyle(
                      fontSize: 15,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    description,
                    style: const TextStyle(
                      fontSize: 13,
                      color: Colors.grey,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class PupukSubsidiModule extends StatelessWidget {
  const PupukSubsidiModule({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Card(
            elevation: 2,
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
                  const Icon(
                    Icons.eco,
                    size: 48,
                    color: AppColors.riceWhite,
                  ),
                  const SizedBox(width: 16),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Text(
                          'Informasi Pupuk',
                          style: TextStyle(
                            fontSize: 22,
                            fontWeight: FontWeight.bold,
                            color: AppColors.riceWhite,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          'Kelola kebutuhan pupuk Anda',
                          style: TextStyle(
                            fontSize: 14,
                            color: AppColors.riceCream,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 20),
          _buildPupukCard(
            'Jadwal Distribusi',
            '20 Juli 2026',
            'Pengecer KUD Tani',
            Icons.calendar_today,
            AppColors.riceGreen,
          ),
          const SizedBox(height: 12),
          _buildPupukCard(
            'Status Pengajuan',
            'Disetujui',
            'Siap diambil',
            Icons.check_circle,
            Colors.green,
          ),
          const SizedBox(height: 12),
          _buildPupukCard(
            'Kuota Pupuk',
            '500 kg',
            'Tersisa 200 kg',
            Icons.inventory_2,
            AppColors.riceOrange,
          ),
        ],
      ),
    );
  }

  Widget _buildPupukCard(
    String title,
    String value,
    String subtitle,
    IconData icon,
    Color color,
  ) {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
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
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: const TextStyle(
                      fontSize: 14,
                      color: Colors.grey,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    value,
                    style: const TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    subtitle,
                    style: const TextStyle(
                      fontSize: 12,
                      color: Colors.grey,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
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
      elevation: 2,
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
