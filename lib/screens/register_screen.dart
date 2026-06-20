import 'package:flutter/material.dart';
import '../utils/app_colors.dart';
import '../utils/routes.dart';

class RegisterScreen extends StatefulWidget {
  const RegisterScreen({super.key});

  @override
  State<RegisterScreen> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  final _formKey = GlobalKey<FormState>();
  bool _obscurePassword = true;
  bool _isAgreed = false;

  // Controller untuk mengambil data inputan
  final _nameController = TextEditingController();
  final _phoneController = TextEditingController();
  final _kecamatanController = TextEditingController();
  final _passwordController = TextEditingController();

  @override
  void dispose() {
    _nameController.dispose();
    _phoneController.dispose();
    _kecamatanController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white, 
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: Colors.black),
          onPressed: () => Navigator.pop(context),
        ),
        title: const Text(
          'Daftar akun petani',
          style: TextStyle(color: Colors.black, fontWeight: FontWeight.bold),
        ),
      ),
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 24.0, vertical: 16.0),
          child: Form(
            key: _formKey,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Input Nama Lengkap
                const Text(
                  'Nama lengkap',
                  style: TextStyle(fontWeight: FontWeight.w600, color: Colors.black87),
                ),
                const SizedBox(height: 8),
                TextFormField(
                  controller: _nameController,
                  decoration: InputDecoration(
                    hintText: 'Nama sesuai KTP',
                    hintStyle: const TextStyle(color: Colors.grey),
                    contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                    ),
                    enabledBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: const BorderSide(color: Colors.grey),
                    ),
                  ),
                ),
                const SizedBox(height: 18),

                // Input No. HP
                const Text(
                  'No. HP',
                  style: TextStyle(fontWeight: FontWeight.w600, color: Colors.black87),
                ),
                const SizedBox(height: 8),
                TextFormField(
                  controller: _phoneController,
                  keyboardType: TextInputType.phone,
                  decoration: InputDecoration(
                    hintText: '08xxxxxxxxxx',
                    hintStyle: const TextStyle(color: Colors.grey),
                    contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                    ),
                    enabledBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: const BorderSide(color: Colors.grey),
                    ),
                  ),
                ),
                const SizedBox(height: 18),

                // Input Kecamatan 
                const Text(
                  'Kecamatan',
                  style: TextStyle(fontWeight: FontWeight.w600, color: Colors.black87),
                ),
                const SizedBox(height: 8),
                TextFormField(
                  controller: _kecamatanController,
                  decoration: InputDecoration(
                    hintText: 'Masukkan nama kecamatan',
                    hintStyle: const TextStyle(color: Colors.grey),
                    contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                    ),
                    enabledBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: const BorderSide(color: Colors.grey),
                    ),
                  ),
                ),
                const SizedBox(height: 18),

                // Input Kata Sandi
                const Text(
                  'Kata sandi',
                  style: TextStyle(fontWeight: FontWeight.w600, color: Colors.black87),
                ),
                const SizedBox(height: 8),
                TextFormField(
                  controller: _passwordController,
                  obscureText: _obscurePassword,
                  decoration: InputDecoration(
                    hintText: 'Minimal 8 karakter',
                    hintStyle: const TextStyle(color: Colors.grey),
                    contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                    ),
                    enabledBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: const BorderSide(color: Colors.grey),
                    ),
                    suffixIcon: IconButton(
                      icon: Icon(
                        _obscurePassword ? Icons.visibility_off : Icons.visibility,
                        color: Colors.grey,
                      ),
                      onPressed: () {
                        setState(() {
                          _obscurePassword = !_obscurePassword;
                        });
                      },
                    ),
                  ),
                ),
                const SizedBox(height: 20),

                // Checkbox Persetujuan Ketentuan & Privasi
                Row(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    SizedBox(
                      height: 24,
                      width: 24,
                      child: Checkbox(
                        value: _isAgreed,
                        activeColor: AppColors.riceGreen, 
                        onChanged: (value) {
                          setState(() {
                            _isAgreed = value ?? false;
                          });
                        },
                      ),
                    ),
                    const SizedBox(width: 12),
                    const Expanded(
                      child: Text(
                        'Saya menyetujui ketentuan penggunaan dan kebijakan privasi PADIKU',
                        style: TextStyle(color: Colors.black87, fontSize: 13),
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 30),

                SizedBox(
                  width: double.infinity,
                  height: 48,
                  child: ElevatedButton(
                    onPressed: _isAgreed
                        ? () {
                            if (_formKey.currentState!.validate()) {
                          
                            }
                          }
                        : null, 
                    style: ElevatedButton.styleFrom(
                      backgroundColor: AppColors.riceGreen, 
                      foregroundColor: Colors.white,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      elevation: 0,
                    ),
                    child: const Text(
                      'Daftar',
                      style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                    ),
                  ),
                ),
                const SizedBox(height: 24),

                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    const Text(
                      'Sudah punya akun? ',
                      style: TextStyle(color: Colors.black54),
                    ),
                    GestureDetector(
  onTap: () {
    Navigator.pushNamed(context, Routes.login);
  },
  child: Text(
    'Masuk',
                        style: TextStyle(
                          color: AppColors.riceGreen,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}