import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class LaporanKetahananPanganScreen extends StatelessWidget {
  const LaporanKetahananPanganScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Laporan Ketahanan Pangan'),
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
            child: Container(
              decoration: BoxDecoration(
                gradient: AppColors.riceGradient,
                borderRadius: BorderRadius.circular(12),
              ),
              padding: const EdgeInsets.all(20),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Indeks Ketahanan Pangan 2024',
                    style: TextStyle(
                      fontSize: 18,
                      color: AppColors.riceWhite,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    'Skor: 85.5',
                    style: TextStyle(
                      fontSize: 36,
                      fontWeight: FontWeight.bold,
                      color: AppColors.riceWhite,
                    ),
                  ),
                  Text(
                    'Kategori: Sangat Kuat',
                    style: TextStyle(
                      fontSize: 16,
                      color: AppColors.riceCream,
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
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Text(
                        'Laporan Lengkap 2024',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: AppColors.textPrimary,
                        ),
                      ),
                      IconButton(
                        icon: const Icon(Icons.download),
                        onPressed: () {
                          // Download report
                        },
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  _buildReportRow('Ketersediaan Pangan', '90/100'),
                  _buildReportRow('Akses Pangan', '85/100'),
                  _buildReportRow('Pemanfaatan Pangan', '82/100'),
                  _buildReportRow('Stabilitas Pangan', '85/100'),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildReportRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8),
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
