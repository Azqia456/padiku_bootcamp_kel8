import 'package:flutter/material.dart';
import '../utils/app_colors.dart';
import '../utils/routes.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _usernameController = TextEditingController();
  final _passwordController = TextEditingController();
  String _selectedUserType = 'Petani';

  @override
  void dispose() {
    _usernameController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  void _login() {
    if (_formKey.currentState!.validate()) {
      // Navigate to dashboard based on user type
      Navigator.pushReplacementNamed(context, Routes.dashboard);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: const BoxDecoration(
          gradient: AppColors.riceGradient,
        ),
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.all(24.0),
            child: Card(
              elevation: 8,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(16),
              ),
              child: Padding(
                padding: const EdgeInsets.all(32.0),
                child: Form(
                  key: _formKey,
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      // Logo and Title
                      Icon(
                        Icons.agriculture,
                        size: 80,
                        color: AppColors.riceGreen,
                      ),
                      const SizedBox(height: 16),
                      Text(
                        'PADIKU',
                        style: TextStyle(
                          fontSize: 32,
                          fontWeight: FontWeight.bold,
                          color: AppColors.riceDarkGreen,
                        ),
                      ),
                      const SizedBox(height: 8),
                      Text(
                        'Sistem Informasi Tanaman Padi',
                        style: TextStyle(
                          fontSize: 14,
                          color: AppColors.textSecondary,
                        ),
                      ),
                      const SizedBox(height: 32),

                      // User Type Selection
                      DropdownButtonFormField<String>(
                        value: _selectedUserType,
                        decoration: InputDecoration(
                          labelText: 'Tipe Pengguna',
                          prefixIcon: const Icon(Icons.person),
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                          filled: true,
                          fillColor: AppColors.surfaceColor,
                        ),
                        items: const [
                          DropdownMenuItem(
                            value: 'Petani',
                            child: Text('Petani'),
                          ),
                          DropdownMenuItem(
                            value: 'Kelompok Tani',
                            child: Text('Kelompok Tani'),
                          ),
                          DropdownMenuItem(
                            value: 'Dinas Pertanian',
                            child: Text('Dinas Pertanian'),
                          ),
                        ],
                        onChanged: (value) {
                          setState(() {
                            _selectedUserType = value!;
                          });
                        },
                      ),
                      const SizedBox(height: 16),

                      // Username Field
                      TextFormField(
                        controller: _usernameController,
                        decoration: InputDecoration(
                          labelText: 'Username',
                          prefixIcon: const Icon(Icons.email),
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                          filled: true,
                          fillColor: AppColors.surfaceColor,
                        ),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Username tidak boleh kosong';
                          }
                          return null;
                        },
                      ),
                      const SizedBox(height: 16),

                      // Password Field
                      TextFormField(
                        controller: _passwordController,
                        obscureText: true,
                        decoration: InputDecoration(
                          labelText: 'Password',
                          prefixIcon: const Icon(Icons.lock),
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                          filled: true,
                          fillColor: AppColors.surfaceColor,
                        ),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Password tidak boleh kosong';
                          }
                          return null;
                        },
                      ),
                      const SizedBox(height: 24),

                      // Login Button
                      SizedBox(
                        width: double.infinity,
                        height: 50,
                        child: ElevatedButton(
                          onPressed: _login,
                          style: ElevatedButton.styleFrom(
                            backgroundColor: AppColors.riceGreen,
                            foregroundColor: AppColors.riceWhite,
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(8),
                            ),
                          ),
                          child: const Text(
                            'MASUK',
                            style: TextStyle(
                              fontSize: 16,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                        ),
                      ),
                      const SizedBox(height: 16),

                      // Forgot Password
                      TextButton(
                        onPressed: () {
                          // Implement forgot password
                        },
                        child: Text(
                          'Lupa Password?',
                          style: TextStyle(
                            color: AppColors.riceGreen,
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
}
