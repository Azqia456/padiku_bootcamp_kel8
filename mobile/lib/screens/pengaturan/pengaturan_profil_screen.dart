import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

import '../../utils/api_service.dart';

class PengaturanProfilScreen extends StatefulWidget {
  const PengaturanProfilScreen({super.key});

  @override
  State<PengaturanProfilScreen> createState() => _PengaturanProfilScreenState();
}

class _PengaturanProfilScreenState extends State<PengaturanProfilScreen> {
  String _userName = 'Memuat...';
  String _userEmail = '-';
  String _userPhone = '-';
  String _userLocation = '-';

  @override
  void initState() {
    super.initState();
    _loadProfileData();
  }

  Future<void> _loadProfileData() async {
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
    return Scaffold(
      backgroundColor: AppColors.surfaceColor,
      appBar: AppBar(
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        title: const Text('Pengaturan Profil'),
        centerTitle: true,
        elevation: 0,
      ),
      body: SafeArea(
        bottom: false,
        child: SingleChildScrollView(
          padding: const EdgeInsets.fromLTRB(16, 20, 16, 24),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              _buildHeaderCard(),
              const SizedBox(height: 20),
              _buildFieldCard(
                label: 'Nama Lengkap',
                value: _userName,
                icon: Icons.person,
              ),
              const SizedBox(height: 12),
              _buildFieldCard(
                label: 'Nomor Telepon',
                value: _userPhone,
                icon: Icons.phone,
              ),
              const SizedBox(height: 12),
              _buildFieldCard(
                label: 'Alamat Email',
                value: _userEmail,
                icon: Icons.email,
              ),
              const SizedBox(height: 12),
              _buildFieldCard(
                label: 'Lokasi Lahan',
                value: _userLocation,
                icon: Icons.location_on,
              ),
              const SizedBox(height: 24),
              Text(
                'Keamanan & Preferensi',
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w700,
                  color: AppColors.textPrimary,
                ),
              ),
              const SizedBox(height: 12),
              _buildActionItem(
                icon: Icons.lock,
                title: 'Ubah Kata Sandi',
                onTap: () {},
              ),
              const SizedBox(height: 10),
              _buildActionItem(
                icon: Icons.notifications,
                title: 'Notifikasi',
                onTap: () {},
              ),
              const SizedBox(height: 28),
              ElevatedButton(
                onPressed: () {},
                style: ElevatedButton.styleFrom(
                  backgroundColor: AppColors.riceGreen,
                  foregroundColor: AppColors.riceWhite,
                  padding: const EdgeInsets.symmetric(vertical: 16),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(16),
                  ),
                ),
                child: const Text(
                  'Simpan Perubahan',
                  style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeaderCard() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 24),
      decoration: BoxDecoration(
        color: AppColors.riceWhite,
        borderRadius: BorderRadius.circular(28),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withAlpha(12),
            blurRadius: 20,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Column(
        children: [
          Stack(
            alignment: Alignment.bottomRight,
            children: [
              CircleAvatar(
                radius: 46,
                backgroundColor: const Color(0xFFE8F5E9),
                child: const Icon(
                  Icons.person,
                  size: 44,
                  color: AppColors.riceGreen,
                ),
              ),
              Container(
                width: 32,
                height: 32,
                decoration: BoxDecoration(
                  color: AppColors.riceGreen,
                  shape: BoxShape.circle,
                  border: Border.all(color: AppColors.riceWhite, width: 2),
                ),
                child: const Icon(
                  Icons.edit,
                  color: AppColors.riceWhite,
                  size: 18,
                ),
              ),
            ],
          ),
          const SizedBox(height: 14),
          Text(
            _userName,
            style: TextStyle(
              fontSize: 20,
              fontWeight: FontWeight.w700,
              color: AppColors.textPrimary,
            ),
          ),
          const SizedBox(height: 6),
          Text(
            'Petani Padi • Karawang',
            style: TextStyle(
              fontSize: 13,
              color: AppColors.textSecondary,
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
                    fontWeight: FontWeight.w700,
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

  Widget _buildActionItem({
    required IconData icon,
    required String title,
    required VoidCallback onTap,
  }) {
    return Material(
      color: AppColors.riceWhite,
      borderRadius: BorderRadius.circular(18),
      child: InkWell(
        borderRadius: BorderRadius.circular(18),
        onTap: onTap,
        child: Padding(
          padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 16),
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
                size: 16,
                color: AppColors.textSecondary,
              ),
            ],
          ),
        ),
      ),
    );
  }
}
