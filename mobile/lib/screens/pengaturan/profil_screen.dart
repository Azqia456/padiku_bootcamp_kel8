import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class ProfilScreen extends StatelessWidget {
  const ProfilScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Profil'),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
      ),
      body: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          Card(
            elevation: 4,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                children: [
                  CircleAvatar(
                    radius: 50,
                    backgroundColor: AppColors.riceGreen,
                    child: const Icon(
                      Icons.person,
                      size: 50,
                      color: AppColors.riceWhite,
                    ),
                  ),
                  const SizedBox(height: 16),
                  Text(
                    'Petani Demo',
                    style: TextStyle(
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    'Petani',
                    style: TextStyle(
                      fontSize: 16,
                      color: AppColors.textSecondary,
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 16),
          Card(
            elevation: 4,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Informasi Akun',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 12),
                  _buildInfoRow('Username', 'petani_demo'),
                  _buildInfoRow('Email', 'petani@demo.com'),
                  _buildInfoRow('No. HP', '08123456789'),
                  _buildInfoRow('Alamat', 'Karawang, Jawa Barat'),
                ],
              ),
            ),
          ),
          const SizedBox(height: 16),
          Card(
            elevation: 4,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            child: ListTile(
              leading: const Icon(Icons.edit),
              title: const Text('Edit Profil'),
              trailing: const Icon(Icons.arrow_forward_ios),
              onTap: () {
                // Edit profile
              },
            ),
          ),
          const SizedBox(height: 12),
          Card(
            elevation: 4,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            child: ListTile(
              leading: const Icon(Icons.lock),
              title: const Text('Ubah Password'),
              trailing: const Icon(Icons.arrow_forward_ios),
              onTap: () {
                // Change password
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildInfoRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            label,
            style: TextStyle(
              color: AppColors.textSecondary,
            ),
          ),
          Text(
            value,
            style: TextStyle(
              fontWeight: FontWeight.bold,
              color: AppColors.textPrimary,
            ),
          ),
        ],
      ),
    );
  }
}
