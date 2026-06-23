import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class EstimasiTanggalScreen extends StatelessWidget {
  const EstimasiTanggalScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Estimasi Tanggal Panen'),
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
                  Text(
                    'Lahan Sawah Blok A',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 12),
                  _buildPredictionRow('Tanggal Tanam', '15 Jan 2024'),
                  _buildPredictionRow('Varietas', 'IR64'),
                  _buildPredictionRow('Umur Tanaman', '90 hari'),
                  _buildPredictionRow('Estimasi Panen', '15 April 2024'),
                  const SizedBox(height: 12),
                  Container(
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      color: AppColors.riceLightGreen.withOpacity(0.2),
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: Row(
                      children: [
                        Icon(
                          Icons.calendar_today,
                          color: AppColors.riceGreen,
                        ),
                        const SizedBox(width: 8),
                        Text(
                          '27 hari lagi menuju panen',
                          style: TextStyle(
                            color: AppColors.riceDarkGreen,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildPredictionRow(String label, String value) {
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
