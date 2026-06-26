import 'package:flutter/material.dart';
import '../dashboard_screen.dart';
import '../../utils/app_colors.dart';
import '../../utils/routes.dart';

class ProfilScreen extends StatelessWidget {
  const ProfilScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.surfaceColor,
      appBar: AppBar(
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back_ios),
          onPressed: () => Navigator.pop(context),
        ),
        title: const Text(
          'Akun',
          style: TextStyle(fontWeight: FontWeight.w600),
        ),
        centerTitle: true,
        elevation: 0,
      ),
      body: ListView(
        padding: EdgeInsets.zero,
        children: [
          Stack(
            clipBehavior: Clip.none,
            children: [
              Container(
                height: 260,
                decoration: BoxDecoration(
                  gradient: AppColors.riceGradient,
                  borderRadius: const BorderRadius.only(
                    bottomLeft: Radius.circular(32),
                    bottomRight: Radius.circular(32),
                  ),
                ),
              ),
              Padding(
                padding: const EdgeInsets.fromLTRB(16, 16, 16, 0),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      'PADIKU',
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w700,
                        color: AppColors.riceWhite,
                        letterSpacing: 1.2,
                      ),
                    ),
                    Container(
                      decoration: BoxDecoration(
                        color: AppColors.riceWhite.withAlpha(24),
                        shape: BoxShape.circle,
                      ),
                      child: IconButton(
                        icon: const Icon(Icons.settings, size: 20),
                        color: AppColors.riceWhite,
                        onPressed: () {},
                      ),
                    ),
                  ],
                ),
              ),
              Positioned(
                top: 70,
                left: 0,
                right: 0,
                child: Column(
                  children: [
                    CircleAvatar(
                      radius: 46,
                      backgroundColor: Colors.white.withAlpha(25),
                      child: const CircleAvatar(
                        radius: 38,
                        backgroundColor: AppColors.riceWhite,
                        child: Icon(
                          Icons.person,
                          size: 44,
                          color: AppColors.riceGreen,
                        ),
                      ),
                    ),
                    const SizedBox(height: 14),
                    Text(
                      'Pak Udin',
                      style: TextStyle(
                        fontSize: 22,
                        fontWeight: FontWeight.w700,
                        color: AppColors.riceWhite,
                      ),
                    ),
                    const SizedBox(height: 6),
                    Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 14,
                        vertical: 6,
                      ),
                      decoration: BoxDecoration(
                        color: AppColors.riceWhite.withAlpha(28),
                        borderRadius: BorderRadius.circular(20),
                      ),
                      child: Text(
                        'PETANI MANDIRI',
                        style: TextStyle(
                          fontSize: 12,
                          fontWeight: FontWeight.w500,
                          color: AppColors.riceWhite.withAlpha(210),
                          letterSpacing: 0.8,
                        ),
                      ),
                    ),
                  ],
                ),
              ),
              Positioned(
                bottom: -44,
                left: 16,
                right: 16,
                child: Row(
                  children: [
                    Expanded(
                      child: _buildStatCard('Total Laporan', '12'),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: _buildStatCard('Lahan Aktif', '27 Ha'),
                    ),
                  ],
                ),
              ),
            ],
          ),

          const SizedBox(height: 64),

          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Card(
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(22),
              ),
              elevation: 2,
              child: Padding(
                padding: const EdgeInsets.all(18),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Text(
                          'Informasi Personal',
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.w700,
                            color: AppColors.textPrimary,
                          ),
                        ),
                        Icon(
                          Icons.edit,
                          color: AppColors.riceGreen,
                          size: 20,
                        ),
                      ],
                    ),
                    const SizedBox(height: 16),
                    _buildInfoItem('Nama Lengkap', 'Pak Udin'),
                    _buildInfoItem('Nomor Telepon', '+62 812-3456-7890'),
                    _buildInfoItem('Lokasi Lahan', 'Karawang, Jawa Barat'),
                  ],
                ),
              ),
            ),
          ),

          const SizedBox(height: 16),

          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Card(
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(22),
              ),
              elevation: 2,
              child: Padding(
                padding: const EdgeInsets.symmetric(vertical: 14),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 18),
                      child: Text(
                        'Menu Akun',
                        style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.w700,
                          color: AppColors.textPrimary,
                        ),
                      ),
                    ),
                    const SizedBox(height: 12),
                    _buildMenuItem(
                      icon: Icons.person,
                      title: 'Pengaturan Profil',
                      onTap: () => Navigator.pushNamed(context, Routes.pengaturanProfil),
                    ),
                    _buildMenuItem(
                      icon: Icons.security,
                      title: 'Keamanan Akun',
                      onTap: () => Navigator.pushNamed(context, Routes.keamananAkun),
                    ),
                    _buildMenuItem(
                      icon: Icons.language,
                      title: 'Pilih Bahasa',
                      onTap: () {},
                    ),
                    _buildMenuItem(
                      icon: Icons.help_center,
                      title: 'Pusat Bantuan',
                      onTap: () => Navigator.pushNamed(context, Routes.pusatBantuan),
                    ),
                    _buildMenuItem(
                      icon: Icons.info,
                      title: 'Tentang Padiku',
                      onTap: () => Navigator.pushNamed(context, Routes.tentangPadiku),
                    ),
                  ],
                ),
              ),
            ),
          ),

          const SizedBox(height: 18),

          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: ElevatedButton.icon(
              onPressed: () {},
              icon: const Icon(Icons.logout),
              label: const Text('Keluar Akun'),
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xFFEF5350),
                foregroundColor: AppColors.riceWhite,
                padding: const EdgeInsets.symmetric(vertical: 14),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(16),
                ),
              ),
            ),
          ),

          const SizedBox(height: 24),
        ],
      ),
      bottomNavigationBar: _buildAccountBottomNav(context),
    );
  }

  Widget _buildStatCard(String label, String value) {
    return Card(
      elevation: 1,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(8),
      ),
      child: Padding(
        padding: const EdgeInsets.symmetric(vertical: 16),
        child: Column(
          children: [
            Text(
              value,
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
                color: AppColors.riceGreen,
              ),
            ),
            const SizedBox(height: 4),
            Text(
              label,
              style: TextStyle(
                fontSize: 12,
                color: AppColors.textSecondary,
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildInfoItem(String label, String value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            label,
            style: TextStyle(
              fontSize: 11,
              fontWeight: FontWeight.w600,
              color: AppColors.textSecondary,
            ),
          ),
          const SizedBox(height: 4),
          Text(
            value,
            style: TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.w500,
              color: AppColors.textPrimary,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildMenuItem({
    required IconData icon,
    required String title,
    required VoidCallback onTap,
  }) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        margin: const EdgeInsets.only(bottom: 10),
        padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 16),
        decoration: BoxDecoration(
          color: AppColors.riceWhite,
          borderRadius: BorderRadius.circular(12),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withAlpha(10),
              blurRadius: 12,
              offset: const Offset(0, 6),
            ),
          ],
        ),
        child: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(10),
              decoration: BoxDecoration(
                color: const Color.fromRGBO(10, 92, 52, 0.12),
                borderRadius: BorderRadius.circular(8),
              ),
              child: Icon(
                icon,
                color: AppColors.riceGreen,
                size: 20,
              ),
            ),
            const SizedBox(width: 14),
            Expanded(
              child: Text(
                title,
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                  color: AppColors.textPrimary,
                ),
              ),
            ),
            Icon(
              Icons.arrow_forward_ios,
              color: AppColors.textSecondary,
              size: 16,
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildAccountBottomNav(BuildContext context) {
    return Container(
      height: 94,
      decoration: BoxDecoration(
        color: AppColors.surfaceColor,
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
                _buildNavItem(
                  context,
                  Icons.landscape_rounded,
                  'Lahan',
                  false,
                  () => Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(
                      builder: (_) => const DashboardScreen(initialIndex: 1),
                    ),
                  ),
                ),
                _buildNavItem(
                  context,
                  Icons.calendar_month_rounded,
                  'Jadwal',
                  false,
                  () => Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(
                      builder: (_) => const DashboardScreen(initialIndex: 2),
                    ),
                  ),
                ),
                const Spacer(),
                _buildNavItem(
                  context,
                  Icons.assignment_rounded,
                  'Lapor',
                  false,
                  () => Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(
                      builder: (_) => const DashboardScreen(initialIndex: 3),
                    ),
                  ),
                ),
                _buildNavItem(
                  context,
                  Icons.person_rounded,
                  'Akun',
                  true,
                  () {},
                ),
              ],
            ),
          ),
          Positioned(
            top: -8,
            left: MediaQuery.of(context).size.width / 2 - 34,
            child: GestureDetector(
              onTap: () => Navigator.pushReplacement(
                context,
                MaterialPageRoute(
                  builder: (_) => const DashboardScreen(initialIndex: 0),
                ),
              ),
              child: Container(
                width: 68,
                height: 68,
                decoration: BoxDecoration(
                  gradient: AppColors.riceGradient,
                  shape: BoxShape.circle,
                  border: Border.all(color: Colors.white, width: 5),
                  boxShadow: [
                    BoxShadow(
                      color: const Color.fromRGBO(46, 125, 50, 0.28),
                      blurRadius: 18,
                      offset: const Offset(0, 8),
                    ),
                  ],
                ),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    const Icon(Icons.grass, color: Colors.white, size: 28),
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
                color: AppColors.riceGreen,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildNavItem(
    BuildContext context,
    IconData icon,
    String label,
    bool selected,
    VoidCallback onTap,
  ) {
    return GestureDetector(
      onTap: onTap,
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
                color: selected ? const Color(0xFFE7F4E8) : Colors.transparent,
                borderRadius: BorderRadius.circular(16),
              ),
              child: Icon(
                icon,
                color: selected ? AppColors.riceGreen : Colors.grey.shade400,
                size: 24,
              ),
            ),
            const SizedBox(height: 4),
            Text(
              label,
              style: TextStyle(
                fontSize: 11,
                color: selected ? AppColors.riceGreen : Colors.grey.shade500,
                fontWeight: selected ? FontWeight.w600 : FontWeight.normal,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

