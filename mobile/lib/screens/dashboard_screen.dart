import 'dart:io' show File;
import 'package:flutter/foundation.dart' show kIsWeb;
import 'package:image_picker/image_picker.dart';
import 'package:flutter/material.dart';
import '../utils/app_colors.dart';
import '../utils/routes.dart';
import '../utils/api_service.dart';

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
  IconData? icon,
  Color iconColor = AppColors.riceGreen,
}) {
  return Expanded(
    child: _buildSoftCard(
      padding: const EdgeInsets.all(14),
      color: const Color(0xFFF9FCF8),
      child: Row(
        children: [
          if (icon != null) ...[
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
          ],
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

class HomeDashboard extends StatefulWidget {
  const HomeDashboard({super.key});

  @override
  State<HomeDashboard> createState() => _HomeDashboardState();
}

class _HomeDashboardState extends State<HomeDashboard> {
  String _userName = 'Petani';
  String _lahanAktif = '0';

  @override
  void initState() {
    super.initState();
    _loadDashboardData();
  }

  Future<void> _loadDashboardData() async {
    final profile = await ApiService.getUserProfile();
    if (mounted) {
      setState(() {
        _userName = profile['name'] ?? 'Petani';
        _lahanAktif = profile['lahan_aktif'] ?? '0';
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        _buildTopHeader(context),
        Expanded(
          child: SingleChildScrollView(
            padding: const EdgeInsets.fromLTRB(20, 16, 20, 30),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                _buildWelcomeHeroCard(),
                const SizedBox(height: 20),
                IntrinsicHeight(
                  child: Row(
                    crossAxisAlignment: CrossAxisAlignment.stretch,
                    children: [
                      Expanded(
                        flex: 5,
                        child: _buildTotalLahanCard(),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        flex: 6,
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            _buildHorizontalMiniCard(
                              'Jadwal Tanam',
                              Icons.calendar_month_rounded,
                              Colors.green,
                              () {
                                Navigator.pushNamed(context, Routes.kalenderTanam);
                              },
                            ),
                            const SizedBox(height: 12),
                            _buildHorizontalMiniCard(
                              'Status Panen',
                              Icons.grass_rounded,
                              Colors.orange,
                              () {
                                Navigator.pushNamed(context, Routes.laporanPanen);
                              },
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 16),
                _buildListTileCard(
                  'Cuaca Hari Ini',
                  '28°C',
                  'Karawang',
                  'Cerah Berawan',
                  Icons.cloud_queue,
                  Colors.blue,
                  onTap: () {
                    showModalBottomSheet(
                      context: context,
                      shape: const RoundedRectangleBorder(
                        borderRadius: BorderRadius.vertical(
                          top: Radius.circular(24),
                        ),
                      ),
                      builder: (context) {
                        return Padding(
                          padding: const EdgeInsets.fromLTRB(20, 20, 20, 28),
                          child: Column(
                            mainAxisSize: MainAxisSize.min,
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              const Text(
                                'Prakiraan Cuaca',
                                style: TextStyle(
                                  fontSize: 18,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.black87,
                                ),
                              ),
                              const SizedBox(height: 12),
                              const Text(
                                'Karawang, Jawa Barat',
                                style: TextStyle(
                                  fontSize: 14,
                                  color: Colors.black54,
                                ),
                              ),
                              const SizedBox(height: 16),
                              Row(
                                children: const [
                                  Icon(Icons.wb_sunny, color: Colors.orange, size: 36),
                                  SizedBox(width: 12),
                                  Expanded(
                                    child: Text(
                                      'Cerah berawan • 28°C\nKelembapan 72% • Angin 10 km/jam',
                                      style: TextStyle(fontSize: 14, color: Colors.black87),
                                    ),
                                  ),
                                ],
                              ),
                              const SizedBox(height: 18),
                              Wrap(
                                spacing: 8,
                                runSpacing: 8,
                                children: const [
                                  Chip(label: Text('08.00 - Cerah')),
                                  Chip(label: Text('12.00 - Panas')),
                                  Chip(label: Text('16.00 - Berawan')),
                                ],
                              ),
                            ],
                          ),
                        );
                      },
                    );
                  },
                ),
                const SizedBox(height: 12),
                _buildListTileCard(
                  'Musim Tanam',
                  'Optimal',
                  'Mulai',
                  '12 Juli 2026',
                  Icons.spa,
                  Colors.green,
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => const RekomendasiBudidayaModule(),
                      ),
                    );
                  },
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildTopHeader(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 10,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      padding: const EdgeInsets.fromLTRB(20, 50, 20, 16),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              Container(
                width: 38,
                height: 38,
                decoration: BoxDecoration(
                  color: Colors.green.shade50,
                  shape: BoxShape.circle,
                ),
                child: Center(
                  child: Image.asset(
                    'assets/images/logo_padi_dashboard.png',
                    width: 22,
                    height: 22,
                    fit: BoxFit.contain,
                  ),
                ),
              ),
              const SizedBox(width: 10),
              const Text(
                'PADIKU',
                style: TextStyle(
                  color: Color(0xFF2E7D32),
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                  letterSpacing: 1.2,
                ),
              ),
            ],
          ),
          Row(
            children: [
              IconButton(
                icon: const Icon(
                  Icons.support_agent_rounded,
                  color: Colors.black54,
                  size: 24,
                ),
                tooltip: 'Pusat Bantuan',
                onPressed: () {
                  Navigator.pushNamed(context, Routes.pusatBantuan);
                },
              ),
              const SizedBox(width: 4),
              IconButton(
                icon: const Icon(
                  Icons.notifications_none_rounded,
                  color: Colors.black54,
                  size: 26,
                ),
                tooltip: 'Notifikasi',
                onPressed: () {},
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildWelcomeHeroCard() {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(24),
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFF064E3B), Color(0xFF0F5132), Color(0xFF14532D)],
        ),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF064E3B).withOpacity(0.2),
            blurRadius: 15,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Stack(
        children: [
          Positioned.fill(
            child: ClipRRect(
              borderRadius: BorderRadius.circular(24),
              child: Opacity(
                opacity: 0.15,
                child: Image.asset(
                  'assets/images/Farmers harvesting rice in Vietnam_.jpeg',
                  fit: BoxFit.cover,
                ),
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.all(22),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                  decoration: BoxDecoration(
                    color: Colors.white.withOpacity(0.12),
                    borderRadius: BorderRadius.circular(30),
                    border: Border.all(
                      color: Colors.white.withOpacity(0.15),
                      width: 1,
                    ),
                  ),
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Container(
                        width: 6,
                        height: 6,
                        decoration: const BoxDecoration(
                          color: Color(0xFFFFC107),
                          shape: BoxShape.circle,
                        ),
                      ),
                      const SizedBox(width: 6),
                      const Text(
                        'PETANI MANDIRI',
                        style: TextStyle(
                          color: Color(0xFFA3E635),
                          fontSize: 10,
                          fontWeight: FontWeight.bold,
                          letterSpacing: 1,
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 18),
                Text(
                  'Selamat Datang,\n$_userName',
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 22,
                    fontWeight: FontWeight.w800,
                    height: 1.25,
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(height: 10),
                Text(
                  'Platform Digital Pertanian Kabupaten Karawang untuk monitoring lahan, produksi, petani, dan sistem peringatan dini.',
                  style: TextStyle(
                    color: Colors.white.withOpacity(0.85),
                    fontSize: 12,
                    height: 1.45,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTotalLahanCard() {
    return Container(
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
        border: Border.all(color: Colors.green.shade50),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Text(
                'Total Lahan',
                style: TextStyle(
                  color: Colors.black54,
                  fontSize: 12,
                  fontWeight: FontWeight.w600,
                ),
              ),
              const Text(
                'Aktif',
                style: TextStyle(
                  color: Colors.black54,
                  fontSize: 12,
                  fontWeight: FontWeight.w600,
                ),
              ),
              const SizedBox(height: 8),
              Row(
                crossAxisAlignment: CrossAxisAlignment.baseline,
                textBaseline: TextBaseline.alphabetic,
                children: [
                  Text(
                    _lahanAktif,
                    style: const TextStyle(
                      fontSize: 28,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFF2E7D32),
                    ),
                  ),
                  const SizedBox(width: 2),
                  const Text(
                    ' Ha',
                    style: TextStyle(
                      fontSize: 12,
                      color: Colors.black87,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ],
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildHorizontalMiniCard(
    String title,
    IconData icon,
    Color color,
    VoidCallback onTap,
  ) {
    return Expanded(
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(16),
        child: Container(
          padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(16),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.02),
                blurRadius: 8,
                offset: const Offset(0, 3),
              ),
            ],
            border: Border.all(color: Colors.grey.shade100),
          ),
          child: Row(
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: color.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(10),
                ),
                child: Icon(
                  icon,
                  color: color,
                  size: 20,
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Text(
                  title,
                  style: const TextStyle(
                    fontSize: 13,
                    fontWeight: FontWeight.bold,
                    color: Colors.black87,
                  ),
                ),
              ),
              const Icon(
                Icons.chevron_right_rounded,
                color: Colors.black38,
                size: 18,
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildGridCard(
    String title,
    String subtitle,
    IconData icon,
    Color color, {
    VoidCallback? onTap,
  }) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(16),
        splashColor: Colors.white.withOpacity(0.25),
        highlightColor: Colors.white.withOpacity(0.15),
        child: Ink(
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
        ),
      ),
    );
  }

  Widget _buildListTileCard(
    String title,
    String valueLeft,
    String labelRight,
    String valueRight,
    IconData icon,
    Color iconColor, {
    VoidCallback? onTap,
  }) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(16),
        splashColor: Colors.white.withOpacity(0.25),
        highlightColor: Colors.white.withOpacity(0.15),
        child: Ink(
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
            ],
          ),
        ),
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

class DataLahanModule extends StatefulWidget {
  const DataLahanModule({super.key});

  @override
  State<DataLahanModule> createState() => _DataLahanModuleState();
}

class _DataLahanModuleState extends State<DataLahanModule> {
  String _lahanAktif = '0';
  List<dynamic> _landList = [];
  bool _isLoading = false;
  bool _isSaving = false;
  int? _expandedIndex;

  final _namaController = TextEditingController();
  final _luasController = TextEditingController();
  final _kecamatanController = TextEditingController();
  final _desaController = TextEditingController();
  final _varietasController = TextEditingController(text: 'Ciherang');

  String _selectedSatuan = 'Hektar';
  final List<String> _satuanOptions = ['Hektar', 'Meter Persegi (m²)'];

  String _selectedPengairan = 'Irigasi Teknis';
  final List<String> _pengairanOptions = ['Irigasi Teknis', 'Tadah Hujan', 'Sumur Bor/Pompa'];

  String _selectedTanah = 'Gembur';
  final List<String> _tanahOptions = ['Gembur', 'Liat/Lempung', 'Gambut', 'Berpasir'];

  String _selectedKepemilikan = 'Milik Pribadi';
  final List<String> _kepemilikanOptions = ['Milik Pribadi', 'Sewa', 'Bagi Hasil'];

  @override
  void initState() {
    super.initState();
    _loadLahanData();
  }

  @override
  void dispose() {
    _namaController.dispose();
    _luasController.dispose();
    _kecamatanController.dispose();
    _desaController.dispose();
    _varietasController.dispose();
    super.dispose();
  }

  Future<void> _loadLahanData() async {
    if (!mounted) return;
    setState(() {
      _isLoading = true;
    });
    try {
      final profile = await ApiService.getUserProfile();
      final list = await ApiService.getPlantings();
      if (mounted) {
        setState(() {
          _lahanAktif = profile['lahan_aktif'] ?? '0';
          _landList = list;
          _isLoading = false;
        });
      }
    } catch (_) {
      if (mounted) {
        setState(() {
          _isLoading = false;
        });
      }
    }
  }

  Future<void> _saveLahan() async {
    if (_namaController.text.trim().isEmpty || _luasController.text.trim().isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Nama Lahan dan Luas Lahan wajib diisi!'),
          behavior: SnackBarBehavior.floating,
          backgroundColor: Color(0xFFEF5350),
        ),
      );
      return;
    }

    setState(() {
      _isSaving = true;
    });

    final double luas = double.tryParse(_luasController.text) ?? 0.0;
    final double areaHectares = _selectedSatuan == 'Hektar' ? luas : (luas / 10000.0);
    final notes = 'Pengairan: $_selectedPengairan | Tanah: $_selectedTanah | Status: $_selectedKepemilikan';

    final data = {
      'location_name': _namaController.text,
      'area_hectares': areaHectares,
      'planting_date': DateTime.now().toIso8601String().split('T')[0],
      'rice_variety': _varietasController.text.isNotEmpty ? _varietasController.text : 'Ciherang',
      'expected_harvest_date': DateTime.now().add(const Duration(days: 90)).toIso8601String().split('T')[0],
      'notes': notes,
      'latitude': -6.32,
      'longitude': 107.33,
    };

    final result = await ApiService.submitPlanting(data);

    if (mounted) {
      setState(() {
        _isSaving = false;
      });

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(result['success'] ? 'Lahan berhasil ditambahkan!' : (result['message'] ?? 'Gagal menyimpan lahan')),
          behavior: SnackBarBehavior.floating,
          backgroundColor: result['success'] ? AppColors.riceGreen : const Color(0xFFEF5350),
        ),
      );

      if (result['success']) {
        _namaController.clear();
        _luasController.clear();
        _kecamatanController.clear();
        _desaController.clear();
        _loadLahanData();
      }
    }
  }

  Future<void> _deleteLahan(int id) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Hapus Lahan'),
        content: const Text('Apakah Anda yakin ingin menghapus lahan ini dari sistem?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context, false),
            child: const Text('Batal', style: TextStyle(color: Colors.grey)),
          ),
          TextButton(
            onPressed: () => Navigator.pop(context, true),
            child: const Text('Hapus', style: TextStyle(color: Colors.red)),
          ),
        ],
      ),
    );

    if (confirm != true) return;

    setState(() {
      _isLoading = true;
    });

    final result = await ApiService.deletePlanting(id);

    if (mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(result['message'] ?? 'Status penghapusan selesai'),
          behavior: SnackBarBehavior.floating,
          backgroundColor: result['success'] ? AppColors.riceGreen : const Color(0xFFEF5350),
        ),
      );
      _loadLahanData();
    }
  }

  InputDecoration _inputDecoration({
    required String label,
    required IconData icon,
  }) {
    return InputDecoration(
      labelText: label,
      prefixIcon: Icon(icon, color: AppColors.riceGreen, size: 20),
      filled: true,
      fillColor: const Color(0xFFF8FBF7),
      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: BorderSide(color: Colors.green.shade50),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: BorderSide(color: Colors.green.shade100),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.riceGreen, width: 1.5),
      ),
    );
  }

  Widget _buildTopHeader(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 10,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      padding: const EdgeInsets.fromLTRB(20, 50, 20, 16),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              Container(
                width: 38,
                height: 38,
                decoration: BoxDecoration(
                  color: Colors.green.shade50,
                  shape: BoxShape.circle,
                ),
                child: Center(
                  child: Image.asset(
                    'assets/images/logo_padi_dashboard.png',
                    width: 22,
                    height: 22,
                    fit: BoxFit.contain,
                  ),
                ),
              ),
              const SizedBox(width: 10),
              const Text(
                'PADIKU',
                style: TextStyle(
                  color: Color(0xFF2E7D32),
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                  letterSpacing: 1.2,
                ),
              ),
            ],
          ),
          Row(
            children: [
              IconButton(
                icon: const Icon(
                  Icons.support_agent_rounded,
                  color: Colors.black54,
                ),
                onPressed: () {},
              ),
              IconButton(
                icon: const Icon(
                  Icons.notifications_outlined,
                  color: Colors.black54,
                ),
                onPressed: () {},
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildTopBanner() {
    return Container(
      width: double.infinity,
      height: 120,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(24),
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFF0F5132), Color(0xFF198754)],
        ),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF0F5132).withOpacity(0.2),
            blurRadius: 15,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Stack(
        children: [
          Positioned.fill(
            child: ClipRRect(
              borderRadius: BorderRadius.circular(24),
              child: Opacity(
                opacity: 0.15,
                child: Image.asset(
                  'assets/images/Farmers harvesting rice in Vietnam_.jpeg',
                  fit: BoxFit.cover,
                ),
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 22, vertical: 20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                const Text(
                  'Data Lahan',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 22,
                    fontWeight: FontWeight.w800,
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(height: 6),
                Text(
                  'Pantau dan kelola lahan pertanian Anda secara terintegrasi.',
                  style: TextStyle(
                    color: Colors.white.withOpacity(0.85),
                    fontSize: 11,
                    height: 1.3,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildInlineForm() {
    return Card(
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      elevation: 0,
      color: Colors.white,
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Tambah Lahan Baru',
              style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.black87),
            ),
            const SizedBox(height: 16),
            TextFormField(
              controller: _namaController,
              decoration: _inputDecoration(label: 'Nama/Identitas Lahan', icon: Icons.info_outline),
            ),
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: TextFormField(
                    controller: _luasController,
                    keyboardType: const TextInputType.numberWithOptions(decimal: true),
                    decoration: _inputDecoration(label: 'Luas Lahan', icon: Icons.straighten_rounded),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: DropdownButtonFormField<String>(
                    value: _selectedSatuan,
                    items: _satuanOptions.map((item) => DropdownMenuItem(value: item, child: Text(item))).toList(),
                    onChanged: (val) {
                      if (val != null) {
                        setState(() {
                          _selectedSatuan = val;
                        });
                      }
                    },
                    decoration: _inputDecoration(label: 'Satuan', icon: Icons.ad_units_rounded),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: TextFormField(
                    controller: _kecamatanController,
                    decoration: _inputDecoration(label: 'Kecamatan', icon: Icons.map_outlined),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: TextFormField(
                    controller: _desaController,
                    decoration: _inputDecoration(label: 'Desa/Kelurahan', icon: Icons.location_on_outlined),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            DropdownButtonFormField<String>(
              value: _selectedPengairan,
              items: _pengairanOptions.map((item) => DropdownMenuItem(value: item, child: Text(item))).toList(),
              onChanged: (val) {
                if (val != null) {
                  setState(() {
                    _selectedPengairan = val;
                  });
                }
              },
              decoration: _inputDecoration(label: 'Jenis Pengairan', icon: Icons.water_drop_outlined),
            ),
            const SizedBox(height: 12),
            DropdownButtonFormField<String>(
              value: _selectedTanah,
              items: _tanahOptions.map((item) => DropdownMenuItem(value: item, child: Text(item))).toList(),
              onChanged: (val) {
                if (val != null) {
                  setState(() {
                    _selectedTanah = val;
                  });
                }
              },
              decoration: _inputDecoration(label: 'Kondisi Tanah', icon: Icons.eco_outlined),
            ),
            const SizedBox(height: 12),
            DropdownButtonFormField<String>(
              value: _selectedKepemilikan,
              items: _kepemilikanOptions.map((item) => DropdownMenuItem(value: item, child: Text(item))).toList(),
              onChanged: (val) {
                if (val != null) {
                  setState(() {
                    _selectedKepemilikan = val;
                  });
                }
              },
              decoration: _inputDecoration(label: 'Status Kepemilikan', icon: Icons.business_center_outlined),
            ),
            const SizedBox(height: 12),
            TextFormField(
              controller: _varietasController,
              decoration: _inputDecoration(label: 'Varietas Padi', icon: Icons.grass_rounded),
            ),
            const SizedBox(height: 16),
            SizedBox(
              width: double.infinity,
              height: 50,
              child: ElevatedButton(
                onPressed: _isSaving ? null : _saveLahan,
                style: ElevatedButton.styleFrom(
                  backgroundColor: AppColors.riceGreen,
                  foregroundColor: Colors.white,
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                  elevation: 0,
                ),
                child: _isSaving
                    ? const SizedBox(
                        width: 20,
                        height: 20,
                        child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                      )
                    : const Text(
                        'Tambahkan Lahan',
                        style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
                      ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildLandList() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Daftar Lahan Pertanian',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.black87),
        ),
        const SizedBox(height: 12),
        if (_isLoading)
          const Card(
            color: Colors.white,
            child: Padding(
              padding: EdgeInsets.all(24),
              child: Center(
                child: CircularProgressIndicator(color: AppColors.riceGreen),
              ),
            ),
          )
        else if (_landList.isEmpty)
          Card(
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
            color: Colors.white,
            child: const Padding(
              padding: EdgeInsets.all(24),
              child: Center(
                child: Text(
                  'Belum ada lahan terdaftar.\nSilakan gunakan form di atas untuk menambahkan lahan baru.',
                  textAlign: TextAlign.center,
                  style: TextStyle(color: Colors.grey, fontSize: 13, height: 1.4),
                ),
              ),
            ),
          )
        else
          ListView.separated(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            itemCount: _landList.length,
            separatorBuilder: (context, index) => const SizedBox(height: 12),
            itemBuilder: (context, index) {
              final land = _landList[index];
              final isExpanded = _expandedIndex == index;
              final String name = land['location_name'] ?? 'Lahan Tanpa Nama';
              final double area = double.tryParse(land['area_hectares'].toString()) ?? 0.0;
              final String notes = land['notes'] ?? '';

              String pengairan = 'Irigasi Teknis';
              String tanah = 'Gembur';
              String kepemilikan = 'Milik Pribadi';
              
              if (notes.isNotEmpty) {
                final parts = notes.split('|');
                for (var part in parts) {
                  if (part.contains('Pengairan:')) {
                    pengairan = part.replaceAll('Pengairan:', '').trim();
                  } else if (part.contains('Tanah:')) {
                    tanah = part.replaceAll('Tanah:', '').trim();
                  } else if (part.contains('Status:')) {
                    kepemilikan = part.replaceAll('Status:', '').trim();
                  }
                }
              }

              return Card(
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
                color: Colors.white,
                elevation: 0,
                child: Column(
                  children: [
                    ListTile(
                      onTap: () {
                        setState(() {
                          _expandedIndex = isExpanded ? null : index;
                        });
                      },
                      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                      title: Text(
                        name,
                        style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 15, color: Colors.black87),
                      ),
                      subtitle: Padding(
                        padding: const EdgeInsets.only(top: 4),
                        child: Text(
                          'Kecamatan: Cikampek (Desa Terdaftar)',
                          style: TextStyle(fontSize: 12, color: Colors.grey.shade500),
                        ),
                      ),
                      trailing: Row(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          Container(
                            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                            decoration: BoxDecoration(
                              color: AppColors.riceGreen.withAlpha(25),
                              borderRadius: BorderRadius.circular(8),
                            ),
                            child: Text(
                              '${area.toStringAsFixed(2)} Ha',
                              style: const TextStyle(
                                fontWeight: FontWeight.bold,
                                color: AppColors.riceGreen,
                                fontSize: 12,
                              ),
                            ),
                          ),
                          const SizedBox(width: 8),
                          Icon(
                            isExpanded ? Icons.expand_less_rounded : Icons.expand_more_rounded,
                            color: Colors.grey,
                          ),
                        ],
                      ),
                    ),
                    if (isExpanded) ...[
                      const Divider(height: 1, indent: 16, endIndent: 16),
                      Padding(
                        padding: const EdgeInsets.all(16),
                        child: Column(
                          children: [
                            _buildInfoRow('Varietas Padi', land['rice_variety'] ?? 'Ciherang'),
                            const SizedBox(height: 10),
                            _buildInfoRow('Tanggal Tanam', land['planting_date']?.toString().split('T')[0] ?? '-'),
                            const SizedBox(height: 10),
                            _buildInfoRow('Jenis Pengairan', pengairan),
                            const SizedBox(height: 10),
                            _buildInfoRow('Kondisi Tanah', tanah),
                            const SizedBox(height: 10),
                            _buildInfoRow('Status Kepemilikan', kepemilikan),
                            const SizedBox(height: 12),
                            const Divider(height: 1),
                            Align(
                              alignment: Alignment.centerRight,
                              child: TextButton.icon(
                                onPressed: () => _deleteLahan(land['id']),
                                icon: const Icon(Icons.delete_outline, size: 18),
                                label: const Text('Hapus Lahan', style: TextStyle(fontWeight: FontWeight.bold)),
                                style: TextButton.styleFrom(
                                  foregroundColor: Colors.red.shade700,
                                ),
                              ),
                            ),
                          ],
                        ),
                      )
                    ]
                  ],
                ),
              );
            },
          ),
      ],
    );
  }

  Widget _buildInfoRow(String label, String value) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(
          label,
          style: TextStyle(color: Colors.grey.shade600, fontSize: 13),
        ),
        Text(
          value,
          style: const TextStyle(fontWeight: FontWeight.bold, color: Colors.black87, fontSize: 13),
        ),
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        _buildTopHeader(context),
        Expanded(
          child: SingleChildScrollView(
            padding: const EdgeInsets.fromLTRB(20, 16, 20, 30),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                _buildTopBanner(),
                const SizedBox(height: 20),
                
                Row(
                  children: [
                    _buildQuickInfoChip(
                      label: 'Lahan aktif',
                      value: '$_lahanAktif Hektar',
                    ),
                  ],
                ),
                const SizedBox(height: 20),

                _buildInlineForm(),
                const SizedBox(height: 20),

                _buildLandList(),
              ],
            ),
          ),
        ),
      ],
    );
  }
}

class JadwalTanamModule extends StatefulWidget {
  const JadwalTanamModule({super.key});

  @override
  State<JadwalTanamModule> createState() => _JadwalTanamModuleState();
}

class _JadwalTanamModuleState extends State<JadwalTanamModule> {
  DateTime _selectedDate = DateTime.now();
  bool _isLoading = false;
  bool _isSubmitting = false;
  bool _isConflict = false;
  String _checkMessage = 'Memeriksa jadwal tanam...';
  String? _expectedHarvestDate;
  String? _recommendationDate;

  String _selectedLahan = 'Sawah Blok A';
  final List<String> _lahanOptions = [
    'Sawah Blok A',
    'Sawah Blok Utara',
    'Lahan Belakang Rumah'
  ];

  final List<String> _metodeOptions = [
    'Tandur (manual)',
    'Jajar Legowo',
    'Tabur benih',
    'Mesin tanam',
  ];
  String _selectedMetode = 'Tandur (manual)';
  
  late final TextEditingController _varietasController;
  late final TextEditingController _luasController;

  // State untuk To-Do List
  final List<Map<String, dynamic>> _tasks = [
    {
      'title': 'Pemupukan Tahap 1',
      'subtitle': 'Hari ke-15 (Gunakan Urea)',
      'isDone': true,
    },
    {
      'title': 'Pemanfaatan Mulsa Jerami',
      'subtitle': 'Tutup permukaan tanah dengan jerami untuk menjaga kelembaban dan menekan gulma.',
      'isDone': false,
    },
    {
      'title': 'Penyiangan Gulma',
      'subtitle': 'Hari ke-30 (Pembersihan lahan)',
      'isDone': false,
    },
    {
      'title': 'Pengeringan Lahan',
      'subtitle': 'Menjelang Panen',
      'isDone': false,
    },
  ];

  @override
  void initState() {
    super.initState();
    _varietasController = TextEditingController(text: 'Ciherang');
    _luasController = TextEditingController(text: '1.0');
    // Run conflict check for initial date
    _checkConflict();
  }

  @override
  void dispose() {
    _varietasController.dispose();
    _luasController.dispose();
    super.dispose();
  }

  Future<void> _checkConflict() async {
    setState(() {
      _isLoading = true;
    });
    
    final dateStr = "${_selectedDate.year}-${_selectedDate.month.toString().padLeft(2, '0')}-${_selectedDate.day.toString().padLeft(2, '0')}";
    final result = await ApiService.checkPlantingConflict(dateStr);
    
    if (mounted) {
      setState(() {
        _isLoading = false;
        if (result['success']) {
          _isConflict = result['conflict'] ?? false;
          _checkMessage = result['message'] ?? '';
          _expectedHarvestDate = result['expected_harvest_date'];
          _recommendationDate = result['recommendation_date'];
        } else {
          _isConflict = true;
          _checkMessage = result['message'] ?? 'Gagal memeriksa konflik';
          _expectedHarvestDate = null;
          _recommendationDate = null;
        }
      });
    }
  }

  void _shiftWeek(int weeks) {
    setState(() {
      _selectedDate = _selectedDate.add(Duration(days: weeks * 7));
    });
    _checkConflict();
  }

  Future<void> _selectDateViaPicker() async {
    final picked = await showDatePicker(
      context: context,
      initialDate: _selectedDate,
      firstDate: DateTime.now().subtract(const Duration(days: 365)),
      lastDate: DateTime.now().add(const Duration(days: 365)),
    );
    if (picked != null) {
      setState(() {
        _selectedDate = picked;
      });
      _checkConflict();
    }
  }

  String _getNamaBulan(int month) {
    const months = [
      'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    return months[month - 1];
  }

  String _formatHarvestDate(String dateStr) {
    try {
      final parts = dateStr.split('-');
      if (parts.length == 3) {
        final year = parts[0];
        final monthIdx = int.parse(parts[1]);
        final day = int.parse(parts[2]);
        return "$day ${_getNamaBulan(monthIdx)} $year";
      }
      return dateStr;
    } catch (_) {
      return dateStr;
    }
  }

  Future<void> _savePlanting() async {
    setState(() {
      _isSubmitting = true;
    });

    final dateStr = "${_selectedDate.year}-${_selectedDate.month.toString().padLeft(2, '0')}-${_selectedDate.day.toString().padLeft(2, '0')}";
    final data = {
      'location_name': _selectedLahan,
      'area_hectares': double.tryParse(_luasController.text) ?? 1.0,
      'planting_date': dateStr,
      'expected_harvest_date': _expectedHarvestDate,
      'rice_variety': _varietasController.text.isNotEmpty ? _varietasController.text : 'Ciherang',
      'notes': 'Metode: $_selectedMetode',
      'latitude': -6.32,
      'longitude': 107.33,
    };

    final result = await ApiService.submitPlanting(data);

    if (mounted) {
      setState(() {
        _isSubmitting = false;
      });

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(result['message'] ?? 'Berhasil disimpan!'),
          behavior: SnackBarBehavior.floating,
          backgroundColor: result['success'] ? AppColors.riceGreen : const Color(0xFFEF5350),
        ),
      );
    }
  }

  InputDecoration _inputDecoration({
    required String label,
    required IconData icon,
  }) {
    return InputDecoration(
      labelText: label,
      prefixIcon: Icon(icon, color: AppColors.riceGreen, size: 20),
      filled: true,
      fillColor: const Color(0xFFF8FBF7),
      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: BorderSide(color: Colors.green.shade50),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: BorderSide(color: Colors.green.shade100),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.riceGreen, width: 1.5),
      ),
    );
  }

  Widget _buildTopHeader(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 10,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      padding: const EdgeInsets.fromLTRB(20, 50, 20, 16),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              Container(
                width: 38,
                height: 38,
                decoration: BoxDecoration(
                  color: Colors.green.shade50,
                  shape: BoxShape.circle,
                ),
                child: Center(
                  child: Image.asset(
                    'assets/images/logo_padi_dashboard.png',
                    width: 22,
                    height: 22,
                    fit: BoxFit.contain,
                  ),
                ),
              ),
              const SizedBox(width: 10),
              const Text(
                'PADIKU',
                style: TextStyle(
                  color: Color(0xFF2E7D32),
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                  letterSpacing: 1.2,
                ),
              ),
            ],
          ),
          Row(
            children: [
              IconButton(
                icon: const Icon(
                  Icons.support_agent_rounded,
                  color: Colors.black54,
                ),
                onPressed: () {},
              ),
              IconButton(
                icon: const Icon(
                  Icons.notifications_outlined,
                  color: Colors.black54,
                ),
                onPressed: () {},
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildTopBanner() {
    return Container(
      width: double.infinity,
      height: 120,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(24),
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFF0F5132), Color(0xFF198754)],
        ),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF0F5132).withOpacity(0.2),
            blurRadius: 15,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Stack(
        children: [
          Positioned.fill(
            child: ClipRRect(
              borderRadius: BorderRadius.circular(24),
              child: Opacity(
                opacity: 0.15,
                child: Image.asset(
                  'assets/images/Farmers harvesting rice in Vietnam_.jpeg',
                  fit: BoxFit.cover,
                ),
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 22, vertical: 20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                const Text(
                  'Jadwal Tanam',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 22,
                    fontWeight: FontWeight.w800,
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(height: 6),
                Text(
                  'Jadwal Tanam Ikuti Fase pertumbuhan tanaman dengan tampilan yang lebih informatif dan nyaman dilihat.',
                  style: TextStyle(
                    color: Colors.white.withOpacity(0.85),
                    fontSize: 11,
                    height: 1.3,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildValidationCard() {
    if (_isLoading) {
      return const Card(
        color: Colors.white,
        child: Padding(
          padding: EdgeInsets.all(16),
          child: Center(
            child: SizedBox(
              width: 24,
              height: 24,
              child: CircularProgressIndicator(strokeWidth: 2, color: AppColors.riceGreen),
            ),
          ),
        ),
      );
    }

    final isConflict = _isConflict;
    final color = isConflict ? const Color(0xFFFFF1F0) : const Color(0xFFF6FFED);
    final borderColor = isConflict ? const Color(0xFFFFA39E) : const Color(0xFFB7EB8F);
    final textColor = isConflict ? const Color(0xFFCF1322) : const Color(0xFF389E0D);

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: color,
        border: Border.all(color: borderColor),
        borderRadius: BorderRadius.circular(16),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Icon(
                isConflict ? Icons.cancel_rounded : Icons.check_circle_rounded,
                color: textColor,
                size: 22,
              ),
              const SizedBox(width: 10),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      isConflict ? 'Jadwal Tanam Ditolak' : 'Jadwal Tanam Diizinkan',
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 15,
                        color: textColor,
                      ),
                    ),
                    const SizedBox(height: 6),
                    Text(
                      _checkMessage,
                      style: TextStyle(
                        fontSize: 13,
                        color: isConflict ? const Color(0xFFA8071A) : const Color(0xFF237804),
                        height: 1.4,
                      ),
                    ),
                    if (isConflict && _recommendationDate != null) ...[
                      const SizedBox(height: 8),
                      Text(
                        '💡 Saran tanggal aman: ${_formatHarvestDate(_recommendationDate!)}',
                        style: const TextStyle(
                          fontSize: 12,
                          fontWeight: FontWeight.bold,
                          color: Color(0xFFA8071A),
                        ),
                      ),
                    ],
                  ],
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildDateSelectorCard() {
    return Card(
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      elevation: 0,
      color: Colors.white,
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              'Rencana Tanggal Tanam',
              style: TextStyle(
                fontWeight: FontWeight.bold,
                fontSize: 15,
                color: Colors.grey.shade800,
              ),
            ),
            const SizedBox(height: 12),
            Row(
              children: [
                IconButton(
                  icon: const Icon(Icons.remove_circle_outline, color: AppColors.riceGreen, size: 28),
                  onPressed: () => _shiftWeek(-1),
                  tooltip: 'Geser Mundur 1 Minggu',
                ),
                Expanded(
                  child: InkWell(
                    onTap: _selectDateViaPicker,
                    child: Container(
                      padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 16),
                      decoration: BoxDecoration(
                        border: Border.all(color: Colors.green.shade100),
                        borderRadius: BorderRadius.circular(12),
                        color: const Color(0xFFF8FBF7),
                      ),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          const Icon(Icons.calendar_today_rounded, size: 18, color: AppColors.riceGreen),
                          const SizedBox(width: 8),
                          Text(
                            "${_selectedDate.day} ${_getNamaBulan(_selectedDate.month)} ${_selectedDate.year}",
                            style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
                          ),
                        ],
                      ),
                    ),
                  ),
                ),
                IconButton(
                  icon: const Icon(Icons.add_circle_outline, color: AppColors.riceGreen, size: 28),
                  onPressed: () => _shiftWeek(1),
                  tooltip: 'Geser Maju 1 Minggu',
                ),
              ],
            ),
            const SizedBox(height: 8),
            Center(
              child: Text(
                'Petunjuk: Tekan tombol (-) dan (+) untuk menggeser jadwal per minggu.',
                style: TextStyle(fontSize: 11, color: Colors.grey.shade500),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildInlineForm() {
    return Card(
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      elevation: 0,
      color: Colors.white,
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            DropdownButtonFormField<String>(
              value: _selectedLahan,
              items: _lahanOptions.map((item) => DropdownMenuItem(value: item, child: Text(item))).toList(),
              onChanged: (val) {
                if (val != null) {
                  setState(() {
                    _selectedLahan = val;
                  });
                }
              },
              decoration: _inputDecoration(label: 'Pilih Lahan', icon: Icons.landscape_rounded),
            ),
            const SizedBox(height: 12),
            TextFormField(
              controller: _varietasController,
              decoration: _inputDecoration(label: 'Varietas Padi', icon: Icons.grass_rounded),
            ),
            const SizedBox(height: 12),
            DropdownButtonFormField<String>(
              value: _selectedMetode,
              items: _metodeOptions.map((item) => DropdownMenuItem(value: item, child: Text(item))).toList(),
              onChanged: (val) {
                if (val != null) {
                  setState(() {
                    _selectedMetode = val;
                  });
                }
              },
              decoration: _inputDecoration(label: 'Metode Tanam', icon: Icons.construction_rounded),
            ),
            const SizedBox(height: 12),
            TextFormField(
              controller: _luasController,
              keyboardType: const TextInputType.numberWithOptions(decimal: true),
              decoration: _inputDecoration(label: 'Luas Lahan (Hektar)', icon: Icons.straighten_rounded),
            ),
            const SizedBox(height: 16),
            SizedBox(
              width: double.infinity,
              height: 50,
              child: ElevatedButton(
                onPressed: (_isConflict || _isLoading || _isSubmitting) ? null : _savePlanting,
                style: ElevatedButton.styleFrom(
                  backgroundColor: AppColors.riceGreen,
                  foregroundColor: Colors.white,
                  disabledBackgroundColor: Colors.grey.shade300,
                  disabledForegroundColor: Colors.grey.shade500,
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                  elevation: 0,
                ),
                child: _isSubmitting
                    ? const SizedBox(
                        width: 20,
                        height: 20,
                        child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                      )
                    : const Text(
                        'Simpan Jadwal Tanam',
                        style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
                      ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildMockCalendar() {
    const days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    
    return Card(
      elevation: 0,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Jadwal & Kalender Tanam',
              style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.black87),
            ),
            const SizedBox(height: 16),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                const Icon(Icons.chevron_left_rounded, color: Colors.black54),
                Text(
                  '${_getNamaBulan(_selectedDate.month)} ${_selectedDate.year}',
                  style: const TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
                ),
                const Icon(Icons.chevron_right_rounded, color: Colors.black54),
              ],
            ),
            const SizedBox(height: 12),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceAround,
              children: days.map((day) => Text(day, style: TextStyle(color: Colors.grey.shade600, fontWeight: FontWeight.bold, fontSize: 13))).toList(),
            ),
            const SizedBox(height: 12),
            GridView.builder(
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 7,
                mainAxisSpacing: 8,
                crossAxisSpacing: 8,
              ),
              itemCount: 30,
              itemBuilder: (context, index) {
                int day = index + 1;
                bool isSelectedDay = day == _selectedDate.day;
                bool hasTask = day == 15 || day == 30;

                return Container(
                  decoration: BoxDecoration(
                    color: isSelectedDay ? AppColors.riceGreen : Colors.transparent,
                    shape: BoxShape.circle,
                    border: hasTask && !isSelectedDay ? Border.all(color: Colors.orange, width: 2) : null,
                  ),
                  alignment: Alignment.center,
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text(
                        '$day',
                        style: TextStyle(
                          color: isSelectedDay ? Colors.white : Colors.black87,
                          fontWeight: isSelectedDay || hasTask ? FontWeight.bold : FontWeight.normal,
                          fontSize: 13,
                        ),
                      ),
                      if (hasTask)
                        Container(
                          margin: const EdgeInsets.only(top: 2),
                          width: 4,
                          height: 4,
                          decoration: BoxDecoration(
                            color: isSelectedDay ? Colors.white : Colors.orange,
                            shape: BoxShape.circle,
                          ),
                        )
                    ],
                  ),
                );
              },
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildToDoList() {
    return Card(
      elevation: 0,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Tugas & Panduan Fase Tanam',
              style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.black87),
            ),
            const SizedBox(height: 12),
            ListView.separated(
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              itemCount: _tasks.length,
              separatorBuilder: (context, index) => const Divider(height: 1),
              itemBuilder: (context, index) {
                final task = _tasks[index];
                return CheckboxListTile(
                  value: task['isDone'],
                  onChanged: (bool? value) {
                    setState(() {
                      task['isDone'] = value ?? false;
                    });
                  },
                  contentPadding: EdgeInsets.zero,
                  activeColor: AppColors.riceGreen,
                  checkboxShape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(4)),
                  title: Text(
                    task['title'],
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 14,
                      decoration: task['isDone'] ? TextDecoration.lineThrough : null,
                      color: task['isDone'] ? Colors.grey : Colors.black87,
                    ),
                  ),
                  subtitle: Text(
                    task['subtitle'],
                    style: TextStyle(
                      fontSize: 12,
                      decoration: task['isDone'] ? TextDecoration.lineThrough : null,
                    ),
                  ),
                );
              },
            ),
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        _buildTopHeader(context),
        Expanded(
          child: SingleChildScrollView(
            padding: const EdgeInsets.fromLTRB(20, 16, 20, 30),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                _buildTopBanner(),
                const SizedBox(height: 20),
                
                Row(
                  children: [
                    _buildQuickInfoChip(
                      label: 'Status musim',
                      value: 'Optimal',
                    ),
                    const SizedBox(width: 12),
                    _buildQuickInfoChip(
                      label: 'Target panen',
                      value: (_expectedHarvestDate != null && !_isConflict) 
                          ? _formatHarvestDate(_expectedHarvestDate!) 
                          : 'Belum diizinkan',
                    ),
                  ],
                ),
                const SizedBox(height: 20),

                _buildValidationCard(),
                const SizedBox(height: 20),

                _buildDateSelectorCard(),
                const SizedBox(height: 20),

                _buildInlineForm(),
                const SizedBox(height: 20),

                _buildMockCalendar(),
                const SizedBox(height: 20),

                _buildToDoList(),
              ],
            ),
          ),
        ),
      ],
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
  bool _isLoading = false;
  XFile? _pestImage;

  final List<String> _pestTypes = [
    'Wereng',
    'Walang Sangit',
    'Belalang',
    'Ulat Grayak',
    'Penyakit Blas',
    'Lainnya',
  ];

  Future<void> _pickImage() async {
    final picker = ImagePicker();
    final pickedFile = await picker.pickImage(source: ImageSource.gallery);
    if (pickedFile != null) {
      setState(() {
        _pestImage = pickedFile;
      });
    }
  }

  Future<void> _submitReport() async {
    if (_selectedPestType == null) return;
    
    setState(() {
      _isLoading = true;
    });

    // Pest Report Payload matching PestReportController
    final data = {
      'pest_type': _selectedPestType,
      'severity': 'medium', // Default for now
      'report_date': DateTime.now().toIso8601String().split('T')[0],
      'description': 'Dilaporkan dari aplikasi mobile (GPS Lokasi Aktif).',
      // 'planting_id' might be required by backend validation, ideally we fetch plantings first.
      // But we will send it and let the controller handle it if possible.
      'planting_id': 1 // Dummy ID, usually we should let the user select their planting.
    };

    final result = await ApiService.submitPestReport(data);

    setState(() {
      _isLoading = false;
    });

    if (result['success']) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(result['message'] ?? 'Berhasil dikirim!'),
          behavior: SnackBarBehavior.floating,
          backgroundColor: AppColors.riceGreen,
        ),
      );
      setState(() {
        _selectedPestType = null;
        _pestImage = null;
      });
    } else {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(result['message'] ?? 'Gagal dikirim!'),
          behavior: SnackBarBehavior.floating,
          backgroundColor: const Color(0xFFEF5350),
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        _buildTopHeader(context),
        Expanded(
          child: SingleChildScrollView(
            padding: const EdgeInsets.fromLTRB(20, 16, 20, 30),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                _buildMonitoringHamaBanner(),
                const SizedBox(height: 20),
                _buildRulesCard(),
                const SizedBox(height: 24),
                
                // Form Card
                Card(
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(22),
                  ),
                  elevation: 1,
                  child: Padding(
                    padding: const EdgeInsets.all(18),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            const Icon(
                              Icons.bug_report_rounded,
                              color: AppColors.riceGreen,
                              size: 20,
                            ),
                            const SizedBox(width: 8),
                            Text(
                              'Form Laporan Hama',
                              style: TextStyle(
                                fontSize: 16,
                                fontWeight: FontWeight.w700,
                                color: AppColors.textPrimary,
                              ),
                            ),
                          ],
                        ),
                        const SizedBox(height: 16),
                        
                        // Dropdown Jenis Hama
                        Text(
                          'Jenis Hama',
                          style: TextStyle(
                            fontSize: 12,
                            fontWeight: FontWeight.bold,
                            color: AppColors.textSecondary,
                          ),
                        ),
                        const SizedBox(height: 8),
                        DropdownButtonFormField<String>(
                          value: _selectedPestType,
                          hint: const Text('Pilih Jenis Hama'),
                          items: _pestTypes.map((pest) {
                            return DropdownMenuItem<String>(
                              value: pest,
                              child: Text(pest),
                            );
                          }).toList(),
                          onChanged: (val) {
                            setState(() {
                              _selectedPestType = val;
                            });
                          },
                          decoration: InputDecoration(
                            contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                            filled: true,
                            fillColor: const Color(0xFFF8FBF7),
                            border: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(14),
                              borderSide: const BorderSide(color: Color(0xFFE8F5E9)),
                            ),
                            enabledBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(14),
                              borderSide: const BorderSide(color: Color(0xFFE8F5E9)),
                            ),
                            focusedBorder: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(14),
                              borderSide: const BorderSide(color: AppColors.riceGreen),
                            ),
                          ),
                        ),
                        
                        const Divider(height: 32, color: Color(0xFFE8F5E9)),
                        
                        // Upload Section
                        _buildUploadSection(),
                        
                        const Divider(height: 32, color: Color(0xFFE8F5E9)),
                        
                        // Location Section
                        _buildLocationSection(),
                      ],
                    ),
                  ),
                ),
                
                const SizedBox(height: 24),
                
                // Submit Button
                SizedBox(
                  width: double.infinity,
                  height: 54,
                  child: ElevatedButton(
                    onPressed: (_selectedPestType != null && !_isLoading) ? _submitReport : null,
                    style: ElevatedButton.styleFrom(
                      backgroundColor: AppColors.riceGreen,
                      foregroundColor: Colors.white,
                      elevation: 1,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(18),
                      ),
                    ),
                    child: _isLoading
                        ? const SizedBox(
                            height: 20,
                            width: 20,
                            child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                          )
                        : const Text(
                            'Kirim Laporan',
                            style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                          ),
                  ),
                ),
                
                const SizedBox(height: 30),
                
                _buildSectionHeading(
                  'Notifikasi hama terdekat',
                  'Daftar serangan hama di sekitar koordinat lahan Anda.',
                ),
                const SizedBox(height: 14),
                
                _buildPestNotificationCard(
                  pestName: 'Wereng',
                  villageName: 'Dawuan Barat',
                  distance: '1.2 km dari lahan Anda',
                ),
                _buildPestNotificationCard(
                  pestName: 'Walang Sangit',
                  villageName: 'Dawuan Tengah',
                  distance: '2.5 km dari lahan Anda',
                ),
                _buildPestNotificationCard(
                  pestName: 'Belalang',
                  villageName: 'Dawuan Timur',
                  distance: '3.1 km dari lahan Anda',
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Map<String, dynamic> getVillageStatus(String villageName) {
    final nameNorm = villageName.toLowerCase().replaceAll(RegExp(r'\s+'), '').trim();
    
    int count = 0;
    if (nameNorm == 'dawuanbarat') {
      count = 3;
    } else if (nameNorm == 'dawuantengah') {
      count = 7;
    } else if (nameNorm == 'dawuantimur') {
      count = 11;
    } else if (nameNorm == 'cikampekpusaka') {
      count = 0;
    }

    if (count < 3) {
      return {'color': const Color(0xFF00B159), 'name': 'Aman'};
    } else if (count >= 3 && count < 6) {
      return {'color': const Color(0xFFFFC425), 'name': 'Waspada'};
    } else if (count >= 6 && count < 10) {
      return {'color': const Color(0xFFF37735), 'name': 'Tinggi'};
    } else {
      return {'color': const Color(0xFFD11141), 'name': 'Sangat Tinggi'};
    }
  }

  Widget _buildPestNotificationCard({
    required String pestName,
    required String villageName,
    required String distance,
  }) {
    final status = getVillageStatus(villageName);
    final String statusName = status['name'];
    final Color statusColor = status['color'];

    return Card(
      margin: const EdgeInsets.only(bottom: 12),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(18),
        side: BorderSide(color: statusColor.withOpacity(0.15), width: 1.5),
      ),
      elevation: 1,
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Text(
                        pestName,
                        style: TextStyle(
                          fontSize: 15,
                          fontWeight: FontWeight.bold,
                          color: AppColors.textPrimary,
                        ),
                      ),
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                        decoration: BoxDecoration(
                          color: statusColor.withOpacity(0.12),
                          borderRadius: BorderRadius.circular(20),
                        ),
                        child: Text(
                          statusName,
                          style: TextStyle(
                            fontSize: 10,
                            fontWeight: FontWeight.bold,
                            color: statusColor,
                          ),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 6),
                  Text(
                    'Desa $villageName',
                    style: TextStyle(
                      fontSize: 13,
                      fontWeight: FontWeight.w600,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Row(
                    children: [
                      Icon(
                        Icons.near_me_rounded,
                        size: 13,
                        color: AppColors.textSecondary,
                      ),
                      const SizedBox(width: 4),
                      Text(
                        distance,
                        style: TextStyle(
                          fontSize: 12,
                          color: AppColors.textSecondary,
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

  Widget _buildTopHeader(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 10,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      padding: const EdgeInsets.fromLTRB(20, 50, 20, 16),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              Container(
                width: 38,
                height: 38,
                decoration: BoxDecoration(
                  color: Colors.green.shade50,
                  shape: BoxShape.circle,
                ),
                child: Center(
                  child: Image.asset(
                    'assets/images/logo_padi_dashboard.png',
                    width: 22,
                    height: 22,
                    fit: BoxFit.contain,
                  ),
                ),
              ),
              const SizedBox(width: 10),
              const Text(
                'PADIKU',
                style: TextStyle(
                  color: Color(0xFF2E7D32),
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                  letterSpacing: 1.2,
                ),
              ),
            ],
          ),
          Row(
            children: [
              IconButton(
                icon: const Icon(
                  Icons.support_agent_rounded,
                  color: Colors.black54,
                  size: 24,
                ),
                tooltip: 'Pusat Bantuan',
                onPressed: () {
                  Navigator.pushNamed(context, Routes.pusatBantuan);
                },
              ),
              const SizedBox(width: 4),
              IconButton(
                icon: const Icon(
                  Icons.notifications_none_rounded,
                  color: Colors.black54,
                  size: 26,
                ),
                tooltip: 'Notifikasi',
                onPressed: () {},
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildMonitoringHamaBanner() {
    return Container(
      width: double.infinity,
      height: 120,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(24),
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFF0F5132), Color(0xFF198754)],
        ),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF0F5132).withOpacity(0.2),
            blurRadius: 15,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Stack(
        children: [
          Positioned.fill(
            child: ClipRRect(
              borderRadius: BorderRadius.circular(24),
              child: Opacity(
                opacity: 0.15,
                child: Image.asset(
                  'assets/images/Farmers harvesting rice in Vietnam_.jpeg',
                  fit: BoxFit.cover,
                ),
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 22, vertical: 20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                const Text(
                  'Lapor Hama',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 22,
                    fontWeight: FontWeight.w800,
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(height: 6),
                Text(
                  'Laporkan serangan hama dengan antarmuka yang lebih modern, jelas, dan tetap mempertahankan fitur yang ada.',
                  style: TextStyle(
                    color: Colors.white.withOpacity(0.85),
                    fontSize: 11,
                    height: 1.3,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildRulesCard() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: const Color(0xFFFFF3CD),
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: const Color(0xFFFFEBA8)),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              const Icon(
                Icons.gavel_rounded,
                color: Color(0xFF856404),
                size: 20,
              ),
              const SizedBox(width: 8),
              Text(
                'Peraturan & Panduan Melapor',
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.bold,
                  color: const Color(0xFF856404),
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),
          _buildRuleItem('1', 'GPS HP Anda harus aktif agar koordinat lokasi lahan terdeteksi otomatis.'),
          _buildRuleItem('2', 'Foto yang diunggah wajib berupa foto asli serangan hama di lokasi lahan Anda.'),
          _buildRuleItem('3', 'Pilih Jenis Hama, lampirkan foto serangan, lalu tekan tombol kirim.'),
        ],
      ),
    );
  }

  Widget _buildRuleItem(String step, String rule) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8.0),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            width: 20,
            height: 20,
            decoration: const BoxDecoration(
              color: Color(0xFF856404),
              shape: BoxShape.circle,
            ),
            child: Center(
              child: Text(
                step,
                style: const TextStyle(
                  color: Colors.white,
                  fontSize: 11,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
          ),
          const SizedBox(width: 10),
          Expanded(
            child: Text(
              rule,
              style: const TextStyle(
                fontSize: 13,
                color: Color(0xFF856404),
                height: 1.4,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildUploadSection() {
    return Column(
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
              'Upload Foto Serangan',
              style: TextStyle(
                fontSize: 15,
                fontWeight: FontWeight.bold,
                color: Colors.black87,
              ),
            ),
          ],
        ),
        const SizedBox(height: 14),
        GestureDetector(
          onTap: _pickImage,
          child: Container(
            width: double.infinity,
            height: 150,
            decoration: BoxDecoration(
              color: const Color(0xFFF8FBF7),
              borderRadius: BorderRadius.circular(18),
              border: Border.all(
                color: Colors.green.shade100,
                style: BorderStyle.solid,
              ),
            ),
            child: _pestImage != null
                ? ClipRRect(
                    borderRadius: BorderRadius.circular(18),
                    child: kIsWeb
                        ? Image.network(
                            _pestImage!.path,
                            fit: BoxFit.cover,
                            width: double.infinity,
                            height: double.infinity,
                          )
                        : Image.file(
                            File(_pestImage!.path),
                            fit: BoxFit.cover,
                            width: double.infinity,
                            height: double.infinity,
                          ),
                  )
                : Column(
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
        ),
      ],
    );
  }

  Widget _buildLocationSection() {
    return Row(
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
                'Lokasi Otomatis (GPS)',
                style: TextStyle(
                  fontSize: 15,
                  fontWeight: FontWeight.bold,
                  color: Colors.black87,
                ),
              ),
              const SizedBox(height: 4),
              Row(
                children: [
                  const Icon(
                    Icons.check_circle_rounded,
                    color: AppColors.riceGreen,
                    size: 16,
                  ),
                  const SizedBox(width: 4),
                  Text(
                    'GPS Aktif & Sesuai',
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
    );
  }

}

class RekomendasiBudidayaModule extends StatelessWidget {
  const RekomendasiBudidayaModule({super.key});

  @override
  Widget build(BuildContext context) {
    // Dibungkus Scaffold agar tidak berlatar belakang hitam
    return Scaffold(
      backgroundColor: const Color(0xFFF5F7F5),
      appBar: AppBar(
        title: const Text('Rekomendasi Budidaya', style: TextStyle(fontSize: 18)),
        backgroundColor: const Color(0xFF2E7D32), // Warna hijau khas aplikasi Anda
        foregroundColor: Colors.white,
        elevation: 0,
      ),
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

class MenuModule extends StatefulWidget {
  const MenuModule({super.key});

  @override
  State<MenuModule> createState() => _MenuModuleState();
}

class _MenuModuleState extends State<MenuModule> {
  String _userName = 'Memuat...';
  String _userEmail = '-';
  String _userPhone = '-';
  String _userLocation = '-';

  @override
  void initState() {
    super.initState();
    _loadUserProfile();
  }

  Future<void> _loadUserProfile() async {
    final profile = await ApiService.getUserProfile();
    if (mounted) {
      setState(() {
        _userName = profile['name'] ?? 'Profil Pengguna';
        _userEmail = profile['email'] ?? '-';
        _userPhone = profile['phone'] ?? '-';
        _userLocation = profile['location'] ?? '-';
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        _buildTopHeader(context),
        Expanded(
          child: SingleChildScrollView(
            padding: const EdgeInsets.fromLTRB(20, 16, 20, 30),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                _buildProfileHeroCard(),
                const SizedBox(height: 20),
                _buildFieldCard(
                  label: 'Nama Lengkap',
                  value: _userName,
                  icon: Icons.person_rounded,
                ),
                const SizedBox(height: 12),
                _buildFieldCard(
                  label: 'Nomor Telepon',
                  value: _userPhone,
                  icon: Icons.phone_android_rounded,
                ),
                const SizedBox(height: 12),
                _buildFieldCard(
                  label: 'Alamat Email',
                  value: _userEmail,
                  icon: Icons.email_rounded,
                ),
                const SizedBox(height: 12),
                _buildFieldCard(
                  label: 'Lokasi Lahan',
                  value: _userLocation,
                  icon: Icons.location_on_rounded,
                ),
                const SizedBox(height: 28),
                ElevatedButton.icon(
                  onPressed: () {
                    Navigator.pushNamedAndRemoveUntil(
                      context,
                      Routes.login,
                      (route) => false,
                    );
                  },
                  icon: const Icon(Icons.logout_rounded),
                  label: const Text(
                    'Keluar Akun',
                    style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600),
                  ),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFFEF5350),
                    foregroundColor: Colors.white,
                    padding: const EdgeInsets.symmetric(vertical: 16),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(16),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildTopHeader(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
            blurRadius: 10,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      padding: const EdgeInsets.fromLTRB(20, 50, 20, 16),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              Container(
                width: 38,
                height: 38,
                decoration: BoxDecoration(
                  color: Colors.green.shade50,
                  shape: BoxShape.circle,
                ),
                child: Center(
                  child: Image.asset(
                    'assets/images/logo_padi_dashboard.png',
                    width: 22,
                    height: 22,
                    fit: BoxFit.contain,
                  ),
                ),
              ),
              const SizedBox(width: 10),
              const Text(
                'PADIKU',
                style: TextStyle(
                  color: Color(0xFF2E7D32),
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                  letterSpacing: 1.2,
                ),
              ),
            ],
          ),
          Row(
            children: [
              IconButton(
                icon: const Icon(
                  Icons.support_agent_rounded,
                  color: Colors.black54,
                  size: 24,
                ),
                tooltip: 'Pusat Bantuan',
                onPressed: () {
                  Navigator.pushNamed(context, Routes.pusatBantuan);
                },
              ),
              const SizedBox(width: 4),
              IconButton(
                icon: const Icon(
                  Icons.notifications_none_rounded,
                  color: Colors.black54,
                  size: 26,
                ),
                tooltip: 'Notifikasi',
                onPressed: () {},
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildProfileHeroCard() {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(24),
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFF064E3B), Color(0xFF0F5132), Color(0xFF14532D)],
        ),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF064E3B).withOpacity(0.2),
            blurRadius: 15,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Stack(
        children: [
          Positioned.fill(
            child: ClipRRect(
              borderRadius: BorderRadius.circular(24),
              child: Opacity(
                opacity: 0.15,
                child: Image.asset(
                  'assets/images/Farmers harvesting rice in Vietnam_.jpeg',
                  fit: BoxFit.cover,
                ),
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.all(22),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                  decoration: BoxDecoration(
                    color: Colors.white.withOpacity(0.12),
                    borderRadius: BorderRadius.circular(30),
                    border: Border.all(
                      color: Colors.white.withOpacity(0.15),
                      width: 1,
                    ),
                  ),
                  child: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Container(
                        width: 6,
                        height: 6,
                        decoration: const BoxDecoration(
                          color: Color(0xFFFFC107),
                          shape: BoxShape.circle,
                        ),
                      ),
                      const SizedBox(width: 6),
                      const Text(
                        'PETANI MANDIRI',
                        style: TextStyle(
                          color: Color(0xFFA3E635),
                          fontSize: 10,
                          fontWeight: FontWeight.bold,
                          letterSpacing: 1,
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 18),
                Text(
                  'Akun Saya,\n$_userName',
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 22,
                    fontWeight: FontWeight.w800,
                    height: 1.25,
                    letterSpacing: -0.5,
                  ),
                ),
                const SizedBox(height: 10),
                Text(
                  'Kelola informasi profil, data personal, dan preferensi akun Anda secara langsung dan konsisten.',
                  style: TextStyle(
                    color: Colors.white.withOpacity(0.85),
                    fontSize: 12,
                    height: 1.45,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildFieldCard({
    required String label,
    required String value,
    required IconData icon,
  }) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppColors.riceWhite,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: const Color(0xFFE8F5E9)),
      ),
      child: Row(
        children: [
          Container(
            width: 42,
            height: 42,
            decoration: BoxDecoration(
              color: const Color(0xFFE8F5E9),
              borderRadius: BorderRadius.circular(14),
            ),
            child: Icon(icon, color: AppColors.riceGreen, size: 20),
          ),
          const SizedBox(width: 14),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  label,
                  style: TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.bold,
                    color: AppColors.textSecondary,
                  ),
                ),
                const SizedBox(height: 6),
                Text(
                  value,
                  style: TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.w600,
                    color: AppColors.textPrimary,
                  ),
                ),
              ],
            ),
          ),
        ],
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