import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class HakAksesScreen extends StatelessWidget {
  const HakAksesScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Hak Akses'),
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
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    children: [
                      Icon(
                        Icons.person,
                        color: AppColors.riceGreen,
                      ),
                      const SizedBox(width: 8),
                      Text(
                        'Petani',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: AppColors.textPrimary,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  _buildAccessItem('Kelola Lahan Sendiri'),
                  _buildAccessItem('Input Jadwal Tanam'),
                  _buildAccessItem('Lihat Prediksi Panen'),
                  _buildAccessItem('Akses Pupuk Subsidi'),
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
                  Row(
                    children: [
                      Icon(
                        Icons.group,
                        color: AppColors.riceYellow,
                      ),
                      const SizedBox(width: 8),
                      Text(
                        'Kelompok Tani',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: AppColors.textPrimary,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  _buildAccessItem('Kelola Lahan Anggota'),
                  _buildAccessItem('Koordinasi Jadwal Tanam'),
                  _buildAccessItem('Lihat Prediksi Panen Kelompok'),
                  _buildAccessItem('Akses Pupuk Subsidi Kelompok'),
                  _buildAccessItem('Laporan Produksi Kelompok'),
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
                  Row(
                    children: [
                      Icon(
                        Icons.account_balance,
                        color: AppColors.riceOrange,
                      ),
                      const SizedBox(width: 8),
                      Text(
                        'Dinas Pertanian',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: AppColors.textPrimary,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  _buildAccessItem('Akses Semua Data Lahan'),
                  _buildAccessItem('Kelola Jadwal Tanam Kabupaten'),
                  _buildAccessItem('Analisis Prediksi Panen'),
                  _buildAccessItem('Kelola Distribusi Pupuk'),
                  _buildAccessItem('Analisis Neraca Pangan'),
                  _buildAccessItem('Akses Peta Pertanian'),
                  _buildAccessItem('Generate Semua Laporan'),
                  _buildAccessItem('Kelola Pengguna'),
                  _buildAccessItem('Konfigurasi Hak Akses'),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildAccessItem(String access) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8),
      child: Row(
        children: [
          Icon(
            Icons.check_circle,
            color: AppColors.riceGreen,
            size: 20,
          ),
          const SizedBox(width: 8),
          Text(
            access,
            style: TextStyle(
              color: AppColors.textPrimary,
            ),
          ),
        ],
      ),
    );
  }
}
