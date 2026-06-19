import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class PrediksiKetersediaanScreen extends StatelessWidget {
  const PrediksiKetersediaanScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Prediksi Ketersediaan Pangan'),
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
                    'Prediksi 6 Bulan ke Depan',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 16),
                  _buildPredictionMonth('Januari 2024', '2,500 Ton', AppColors.riceGreen),
                  _buildPredictionMonth('Februari 2024', '2,300 Ton', AppColors.riceLightGreen),
                  _buildPredictionMonth('Maret 2024', '2,100 Ton', AppColors.riceYellow),
                  _buildPredictionMonth('April 2024', '2,800 Ton', AppColors.riceGreen),
                  _buildPredictionMonth('Mei 2024', '2,600 Ton', AppColors.riceLightGreen),
                  _buildPredictionMonth('Juni 2024', '2,400 Ton', AppColors.riceYellow),
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
                        Icons.info,
                        color: AppColors.riceGreen,
                      ),
                      const SizedBox(width: 8),
                      Text(
                        'Kesimpulan',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: AppColors.textPrimary,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  Text(
                    'Berdasarkan prediksi, ketersediaan pangan diprediksi stabil dalam 6 bulan ke depan dengan rata-rata 2,450 ton per bulan. Puncak ketersediaan akan terjadi pada bulan April 2024 bersamaan dengan masa panen raya.',
                    style: TextStyle(
                      color: AppColors.textSecondary,
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

  Widget _buildPredictionMonth(String month, String amount, Color color) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              Container(
                width: 12,
                height: 12,
                decoration: BoxDecoration(
                  color: color,
                  shape: BoxShape.circle,
                ),
              ),
              const SizedBox(width: 8),
              Text(
                month,
                style: TextStyle(
                  color: AppColors.textPrimary,
                ),
              ),
            ],
          ),
          Text(
            amount,
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
