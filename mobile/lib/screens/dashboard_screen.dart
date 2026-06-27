import 'package:flutter/material.dart';
import '../utils/app_colors.dart';
import '../utils/routes.dart';

class DashboardScreen extends StatefulWidget {
  final int initialIndex;
  const DashboardScreen({super.key, this.initialIndex = 0});

  @override
  State<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> {
  late int _selectedIndex;

  @override
  void initState() {
    super.initState();
    _selectedIndex = widget.initialIndex;
  }

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
      backgroundColor: const Color(0xFFF5F7F5),
      appBar: null,
      body: _screens[_selectedIndex],
      bottomNavigationBar: Container(
        height: 94,
        decoration: BoxDecoration(
          color: const Color(0xFFF5F7F5),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withAlpha(8),
              blurRadius: 18,
              offset: const Offset(0, -6),
            ),
          ],
        ),
        child: Stack(
          clipBehavior: Clip.none,
          children: [
            Container(
              margin: const EdgeInsets.fromLTRB(14, 12, 14, 10),
              padding: const EdgeInsets.symmetric(horizontal: 8),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(28),
                border: Border.all(color: Colors.green.shade50),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withAlpha(13),
                    blurRadius: 18,
                    offset: const Offset(0, 8),
                  ),
                ],
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceAround,
                children: [
                  _buildNavItem(Icons.landscape_rounded, 'Lahan', 1, context),
                  _buildNavItem(
                    Icons.calendar_month_rounded,
                    'Jadwal',
                    2,
                    context,
                  ),
                  const Spacer(),
                  _buildNavItem(Icons.assignment_rounded, 'Lapor', 3, context),
                  _buildNavItem(Icons.person_rounded, 'Akun', 4, context),
                ],
              ),
            ),
            Positioned(
              top: -8,
              left: MediaQuery.of(context).size.width / 2 - 34,
              child: GestureDetector(
                onTap: () {
                  setState(() {
                    _selectedIndex = 0;
                  });
                },
                child: Container(
                  width: 68,
                  height: 68,
                  decoration: BoxDecoration(
                    gradient: const LinearGradient(
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight,
                      colors: [Color(0xFF43A047), Color(0xFF2E7D32)],
                    ),
                    shape: BoxShape.circle,
                    border: Border.all(color: Colors.white, width: 5),
                    boxShadow: [
                      BoxShadow(
                        color: Color(0xFF2E7D32).withAlpha(71),
                        blurRadius: 18,
                        offset: const Offset(0, 8),
                      ),
                    ],
                  ),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      const Icon(Icons.grass, color: Colors.white, size: 28),
                      if (_selectedIndex == 0)
                        Container(
                          margin: const EdgeInsets.only(top: 3),
                          width: 20,
                          height: 3,
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(99),
                          ),
                        ),
                    ],
                  ),
                ),
              ),
            ),
            Positioned(
              bottom: 13,
              left: MediaQuery.of(context).size.width / 2 - 22,
              child: Text(
                'Beranda',
                style: TextStyle(
                  fontSize: 11,
                  color: _selectedIndex == 0
                      ? const Color(0xFF2E7D32)
                      : Colors.grey.shade500,
                  fontWeight: _selectedIndex == 0
                      ? FontWeight.w600
                      : FontWeight.normal,
                ),
              ),
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
        if (index == 4) {
          // Navigate to Profil screen
          Navigator.pushNamed(context, Routes.profil);
        } else {
          setState(() {
            _selectedIndex = index;
          });
        }
      },
      behavior: HitTestBehavior.opaque,
      child: SizedBox(
        width: 68,
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            AnimatedContainer(
              duration: const Duration(milliseconds: 220),
              padding: const EdgeInsets.all(10),
              decoration: BoxDecoration(
                color: isSelected
                    ? const Color(0xFFE7F4E8)
                    : Colors.transparent,
                borderRadius: BorderRadius.circular(16),
              ),
              child: Icon(
                icon,
                color: isSelected
                    ? const Color(0xFF2E7D32)
                    : Colors.grey.shade400,
                size: 24,
              ),
            ),
            const SizedBox(height: 4),
            Text(
              label,
              style: TextStyle(
                fontSize: 11,
                color: isSelected
                    ? const Color(0xFF2E7D32)
                    : Colors.grey.shade500,
                fontWeight: isSelected ? FontWeight.w600 : FontWeight.normal,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

Widget _buildModernModuleLayout({
  required String title,
  required String subtitle,
  required IconData icon,
  required List<Widget> children,
  String? badge,
}) {
  return SafeArea(
    bottom: false,
    child: SingleChildScrollView(
      padding: const EdgeInsets.only(bottom: 26),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildModernTopBanner(
            title: title,
            subtitle: subtitle,
            icon: icon,
            badge: badge,
          ),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: children,
            ),
          ),
        ],
      ),
    ),
  );
}

Widget _buildModernTopBanner({
  required String title,
  required String subtitle,
  required IconData icon,
  String? badge,
}) {
  return Container(
    margin: const EdgeInsets.fromLTRB(20, 12, 20, 0),
    padding: const EdgeInsets.all(22),
    decoration: BoxDecoration(
      borderRadius: BorderRadius.circular(28),
      gradient: const LinearGradient(
        begin: Alignment.topLeft,
        end: Alignment.bottomRight,
        colors: [Color(0xFF43A047), Color(0xFF2E7D32)],
      ),
      boxShadow: [
        BoxShadow(
          color: Color(0xFF2E7D32).withAlpha(46),
          blurRadius: 22,
          offset: const Offset(0, 10),
        ),
      ],
    ),
    child: Stack(
      children: [
        Positioned(
          top: -30,
          right: -20,
          child: Container(
            width: 120,
            height: 120,
            decoration: BoxDecoration(
              color: Colors.white.withAlpha(26),
              shape: BoxShape.circle,
            ),
          ),
        ),
        Positioned(
          bottom: -34,
          left: -16,
          child: Container(
            width: 90,
            height: 90,
            decoration: BoxDecoration(
              color: Colors.white.withAlpha(20),
              shape: BoxShape.circle,
            ),
          ),
        ),
        Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      if (badge != null) ...[
                        Container(
                          padding: const EdgeInsets.symmetric(
                            horizontal: 12,
                            vertical: 6,
                          ),
                          decoration: BoxDecoration(
                            color: Colors.white.withAlpha(41),
                            borderRadius: BorderRadius.circular(99),
                            border: Border.all(color: Colors.white24),
                          ),
                          child: Text(
                            badge,
                            style: const TextStyle(
                              color: Colors.white,
                              fontSize: 11,
                              fontWeight: FontWeight.w600,
                            ),
                          ),
                        ),
                        const SizedBox(height: 14),
                      ],
                      Text(
                        title,
                        style: const TextStyle(
                          color: Colors.white,
                          fontSize: 26,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      const SizedBox(height: 8),
                      Text(
                        subtitle,
                        style: const TextStyle(
                          color: Colors.white70,
                          fontSize: 14,
                          height: 1.45,
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(width: 16),
                Container(
                  width: 64,
                  height: 64,
                  decoration: BoxDecoration(
                    color: Colors.white.withAlpha(36),
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: Colors.white24),
                  ),
                  child: Icon(icon, color: Colors.white, size: 32),
                ),
              ],
            ),
          ],
        ),
      ],
    ),
  );
}

Widget _buildSectionHeading(String title, String subtitle) {
  return Column(
    crossAxisAlignment: CrossAxisAlignment.start,
    children: [
      Text(
        title,
        style: const TextStyle(
          fontSize: 17,
          fontWeight: FontWeight.bold,
          color: Colors.black87,
        ),
      ),
      const SizedBox(height: 4),
      Text(
        subtitle,
        style: TextStyle(
          fontSize: 13,
          color: Colors.grey.shade600,
          height: 1.4,
        ),
      ),
    ],
  );
}

Widget _buildSoftCard({
  required Widget child,
  EdgeInsetsGeometry padding = const EdgeInsets.all(16),
  Color color = Colors.white,
  Border? border,
}) {
  return Container(
    padding: padding,
    decoration: BoxDecoration(
      color: color,
      borderRadius: BorderRadius.circular(22),
      border: border ?? Border.all(color: Colors.green.shade50),
      boxShadow: [
        BoxShadow(
          color: Colors.black.withAlpha(13),
          blurRadius: 16,
          offset: const Offset(0, 8),
        ),
      ],
    ),
    child: child,
  );
}

Widget _buildQuickInfoChip({
  required String label,
  required String value,
  required IconData icon,
  Color iconColor = AppColors.riceGreen,
}) {
  return Expanded(
    child: _buildSoftCard(
      padding: const EdgeInsets.all(14),
      color: const Color(0xFFF9FCF8),
      child: Row(
        children: [
          Container(
            width: 42,
            height: 42,
            decoration: BoxDecoration(
              color: iconColor.withAlpha(31),
              borderRadius: BorderRadius.circular(14),
            ),
            child: Icon(icon, color: iconColor, size: 22),
          ),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  label,
                  style: TextStyle(fontSize: 12, color: Colors.grey.shade600),
                ),
                const SizedBox(height: 2),
                Text(
                  value,
                  style: const TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.bold,
                    color: Colors.black87,
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

Widget _buildModernActionCard({
  required String title,
  required String subtitle,
  required IconData icon,
  required Color color,
  VoidCallback? onTap,
}) {
  return Material(
    color: Colors.transparent,
    child: InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(22),
      child: Ink(
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(22),
          border: Border.all(color: Colors.green.shade50),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withAlpha(13),
              blurRadius: 16,
              offset: const Offset(0, 8),
            ),
          ],
        ),
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Row(
            children: [
              Container(
                width: 54,
                height: 54,
                decoration: BoxDecoration(
                  color: color.withAlpha(36),
                  borderRadius: BorderRadius.circular(18),
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
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        color: Colors.black87,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      subtitle,
                      style: TextStyle(
                        fontSize: 13,
                        color: Colors.grey.shade600,
                        height: 1.4,
                      ),
                    ),
                  ],
                ),
              ),
              Container(
                width: 34,
                height: 34,
                decoration: BoxDecoration(
                  color: const Color(0xFFF1F8F1),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(
                  Icons.arrow_forward_rounded,
                  color: AppColors.riceGreen,
                  size: 18,
                ),
              ),
            ],
          ),
        ),
      ),
    ),
  );
}

Widget _buildModernStatusTile({
  required String title,
  required String description,
  required IconData icon,
  required Color color,
  required bool isActive,
}) {
  return _buildSoftCard(
    padding: const EdgeInsets.all(14),
    color: isActive ? const Color(0xFFF6FBF4) : Colors.white,
    border: Border.all(
      color: isActive ? const Color(0xFFCEE9D0) : Colors.green.shade50,
      width: 1.2,
    ),
    child: Row(
      children: [
        Container(
          width: 48,
          height: 48,
            decoration: BoxDecoration(
            color: isActive ? color : color.withAlpha(31),
            borderRadius: BorderRadius.circular(16),
          ),
          child: Icon(icon, color: isActive ? Colors.white : color, size: 24),
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
                  color: isActive ? Colors.black87 : Colors.grey.shade700,
                ),
              ),
              const SizedBox(height: 3),
              Text(
                description,
                style: TextStyle(
                  fontSize: 12,
                  color: Colors.grey.shade600,
                  height: 1.35,
                ),
              ),
            ],
          ),
        ),
        Icon(
          isActive ? Icons.check_circle_rounded : Icons.schedule_rounded,
          color: isActive ? AppColors.riceGreen : Colors.grey.shade400,
          size: 20,
        ),
      ],
    ),
  );
}

String? _getPestAsset(String pest) {
  switch (pest) {
    case 'Wereng':
      return 'assets/images/wareng.png';
    case 'Walang Sangit':
      return 'assets/images/walang_sangit.png';
    case 'Belalang':
      return 'assets/images/belalang.png';
    case 'Ulat Grayak':
      return 'assets/images/ulat_grayak.png';
    case 'Penyakit Blas':
      return 'assets/images/blas.png';
    default:
      return null;
  }
}

Widget _buildModernPestCard({
  required String pest,
  required bool isSelected,
  required VoidCallback onTap,
}) {
  final assetPath = _getPestAsset(pest);

  return Material(
    color: Colors.transparent,
    child: InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(20),
      child: Ink(
        decoration: BoxDecoration(
          color: isSelected ? const Color(0xFFF1F8F1) : Colors.white,
          borderRadius: BorderRadius.circular(20),
          border: Border.all(
            color: isSelected ? const Color(0xFF88C78E) : Colors.green.shade50,
            width: isSelected ? 1.4 : 1,
          ),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withAlpha(10),
              blurRadius: 12,
              offset: const Offset(0, 6),
            ),
          ],
        ),
        child: Padding(
          padding: const EdgeInsets.all(14),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Container(
                width: 52,
                height: 52,
                decoration: BoxDecoration(
                    color: isSelected
                      ? AppColors.riceGreen.withAlpha(36)
                      : Colors.grey.shade100,
                  borderRadius: BorderRadius.circular(16),
                ),
                child: assetPath != null
                    ? Padding(
                        padding: const EdgeInsets.all(6.0),
                        child: Image.asset(
                          assetPath,
                          fit: BoxFit.contain,
                        ),
                      )
                    : Icon(
                        Icons.bug_report_rounded,
                        color: isSelected
                            ? AppColors.riceGreen
                            : Colors.grey.shade500,
                        size: 28,
                      ),
              ),
              const SizedBox(height: 12),
              Text(
                pest,
                textAlign: TextAlign.center,
                style: TextStyle(
                  fontSize: 13,
                  fontWeight: FontWeight.w600,
                  color: isSelected ? AppColors.riceGreen : Colors.black87,
                ),
              ),
            ],
          ),
        ),
      ),
    ),
  );
}

class HomeDashboard extends StatelessWidget {
  const HomeDashboard({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.only(bottom: 30),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildCustomHeader(context),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const SizedBox(height: 20),
                _buildTotalLahanCard(),
                const SizedBox(height: 16),
                _buildLineChartCard(),
                const SizedBox(height: 16),
                Row(
                  children: [
                    Expanded(
                      child: _buildGridCard(
                        'Jadwal',
                        'Tanam',
                        Icons.calendar_month,
                        Colors.green,
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: _buildGridCard(
                        'Status',
                        'Panen',
                        Icons.grass,
                        Colors.orange,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 16),
                _buildListTileCard(
                  'Cuaca Hari Ini',
                  '28°C',
                  'Karawang',
                  'Cerah Berawan',
                  Icons.cloud_queue,
                  Colors.blue,
                ),
                const SizedBox(height: 12),
                _buildListTileCard(
                  'Musim Tanam',
                  'Optimal',
                  'Mulai',
                  '12 Juli 2026',
                  Icons.spa,
                  Colors.green,
                ),
                const SizedBox(height: 12),
                _buildNotificationsList(),
                const SizedBox(height: 24),
                const Text(
                  'Rekomendasi Budidaya',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                    color: Colors.black87,
                  ),
                ),
                const SizedBox(height: 12),
                _buildOriginalRecommendationCard(
                  'Gunakan Mulsa Jerami',
                  'Menjaga kelembaban tanah dan menekan pertumbuhan gulma',
                  Icons.grass,
                  Colors.green,
                ),
                const SizedBox(height: 8),
                _buildOriginalRecommendationCard(
                  'Hindari Pembakaran Jerami',
                  'Jerami dapat dijadikan kompos',
                  Icons.block,
                  Colors.red,
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildCustomHeader(BuildContext context) {
    return ClipPath(
      clipper: HeaderClipper(),
      child: Container(
        height: 240,
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            colors: [Color(0xFF43A047), Color(0xFF2E7D32)],
          ),
          image: DecorationImage(
            image: NetworkImage(
              'https://images.unsplash.com/photo-1595085816353-833215284489?q=80&w=600&auto=format&fit=crop',
            ),
            fit: BoxFit.cover,
            colorFilter: ColorFilter.mode(Colors.black26, BlendMode.darken),
          ),
        ),
        padding: const EdgeInsets.only(top: 50, left: 20, right: 20),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Row(
                  children: [
                    const Icon(Icons.menu, color: Colors.white, size: 28),
                    const SizedBox(width: 12),
                    const Icon(Icons.grass, color: Colors.yellow, size: 28),
                    const SizedBox(width: 8),
                    const Text(
                      'PADIKU',
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                        letterSpacing: 1,
                      ),
                    ),
                  ],
                ),
                Row(
                  children: [
                    PopupMenuButton<String>(
                      icon: Container(
                        decoration: BoxDecoration(
                          shape: BoxShape.circle,
                          border: Border.all(color: Colors.white, width: 2),
                        ),
                        child: const CircleAvatar(
                          radius: 16,
                          backgroundColor: Colors.white,
                          child: Icon(
                            Icons.person,
                            color: Color(0xFF2E7D32),
                            size: 20,
                          ),
                        ),
                      ),
                      onSelected: (String choice) {
                        if (choice == 'logout') {
                          Navigator.pushReplacementNamed(context, Routes.login);
                        }
                      },
                      itemBuilder: (BuildContext context) => [
                        const PopupMenuItem(
                          value: 'profile',
                          child: Text('Profil'),
                        ),
                        const PopupMenuItem(
                          value: 'logout',
                          child: Text('Keluar'),
                        ),
                      ],
                    ),
                    const SizedBox(width: 8),
                    IconButton(
                      icon: const Icon(
                        Icons.notifications_none,
                        color: Colors.white,
                        size: 28,
                      ),
                      onPressed: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => const PupukSubsidiModule(),
                          ),
                        );
                      },
                    ),
                  ],
                ),
              ],
            ),
            const SizedBox(height: 25),
            const Text(
              'Selamat datang,',
              style: TextStyle(color: Colors.white70, fontSize: 16),
            ),
            const SizedBox(height: 4),
            const Text(
              'Petani',
              style: TextStyle(
                color: Colors.white,
                fontSize: 28,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 4),
            Row(
              children: const [
                Text(
                  'Semangat bertani hari ini!',
                  style: TextStyle(color: Colors.white, fontSize: 14),
                ),
                SizedBox(width: 4),
                Icon(Icons.grass, color: Colors.yellow, size: 16),
              ],
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildTotalLahanCard() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.04),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(12),
                decoration: BoxDecoration(
                  color: const Color(0xFF4CAF50),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(
                  Icons.landscape,
                  color: Colors.white,
                  size: 28,
                ),
              ),
              const SizedBox(width: 16),
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'Total Lahan Aktif',
                    style: TextStyle(
                      color: Colors.black54,
                      fontSize: 14,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.baseline,
                    textBaseline: TextBaseline.alphabetic,
                    children: const [
                      Text(
                        '27',
                        style: TextStyle(
                          fontSize: 32,
                          fontWeight: FontWeight.bold,
                          color: Color(0xFF2E7D32),
                        ),
                      ),
                      SizedBox(width: 4),
                      Text(
                        'Hektar',
                        style: TextStyle(
                          fontSize: 14,
                          color: Colors.black87,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ],
          ),
          Icon(Icons.home_work, color: Colors.green.shade200, size: 40),
        ],
      ),
    );
  }

  Widget _buildLineChartCard() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.04),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
Row(
  mainAxisAlignment: MainAxisAlignment.spaceBetween,
  crossAxisAlignment: CrossAxisAlignment.start, // Tambahkan ini agar saat teks turun baris, letaknya tetap rapi di atas
  children: [
    // 1. Bungkus Text dengan Expanded
    Expanded(
      child: const Text(
        'Luas Lahan Aktif (Hektar)',
        style: TextStyle(fontWeight: FontWeight.bold, fontSize: 14),
      ),
    ),
    
    // 2. Tambahkan jarak aman
    const SizedBox(width: 12), 
    
    Container(
      padding: const EdgeInsets.symmetric(
        horizontal: 10,
        vertical: 4,
      ),
      decoration: BoxDecoration(
        border: Border.all(color: Colors.grey.shade300),
        borderRadius: BorderRadius.circular(8),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min, // Pastikan Row dalam tombol ini seefisien mungkin
        children: const [
          Text(
            '3 Tahun Terakhir',
            style: TextStyle(fontSize: 12, color: Colors.black87),
          ),
          SizedBox(width: 4), // Jarak kecil antara teks dan ikon dropdown
          Icon(Icons.keyboard_arrow_down, size: 16),
        ],
      ),
    ),
  ],
),
          const SizedBox(height: 20),
          SizedBox(
            height: 140,
            width: double.infinity,
            child: CustomPaint(painter: LineChartPainter()),
          ),
        ],
      ),
    );
  }

  Widget _buildGridCard(
    String title,
    String subtitle,
    IconData icon,
    Color color,
  ) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: const Color(0xFFF1F8F1),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: Colors.green.shade100, width: 1),
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Icon(icon, color: color, size: 28),
              const SizedBox(height: 12),
              Text(
                title,
                style: const TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 14,
                  color: Colors.black87,
                ),
              ),
              Text(
                subtitle,
                style: const TextStyle(fontSize: 14, color: Colors.black54),
              ),
            ],
          ),
          Container(
            padding: const EdgeInsets.all(4),
            decoration: const BoxDecoration(
              color: Colors.white,
              shape: BoxShape.circle,
            ),
            child: const Icon(
              Icons.chevron_right,
              size: 16,
              color: Colors.black54,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildListTileCard(
    String title,
    String valueLeft,
    String labelRight,
    String valueRight,
    IconData icon,
    Color iconColor,
  ) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.02),
            blurRadius: 8,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: const Color(0xFFF1F8F1),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(icon, color: const Color(0xFF4CAF50), size: 24),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(
                    color: Colors.black54,
                    fontSize: 12,
                    fontWeight: FontWeight.w500,
                  ),
                ),
                Text(
                  valueLeft,
                  style: const TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.bold,
                    color: Colors.black87,
                  ),
                ),
              ],
            ),
          ),
          Column(
            crossAxisAlignment: CrossAxisAlignment.end,
            children: [
              Row(
                children: [
                  if (labelRight == 'Karawang')
                    const Icon(Icons.location_on, size: 12, color: Colors.grey),
                  Text(
                    labelRight,
                    style: const TextStyle(color: Colors.black54, fontSize: 12),
                  ),
                ],
              ),
              Text(
                valueRight,
                style: const TextStyle(
                  fontSize: 13,
                  fontWeight: FontWeight.w600,
                  color: Colors.black87,
                ),
              ),
            ],
          ),
          const SizedBox(width: 12),
          const Icon(Icons.chevron_right, color: Colors.grey),
        ],
      ),
    );
  }

  Widget _buildNotificationsList() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.amber.shade50,
        borderRadius: BorderRadius.circular(16),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: Colors.amber.shade200,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: const Icon(
                  Icons.notifications,
                  color: Colors.orange,
                  size: 20,
                ),
              ),
              const SizedBox(width: 12),
              const Text(
                'Notifikasi Penting',
                style: TextStyle(fontWeight: FontWeight.bold, fontSize: 14),
              ),
            ],
          ),
          const SizedBox(height: 16),
          _buildNotificationRow('Pupuk susulan', '3 hari lagi', Colors.amber),
          const Padding(
            padding: EdgeInsets.symmetric(vertical: 8),
            child: Divider(height: 1, color: Colors.black12),
          ),
          _buildNotificationRow('Prediksi panen', '27 hari lagi', Colors.amber),
          const Padding(
            padding: EdgeInsets.symmetric(vertical: 8),
            child: Divider(height: 1, color: Colors.black12),
          ),
          _buildNotificationRow('⚠️ Waspada Wereng', 'Radius 3 km', Colors.red),
        ],
      ),
    );
  }

  Widget _buildNotificationRow(String title, String trailing, Color dotColor) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Row(
          children: [
            Container(
              width: 8,
              height: 8,
              decoration: BoxDecoration(
                color: dotColor,
                shape: BoxShape.circle,
              ),
            ),
            const SizedBox(width: 8),
            Text(
              title,
              style: const TextStyle(
                fontSize: 13,
                color: Colors.black87,
                fontWeight: FontWeight.w500,
              ),
            ),
          ],
        ),
        Row(
          children: [
            Text(
              trailing,
              style: const TextStyle(
                fontSize: 12,
                color: Colors.green,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(width: 8),
            const Icon(Icons.chevron_right, size: 16, color: Colors.black54),
          ],
        ),
      ],
    );
  }

  Widget _buildOriginalRecommendationCard(
    String title,
    String description,
    IconData icon,
    Color color,
  ) {
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.grey.shade200),
      ),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: color.withOpacity(0.1),
              borderRadius: BorderRadius.circular(8),
            ),
            child: Icon(icon, color: color, size: 20),
          ),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(
                    fontSize: 13,
                    fontWeight: FontWeight.bold,
                    color: Colors.black87,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  description,
                  style: const TextStyle(fontSize: 11, color: Colors.black54),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class HeaderClipper extends CustomClipper<Path> {
  @override
  Path getClip(Size size) {
    var path = Path();
    path.lineTo(0, size.height - 40);
    path.quadraticBezierTo(
      size.width / 4,
      size.height,
      size.width / 2,
      size.height - 20,
    );
    path.quadraticBezierTo(
      size.width * 3 / 4,
      size.height - 40,
      size.width,
      size.height - 10,
    );
    path.lineTo(size.width, 0);
    path.close();
    return path;
  }

  @override
  bool shouldReclip(CustomClipper<Path> oldClipper) => false;
}

class LineChartPainter extends CustomPainter {
  @override
  void paint(Canvas canvas, Size size) {
    final paintLine = Paint()
      ..color = const Color(0xFF4CAF50)
      ..strokeWidth = 3
      ..style = PaintingStyle.stroke;

    final paintFill = Paint()
      ..shader = LinearGradient(
        begin: Alignment.topCenter,
        end: Alignment.bottomCenter,
        colors: [
          const Color(0xFF4CAF50).withOpacity(0.3),
          Colors.white.withOpacity(0.0),
        ],
      ).createShader(Rect.fromLTWH(0, 0, size.width, size.height))
      ..style = PaintingStyle.fill;

    final paintDotOuter = Paint()..color = Colors.white;
    final paintDotInner = Paint()..color = Colors.amber;
    final textPainter = TextPainter(textDirection: TextDirection.ltr);

    final points = [
      Offset(0, size.height * 0.8),
      Offset(size.width * 0.2, size.height * 0.4),
      Offset(size.width * 0.6, size.height * 0.3),
      Offset(size.width * 0.9, size.height * 0.2),
    ];

    final path = Path();
    path.moveTo(points[0].dx, points[0].dy);
    for (int i = 1; i < points.length; i++) {
      path.lineTo(points[i].dx, points[i].dy);
    }

    final fillPath = Path.from(path);
    fillPath.lineTo(size.width, size.height);
    fillPath.lineTo(0, size.height);
    fillPath.close();
    canvas.drawPath(fillPath, paintFill);
    canvas.drawPath(path, paintLine);

    final labelsY = ['0', '10', '20', '30', '40'];
    for (int i = 0; i < labelsY.length; i++) {
      final y = size.height - (i * (size.height / 4));
      canvas.drawLine(
        Offset(0, y),
        Offset(size.width, y),
        Paint()
          ..color = Colors.grey.shade200
          ..strokeWidth = 1,
      );

      textPainter.text = TextSpan(
        text: labelsY[i],
        style: const TextStyle(color: Colors.black54, fontSize: 10),
      );
      textPainter.layout();
      textPainter.paint(canvas, Offset(0, y - 14));
    }

    final labelsX = ['2024', '2025', '2026'];
    for (int i = 0; i < labelsX.length; i++) {
      textPainter.text = TextSpan(
        text: labelsX[i],
        style: const TextStyle(color: Colors.black54, fontSize: 11),
      );
      textPainter.layout();
      textPainter.paint(canvas, Offset(points[i + 1].dx - 12, size.height + 8));
    }

    final values = ['24', '26', '27'];
    for (int i = 1; i < points.length; i++) {
      canvas.drawCircle(points[i], 6, paintDotOuter);
      canvas.drawCircle(points[i], 4, paintDotInner);

      textPainter.text = TextSpan(
        text: values[i - 1],
        style: const TextStyle(
          color: Colors.black,
          fontWeight: FontWeight.bold,
          fontSize: 12,
        ),
      );
      textPainter.layout();
      textPainter.paint(canvas, Offset(points[i].dx - 6, points[i].dy - 20));
    }
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}

// =====================================================================
// KELAS-KELAS ORIGINAL ANDA (Dikembalikan seperti semula agar tidak error)
// =====================================================================

class DataLahanModule extends StatelessWidget {
  const DataLahanModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModernModuleLayout(
      title: 'Data Lahan',
      subtitle:
          'Pantau dan kelola lahan pertanian dengan tampilan yang lebih bersih dan modern.',
      icon: Icons.landscape_rounded,
      badge: 'Ringkasan Lahan',
      children: [
        const SizedBox(height: 20),
        Row(
          children: [
            _buildQuickInfoChip(
              label: 'Lahan aktif',
              value: '27 Hektar',
              icon: Icons.grass_rounded,
            ),
            const SizedBox(width: 12),
            _buildQuickInfoChip(
              label: 'Area terpantau',
              value: '3 zona',
              icon: Icons.map_rounded,
              iconColor: AppColors.riceOrange,
            ),
          ],
        ),
        const SizedBox(height: 24),
        _buildSectionHeading(
          'Kelola lahan',
          'Semua fitur lama tetap tersedia, hanya tampilannya dibuat lebih rapi dan mudah dipindai.',
        ),
        const SizedBox(height: 14),
        
        // 1. UPDATE: Tambahkan onTap untuk navigasi ke Tambah Lahan
        _buildLahanCard(
          context,
          'Tambah Lahan',
          'Tambah lahan baru ke dalam sistem',
          Icons.add_circle_outline_rounded,
          AppColors.riceGreen,
          () {
            Navigator.pushNamed(context, Routes.tambahLahan);
          },
        ),
        const SizedBox(height: 12),
        
        // 2. UPDATE: Tambahkan onTap untuk navigasi ke Detail Lahan
        _buildLahanCard(
          context,
          'Detail Lahan',
          'Lihat detail informasi lahan',
          Icons.info_outline_rounded,
          AppColors.riceYellow,
          () {
            Navigator.pushNamed(context, Routes.detailLahan);
          },
        ),
        const SizedBox(height: 12),
        
        _buildLahanCard(
          context,
          'Lokasi Lahan',
          'Lihat lokasi lahan di peta',
          Icons.map_outlined,
          AppColors.riceOrange,
          () {
            Navigator.pushNamed(context, Routes.petaSebaranLahan);
          },
        ),
      ],
    );
  }

  // 3. UPDATE: Tambahkan parameter `VoidCallback onTap` di sini
  Widget _buildLahanCard(
    BuildContext context,
    String title,
    String subtitle,
    IconData icon,
    Color color,
    VoidCallback onTap, // <--- Parameter baru
  ) {
    return _buildModernActionCard(
      title: title,
      subtitle: subtitle,
      icon: icon,
      color: color,
      onTap: onTap, // <--- Gunakan parameter di sini
    );
  }
}

class JadwalTanamModule extends StatelessWidget {
  const JadwalTanamModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModernModuleLayout(
      title: 'Jadwal Tanam',
      subtitle:
          'Ikuti fase pertumbuhan tanaman dengan tampilan yang lebih informatif dan nyaman dilihat.',
      icon: Icons.calendar_month_rounded,
      badge: 'Musim Tanam',
      children: [
        const SizedBox(height: 20),
        Row(
          children: [
            _buildQuickInfoChip(
              label: 'Status musim',
              value: 'Optimal',
              icon: Icons.wb_sunny_rounded,
            ),
            const SizedBox(width: 12),
            _buildQuickInfoChip(
              label: 'Target panen',
              value: '12 Juli 2026',
              icon: Icons.flag_rounded,
              iconColor: AppColors.riceYellow,
            ),
          ],
        ),
        const SizedBox(height: 24),
        _buildSectionHeading(
          'Akses cepat',
          'Fitur pencatatan dan kalender tetap sama, tampilannya dibuat lebih selaras dengan beranda.',
        ),
        const SizedBox(height: 14),
        _buildJadwalCard(
          context,
          'Input Tanggal Tanam',
          'Catat tanggal mulai tanam',
          Icons.event_available_rounded,
          AppColors.riceGreen,
          () {
            Navigator.pushNamed(context, Routes.inputJadwalTanam);
          },
        ),
        const SizedBox(height: 12),
        _buildJadwalCard(
          context,
          'Kalender Tanam',
          'Lihat jadwal tanaman',
          Icons.calendar_month_rounded,
          AppColors.riceYellow,
          () {
            Navigator.pushNamed(context, Routes.kalenderTanam);
          },
        ),
        const SizedBox(height: 24),
        _buildSectionHeading(
          'Fase pertumbuhan',
          'Progress dibuat lebih jelas dengan indikator visual yang lebih modern.',
        ),
        const SizedBox(height: 14),
        _buildGrowthPhase(
          'Tanam',
          'Fase awal penanaman',
          Icons.grain,
          AppColors.riceGreen,
          true,
        ),
        const SizedBox(height: 10),
        _buildGrowthPhase(
          'Vegetatif',
          'Pertumbuhan daun dan batang',
          Icons.grass,
          AppColors.riceYellow,
          true,
        ),
        const SizedBox(height: 10),
        _buildGrowthPhase(
          'Pembungaan',
          'Fase pembentukan bunga',
          Icons.local_florist,
          AppColors.riceOrange,
          false,
        ),
        const SizedBox(height: 10),
        _buildGrowthPhase(
          'Panen',
          'Siap untuk dipanen',
          Icons.agriculture,
          AppColors.riceGold,
          false,
        ),
      ],
    );
  }

  Widget _buildJadwalCard(
    BuildContext context,
    String title,
    String subtitle,
    IconData icon,
    Color color,
    VoidCallback onTap,
  ) {
    return _buildModernActionCard(
      title: title,
      subtitle: subtitle,
      icon: icon,
      color: color,
      onTap: onTap,
    );
  }

  Widget _buildGrowthPhase(
    String title,
    String description,
    IconData icon,
    Color color,
    bool isCompleted,
  ) {
    return _buildModernStatusTile(
      title: title,
      description: description,
      icon: icon,
      color: color,
      isActive: isCompleted,
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
    return _buildModernModuleLayout(
      title: 'Lapor Hama',
      subtitle:
          'Laporkan serangan hama dengan antarmuka yang lebih modern, jelas, dan tetap mempertahankan fitur yang ada.',
      icon: Icons.bug_report_rounded,
      badge: 'Laporan Cepat',
      children: [
        const SizedBox(height: 20),
        Row(
          children: [
            _buildQuickInfoChip(
              label: 'Status GPS',
              value: 'Aktif',
              icon: Icons.my_location_rounded,
            ),
            const SizedBox(width: 12),
            _buildQuickInfoChip(
              label: 'Respons wilayah',
              value: '< 1 jam',
              icon: Icons.flash_on_rounded,
              iconColor: AppColors.riceOrange,
            ),
          ],
        ),
        const SizedBox(height: 24),
        _buildSectionHeading(
          'Jenis hama',
          'Pilih jenis hama yang ingin dilaporkan. Interaksi dan pilihan tetap sama.',
        ),
        const SizedBox(height: 14),
        GridView.count(
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          crossAxisCount: 2,
          mainAxisSpacing: 12,
          crossAxisSpacing: 12,
          childAspectRatio: 1.15,
          children: _pestTypes.map((pest) {
            final isSelected = _selectedPestType == pest;
            return _buildModernPestCard(
              pest: pest,
              isSelected: isSelected,
              onTap: () {
                setState(() {
                  _selectedPestType = pest;
                });
              },
            );
          }).toList(),
        ),
        const SizedBox(height: 20),
        _buildUploadSection(),
        const SizedBox(height: 16),
        _buildLocationSection(),
        const SizedBox(height: 20),
        SizedBox(
          width: double.infinity,
          height: 54,
          child: ElevatedButton(
            onPressed: _selectedPestType != null ? () {} : null,
            style: ElevatedButton.styleFrom(
              backgroundColor: AppColors.riceGreen,
              foregroundColor: Colors.white,
              elevation: 0,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(18),
              ),
            ),
            child: const Text(
              'Kirim Laporan',
              style: TextStyle(fontWeight: FontWeight.w700),
            ),
          ),
        ),
        const SizedBox(height: 24),
        _buildSectionHeading(
          'Notifikasi hama terdekat',
          'Ringkasan dibuat lebih mudah dipahami tanpa mengubah isi informasinya.',
        ),
        const SizedBox(height: 14),
        _buildPestNotification(
          '🐛 Wereng',
          '📍 Desa Lemahabang',
          '2.5 km dari lahan Anda',
          Colors.orange,
        ),
        const SizedBox(height: 10),
        _buildPestNotification(
          '🦗 Walang Sangit',
          '📍 Desa Telukjambe',
          '4.2 km dari lahan Anda',
          Colors.red,
        ),
      ],
    );
  }

  Widget _buildUploadSection() {
    return _buildSoftCard(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Container(
                width: 42,
                height: 42,
                decoration: BoxDecoration(
                  color: AppColors.riceGreen.withOpacity(0.12),
                  borderRadius: BorderRadius.circular(14),
                ),
                child: const Icon(
                  Icons.photo_camera_rounded,
                  color: AppColors.riceGreen,
                  size: 22,
                ),
              ),
              const SizedBox(width: 12),
              const Text(
                'Upload Foto',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.bold,
                  color: Colors.black87,
                ),
              ),
            ],
          ),
          const SizedBox(height: 14),
          Container(
            width: double.infinity,
            height: 128,
            decoration: BoxDecoration(
              color: const Color(0xFFF8FBF7),
              borderRadius: BorderRadius.circular(18),
              border: Border.all(
                color: Colors.green.shade100,
                style: BorderStyle.solid,
              ),
            ),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Container(
                  width: 50,
                  height: 50,
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(16),
                  ),
                  child: Icon(
                    Icons.add_photo_alternate_rounded,
                    size: 28,
                    color: Colors.grey.shade500,
                  ),
                ),
                const SizedBox(height: 10),
                Text(
                  'Tap untuk upload foto',
                  style: TextStyle(
                    fontSize: 13,
                    color: Colors.grey.shade700,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLocationSection() {
    return _buildSoftCard(
      child: Row(
        children: [
          Container(
            width: 52,
            height: 52,
            decoration: BoxDecoration(
              color: AppColors.riceGreen.withOpacity(0.12),
              borderRadius: BorderRadius.circular(16),
            ),
            child: const Icon(
              Icons.location_on_rounded,
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
                    color: Colors.black87,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  'Sistem tetap memakai lokasi perangkat seperti sebelumnya.',
                  style: TextStyle(
                    fontSize: 12,
                    color: Colors.grey.shade600,
                    height: 1.4,
                  ),
                ),
                const SizedBox(height: 8),
                Row(
                  children: const [
                    Icon(
                      Icons.check_circle_rounded,
                      color: AppColors.riceGreen,
                      size: 16,
                    ),
                    SizedBox(width: 4),
                    Text(
                      'GPS Aktif',
                      style: TextStyle(
                        fontSize: 12,
                        color: AppColors.riceGreen,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildPestNotification(
    String pest,
    String location,
    String distance,
    Color color,
  ) {
    return _buildSoftCard(
      padding: const EdgeInsets.all(14),
      child: Row(
        children: [
          Container(
            width: 48,
            height: 48,
            decoration: BoxDecoration(
              color: color.withOpacity(0.14),
              borderRadius: BorderRadius.circular(16),
            ),
            child: Center(
              child: Text(
                pest.split(' ')[0],
                style: const TextStyle(fontSize: 20),
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
                    color: Colors.black87,
                  ),
                ),
                const SizedBox(height: 3),
                Text(
                  location,
                  style: TextStyle(fontSize: 12, color: Colors.grey.shade600),
                ),
                const SizedBox(height: 3),
                Text(
                  distance,
                  style: TextStyle(
                    fontSize: 11,
                    color: color,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
          ),
          Icon(Icons.warning_amber_rounded, color: color, size: 20),
        ],
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
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
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
                    style: const TextStyle(fontSize: 13, color: Colors.grey),
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
    return Scaffold(
      appBar: AppBar(title: const Text('Informasi Pupuk')),
      body: SingleChildScrollView(
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
                    const Icon(Icons.eco, size: 48, color: AppColors.riceWhite),
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
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
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
                    style: const TextStyle(fontSize: 14, color: Colors.grey),
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
                    style: const TextStyle(fontSize: 12, color: Colors.grey),
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
    return _buildModuleContent(context, 'Neraca Pangan', Icons.restaurant, [
      {'title': 'Produksi Beras', 'route': Routes.produksiBeras},
      {'title': 'Kebutuhan Beras', 'route': Routes.kebutuhanBeras},
      {'title': 'Surplus & Defisit', 'route': Routes.surplusDefisit},
      {
        'title': 'Prediksi Ketersediaan Pangan',
        'route': Routes.prediksiKetersediaan,
      },
    ]);
  }
}

class PetaPertanianModule extends StatelessWidget {
  const PetaPertanianModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(context, 'Peta Pertanian Karawang', Icons.map, [
      {'title': 'Sebaran Sawah', 'route': Routes.sebaranSawah},
      {'title': 'Sebaran Produksi', 'route': Routes.sebaranProduksi},
      {'title': 'Sebaran Panen', 'route': Routes.sebaranPanen},
      {
        'title': 'Wilayah Rawan Alih Fungsi',
        'route': Routes.wilayahRawanAlihFungsi,
      },
    ]);
  }
}

class LaporanModule extends StatelessWidget {
  const LaporanModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(context, 'Laporan', Icons.assessment, [
      {'title': 'Laporan Produksi', 'route': Routes.laporanProduksi},
      {'title': 'Laporan Panen', 'route': Routes.laporanPanen},
      {'title': 'Laporan Pupuk', 'route': Routes.laporanPupuk},
      {
        'title': 'Laporan Ketahanan Pangan',
        'route': Routes.laporanKetahananPangan,
      },
    ]);
  }
}

class PengaturanModule extends StatelessWidget {
  const PengaturanModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModuleContent(context, 'Pengaturan', Icons.settings, [
      {'title': 'Profil', 'route': Routes.profil},
      {'title': 'Kelola Pengguna', 'route': Routes.kelolaPengguna},
      {'title': 'Hak Akses', 'route': Routes.hakAkses},
    ]);
  }
}

class MenuModule extends StatelessWidget {
  const MenuModule({super.key});

  @override
  Widget build(BuildContext context) {
    return _buildModernModuleLayout(
      title: 'Akun',
      subtitle:
          'Area akun dibuat lebih rapi agar terasa konsisten dengan beranda tanpa mengubah menu yang sudah ada.',
      icon: Icons.person_rounded,
      badge: 'Profil Petani',
      children: [
        const SizedBox(height: 20),
        _buildSoftCard(
          child: Row(
            children: [
              Container(
                width: 64,
                height: 64,
                decoration: BoxDecoration(
                  gradient: const LinearGradient(
                    colors: [Color(0xFF43A047), Color(0xFF2E7D32)],
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                  ),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: const Icon(
                  Icons.person_rounded,
                  color: Colors.white,
                  size: 34,
                ),
              ),
              const SizedBox(width: 16),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text(
                      'Profil Pengguna',
                      style: TextStyle(
                        fontSize: 17,
                        fontWeight: FontWeight.bold,
                        color: Colors.black87,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      'Akses pengaturan akun dan preferensi aplikasi dari menu yang sama seperti sebelumnya.',
                      style: TextStyle(
                        fontSize: 13,
                        color: Colors.grey.shade600,
                        height: 1.45,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
        const SizedBox(height: 24),
        _buildSectionHeading(
          'Menu akun',
          'Semua fungsi tetap dipertahankan, hanya tampilan item dibuat lebih modern.',
        ),
        const SizedBox(height: 14),
        _buildMenuItem(
          context,
          'Pengaturan',
          Icons.settings_rounded,
          AppColors.riceBrown,
          const PengaturanModule(),
        ),
      ],
    );
  }

  Widget _buildMenuItem(
    BuildContext context,
    String title,
    IconData icon,
    Color color,
    Widget screen,
  ) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: _buildModernActionCard(
        title: title,
        subtitle: 'Kelola preferensi dan informasi akun Anda',
        icon: icon,
        color: color,
        onTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(builder: (context) => screen),
          );
        },
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
                Icon(icon, size: 48, color: AppColors.riceWhite),
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
        ...items.map(
          (item) => Card(
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
          ),
        ),
      ],
    ),
  );
}
