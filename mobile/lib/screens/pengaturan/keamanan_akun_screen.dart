import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class KeamananAkunScreen extends StatefulWidget {
  const KeamananAkunScreen({super.key});

  @override
  State<KeamananAkunScreen> createState() => _KeamananAkunScreenState();
}

class _KeamananAkunScreenState extends State<KeamananAkunScreen> {
  bool _twoFactor = false;
  bool _biometric = true;

  final _currentPassController = TextEditingController();
  final _newPassController = TextEditingController();
  final _confirmPassController = TextEditingController();
  bool _isSaveEnabled = false;

  @override
  void dispose() {
    _currentPassController.dispose();
    _newPassController.dispose();
    _confirmPassController.dispose();
    super.dispose();
  }

  @override
  void initState() {
    super.initState();
    _currentPassController.addListener(_validateInputs);
    _newPassController.addListener(_validateInputs);
    _confirmPassController.addListener(_validateInputs);
  }

  void _validateInputs() {
    final current = _currentPassController.text.trim();
    final n = _newPassController.text.trim();
    final c = _confirmPassController.text.trim();
    final enabled = current.isNotEmpty && n.isNotEmpty && c.isNotEmpty && n == c;
    if (enabled != _isSaveEnabled) setState(() => _isSaveEnabled = enabled);
  }

  void _savePassword() {
    final current = _currentPassController.text.trim();
    final n = _newPassController.text.trim();
    final c = _confirmPassController.text.trim();
    if (current.isEmpty || n.isEmpty || c.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Lengkapi semua field')));
      return;
    }
    if (n != c) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Kata sandi baru tidak cocok')));
      return;
    }

    // Simulate save
    _currentPassController.clear();
    _newPassController.clear();
    _confirmPassController.clear();
    _validateInputs();
    ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Kata sandi berhasil disimpan')));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.surfaceColor,
      appBar: AppBar(
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        title: const Text('Keamanan Akun'),
        centerTitle: true,
      ),
      body: SafeArea(
        bottom: false,
        child: SingleChildScrollView(
          padding: const EdgeInsets.fromLTRB(16, 20, 16, 24),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              _buildPriorityCard(),
              const SizedBox(height: 18),
              _buildChangePasswordCard(),
              const SizedBox(height: 18),
              _buildAdditionalProtectionCard(),
              const SizedBox(height: 18),
              Center(
                child: TextButton(
                  onPressed: () {},
                  child: Text('Menemukan aktivitas mencurigakan? Hubungi Bantuan', style: TextStyle(color: AppColors.textSecondary)),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildPriorityCard() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        gradient: AppColors.harvestGradient,
        borderRadius: BorderRadius.circular(12),
      ),
      child: Row(
        children: [
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text('Keamanan adalah Prioritas', style: TextStyle(color: AppColors.riceWhite, fontWeight: FontWeight.w700, fontSize: 16)),
                const SizedBox(height: 8),
                Text('Lindungi data pertanian Anda dengan fitur keamanan terbaru dari PADIKU.', style: TextStyle(color: AppColors.riceWhite.withAlpha(220))),
              ],
            ),
          ),
          const SizedBox(width: 12),
          Icon(Icons.shield, color: AppColors.riceWhite, size: 40),
        ],
      ),
    );
  }

  Widget _buildChangePasswordCard() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppColors.riceWhite,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [BoxShadow(color: Colors.black.withAlpha(8), blurRadius: 16, offset: const Offset(0, 8))],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text('UBAH KATA SANDI', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700, color: AppColors.textSecondary)),
          const SizedBox(height: 12),
          _buildTextField('Kata Sandi Saat Ini', controller: _currentPassController),
          const SizedBox(height: 10),
          _buildTextField('Kata Sandi Baru', controller: _newPassController),
          const SizedBox(height: 10),
          _buildTextField('Konfirmasi Kata Sandi Baru', controller: _confirmPassController),
          const SizedBox(height: 14),
          SizedBox(
            width: double.infinity,
            child: ElevatedButton.icon(
              onPressed: _isSaveEnabled ? _savePassword : null,
              icon: const Icon(Icons.save_outlined, size: 18),
              label: Text('Simpan Kata Sandi', style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w600)),
              style: ElevatedButton.styleFrom(
                backgroundColor: AppColors.riceGreen,
                disabledBackgroundColor: Colors.grey.shade300,
                foregroundColor: AppColors.riceWhite,
                disabledForegroundColor: Colors.grey.shade600,
                padding: const EdgeInsets.symmetric(vertical: 14),
                elevation: _isSaveEnabled ? 6 : 0,
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildAdditionalProtectionCard() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppColors.riceWhite,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [BoxShadow(color: Colors.black.withAlpha(8), blurRadius: 16, offset: const Offset(0, 8))],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text('PERLINDUNGAN TAMBAHAN', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700, color: AppColors.textSecondary)),
          const SizedBox(height: 12),
          Row(
            children: [
              Expanded(
                child: Row(
                  children: [
                    Container(
                      width: 42,
                      height: 42,
                      decoration: BoxDecoration(color: const Color(0xFFE8F5E9), borderRadius: BorderRadius.circular(10)),
                      child: Icon(Icons.shield, color: AppColors.riceGreen),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text('Verifikasi 2 Langkah', style: TextStyle(fontWeight: FontWeight.w600, color: AppColors.textPrimary)),
                          const SizedBox(height: 6),
                          Text('Keamanan ekstra saat login', style: TextStyle(color: AppColors.textSecondary, fontSize: 12)),
                        ],
                      ),
                    ),
                    Switch(
                      value: _twoFactor,
                      onChanged: (v) => setState(() => _twoFactor = v),
                    ),
                  ],
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),
          Row(
            children: [
              Container(
                width: 42,
                height: 42,
                decoration: BoxDecoration(color: const Color(0xFFE8F5E9), borderRadius: BorderRadius.circular(10)),
                child: Icon(Icons.fingerprint, color: AppColors.riceGreen),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text('Autentikasi Biometrik', style: TextStyle(fontWeight: FontWeight.w600, color: AppColors.textPrimary)),
                    const SizedBox(height: 6),
                    Text('Gunakan sidik jari atau wajah', style: TextStyle(color: AppColors.textSecondary, fontSize: 12)),
                  ],
                ),
              ),
              Switch(
                value: _biometric,
                onChanged: (v) => setState(() => _biometric = v),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildTextField(String hint, {required TextEditingController controller}) {
    return TextField(
      controller: controller,
      obscureText: true,
      decoration: InputDecoration(
        hintText: hint,
        filled: true,
        fillColor: const Color(0xFFF7F7F7),
        contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(10), borderSide: BorderSide.none),
      ),
    );
  }
}
