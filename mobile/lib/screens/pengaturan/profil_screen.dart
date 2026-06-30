import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../dashboard_screen.dart';
import '../../utils/app_colors.dart';
import '../../utils/routes.dart';
import '../../utils/api_service.dart';

class ProfilScreen extends StatefulWidget {
  const ProfilScreen({super.key});

  @override
  State<ProfilScreen> createState() => _ProfilScreenState();
}

class _ProfilScreenState extends State<ProfilScreen> {
  String _userName = 'Memuat...';
  String _userEmail = '-';
  String _userPhone = '-';
  String _userLocation = '-';
  String? _profilePhotoPath;
  String _userPassword = '••••••••';

  final _newPasswordController = TextEditingController();
  final _confirmPasswordController = TextEditingController();

  bool _obscureNew = true;
  bool _obscureConfirm = true;
  bool _isLoading = false;

  @override
  void initState() {
    super.initState();
    _loadProfileData();
  }

  @override
  void dispose() {
    _newPasswordController.dispose();
    _confirmPasswordController.dispose();
    super.dispose();
  }

  Future<void> _loadProfileData() async {
    final profile = await ApiService.getUserProfile();
    final prefs = await SharedPreferences.getInstance();
    final localPassword = prefs.getString('user_password') ?? '••••••••';

    if (mounted) {
      setState(() {
        _userName = profile['name'] ?? 'Profil Pengguna';
        _userEmail = profile['email'] ?? '-';
        _userPhone = profile['phone'] ?? '-';
        _userLocation = profile['location'] ?? '-';
        _profilePhotoPath = profile['profile_photo_path'];
        _userPassword = localPassword;
      });
    }
  }

  Future<void> _saveChanges() async {
    if (_newPasswordController.text.isNotEmpty ||
        _confirmPasswordController.text.isNotEmpty) {
      if (_newPasswordController.text.length < 8) {
        _showSnackBar('Kata sandi baru minimal 8 karakter.');
        return;
      }
      if (_newPasswordController.text != _confirmPasswordController.text) {
        _showSnackBar('Konfirmasi kata sandi baru tidak cocok.');
        return;
      }
      
      setState(() {
        _isLoading = true;
      });

      final result = await ApiService.updatePassword(_newPasswordController.text);

      if (mounted) {
        setState(() {
          _isLoading = false;
        });

        if (result['success'] == true) {
          _showSuccessDialog('Kata sandi berhasil diperbarui!');
          setState(() {
            _userPassword = _newPasswordController.text;
          });
          _newPasswordController.clear();
          _confirmPasswordController.clear();
        } else {
          _showSnackBar(result['message'] ?? 'Gagal memperbarui kata sandi.');
        }
      }
    } else {
      _showSnackBar('Tidak ada kata sandi baru yang diisi.');
    }
  }

  void _showSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(message),
        behavior: SnackBarBehavior.floating,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        backgroundColor: AppColors.riceGreen,
      ),
    );
  }

  void _showSuccessDialog(String message) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        title: const Row(
          children: [
            Icon(Icons.check_circle, color: AppColors.riceGreen),
            SizedBox(width: 8),
            Text('Berhasil'),
          ],
        ),
        content: Text(message),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('OK', style: TextStyle(color: AppColors.riceGreen)),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.surfaceColor,
      body: Column(
        children: [
          _buildTopHeader(context),
          Expanded(
            child: _isLoading
                ? const Center(
                    child: CircularProgressIndicator(color: AppColors.riceGreen),
                  )
                : SingleChildScrollView(
                    padding: const EdgeInsets.fromLTRB(20, 16, 20, 30),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.stretch,
                      children: [
                        _buildHeaderCard(),
                        const SizedBox(height: 20),
                        
                        // Informasi Personal Card
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
                                      Icons.person_rounded,
                                      color: AppColors.riceGreen,
                                      size: 20,
                                    ),
                                    const SizedBox(width: 8),
                                    Text(
                                      'Informasi Personal',
                                      style: TextStyle(
                                        fontSize: 16,
                                        fontWeight: FontWeight.w700,
                                        color: AppColors.textPrimary,
                                      ),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 16),
                                _buildInlineReadOnlyField(
                                  label: 'Nama Lengkap',
                                  value: _userName,
                                ),
                                const Divider(height: 24, color: Color(0xFFE8F5E9)),
                                _buildInlineReadOnlyField(
                                  label: 'Nomor Telepon',
                                  value: _userPhone,
                                ),
                                const Divider(height: 24, color: Color(0xFFE8F5E9)),
                                _buildInlineReadOnlyField(
                                  label: 'Alamat Email',
                                  value: _userEmail,
                                ),
                                const Divider(height: 24, color: Color(0xFFE8F5E9)),
                                _buildInlineReadOnlyField(
                                  label: 'Lokasi Lahan',
                                  value: _userLocation,
                                ),
                              ],
                            ),
                          ),
                        ),
                        
                        const SizedBox(height: 16),
                        
                        // Ubah Kata Sandi Card
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
                                      Icons.lock_rounded,
                                      color: AppColors.riceGreen,
                                      size: 20,
                                    ),
                                    const SizedBox(width: 8),
                                    Text(
                                      'Ubah Kata Sandi',
                                      style: TextStyle(
                                        fontSize: 16,
                                        fontWeight: FontWeight.w700,
                                        color: AppColors.textPrimary,
                                      ),
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 16),
                                _buildInlineReadOnlyField(
                                  label: 'Kata Sandi Lama',
                                  value: _userPassword,
                                ),
                                const Divider(height: 24, color: Color(0xFFE8F5E9)),
                                _buildInlineInputField(
                                  label: 'Kata Sandi Baru',
                                  controller: _newPasswordController,
                                  obscureText: _obscureNew,
                                  onToggleVisibility: () => setState(() => _obscureNew = !_obscureNew),
                                ),
                                const Divider(height: 24, color: Color(0xFFE8F5E9)),
                                _buildInlineInputField(
                                  label: 'Konfirmasi Kata Sandi Baru',
                                  controller: _confirmPasswordController,
                                  obscureText: _obscureConfirm,
                                  onToggleVisibility: () => setState(() => _obscureConfirm = !_obscureConfirm),
                                ),
                              ],
                            ),
                          ),
                        ),
                        
                        const SizedBox(height: 32),
                        
                        // Action Buttons Row
                        Row(
                          children: [
                            Expanded(
                              child: OutlinedButton.icon(
                                onPressed: () {
                                  Navigator.pushNamedAndRemoveUntil(
                                    context,
                                    Routes.login,
                                    (route) => false,
                                  );
                                },
                                icon: const Icon(Icons.logout_rounded, size: 18),
                                label: const Text(
                                  'Keluar',
                                  style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold),
                                ),
                                style: OutlinedButton.styleFrom(
                                  foregroundColor: const Color(0xFFEF5350),
                                  side: const BorderSide(color: Color(0xFFEF5350), width: 1.5),
                                  padding: const EdgeInsets.symmetric(vertical: 14),
                                  shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(16),
                                  ),
                                ),
                              ),
                            ),
                            const SizedBox(width: 12),
                            Expanded(
                              child: ElevatedButton.icon(
                                onPressed: _saveChanges,
                                icon: const Icon(Icons.check_circle_outline_rounded, size: 18),
                                label: const Text(
                                  'Simpan',
                                  style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold),
                                ),
                                style: ElevatedButton.styleFrom(
                                  backgroundColor: AppColors.riceGreen,
                                  foregroundColor: Colors.white,
                                  padding: const EdgeInsets.symmetric(vertical: 14),
                                  shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(16),
                                  ),
                                  elevation: 1,
                                ),
                              ),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
          ),
        ],
      ),
      bottomNavigationBar: _buildAccountBottomNav(context),
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
      padding: const EdgeInsets.fromLTRB(16, 50, 20, 16),
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

  Widget _buildHeaderCard() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 24),
      decoration: BoxDecoration(
        color: AppColors.riceWhite,
        borderRadius: BorderRadius.circular(28),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.04),
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
              ClipOval(
                child: Container(
                  width: 92,
                  height: 92,
                  color: const Color(0xFFE8F5E9),
                  child: _profilePhotoPath != null
                      ? Image.network(
                          '${ApiService.baseUrl.replaceAll('/api', '/storage')}/$_profilePhotoPath',
                          fit: BoxFit.cover,
                          errorBuilder: (context, error, stackTrace) {
                            return const Icon(
                              Icons.person_rounded,
                              size: 44,
                              color: AppColors.riceGreen,
                            );
                          },
                        )
                      : const Icon(
                          Icons.person_rounded,
                          size: 44,
                          color: AppColors.riceGreen,
                        ),
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

  Widget _buildInlineReadOnlyField({
    required String label,
    required String value,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: TextStyle(
            fontSize: 11,
            fontWeight: FontWeight.bold,
            color: AppColors.textSecondary,
          ),
        ),
        const SizedBox(height: 4),
        Text(
          value,
          style: TextStyle(
            fontSize: 14,
            fontWeight: FontWeight.w600,
            color: AppColors.textPrimary,
          ),
        ),
      ],
    );
  }

  Widget _buildInlineInputField({
    required String label,
    required TextEditingController controller,
    required bool obscureText,
    required VoidCallback onToggleVisibility,
  }) {
    return Row(
      children: [
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                label,
                style: TextStyle(
                  fontSize: 11,
                  fontWeight: FontWeight.bold,
                  color: AppColors.textSecondary,
                ),
              ),
              TextField(
                controller: controller,
                obscureText: obscureText,
                decoration: const InputDecoration(
                  isDense: true,
                  contentPadding: EdgeInsets.symmetric(vertical: 6),
                  border: InputBorder.none,
                  hintText: 'Masukkan Kata Sandi Baru',
                ),
                style: TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                  color: AppColors.textPrimary,
                ),
              ),
            ],
          ),
        ),
        IconButton(
          icon: Icon(
            obscureText ? Icons.visibility_off_rounded : Icons.visibility_rounded,
            color: AppColors.textSecondary,
            size: 20,
          ),
          onPressed: onToggleVisibility,
          padding: EdgeInsets.zero,
          constraints: const BoxConstraints(),
        ),
      ],
    );
  }

  Widget _buildAccountBottomNav(BuildContext context) {
    return Container(
      height: 94,
      decoration: BoxDecoration(
        color: AppColors.surfaceColor,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.03),
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
                  color: Colors.black.withOpacity(0.05),
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