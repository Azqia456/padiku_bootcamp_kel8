import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class SebaranPanenScreen extends StatelessWidget {
  const SebaranPanenScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Peta Sebaran Panen'),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              Icons.agriculture,
              size: 80,
              color: AppColors.riceOrange,
            ),
            const SizedBox(height: 16),
            Text(
              'Peta Sebaran Panen',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
                color: AppColors.textPrimary,
              ),
            ),
            const SizedBox(height: 8),
            Text(
              'Jadwal dan lokasi panen di Karawang',
              style: TextStyle(
                color: AppColors.textSecondary,
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
                  children: [
                    _buildLegendItem('Sedang Panen', AppColors.riceOrange),
                    _buildLegendItem('Siap Panen', AppColors.riceYellow),
                    _buildLegendItem('1-2 Minggu Lagi', AppColors.riceGreen),
                    _buildLegendItem('> 2 Minggu', AppColors.riceLightGreen),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildLegendItem(String label, Color color) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4),
      child: Row(
        children: [
          Container(
            width: 24,
            height: 24,
            decoration: BoxDecoration(
              color: color,
              borderRadius: BorderRadius.circular(4),
            ),
          ),
          const SizedBox(width: 8),
          Text(
            label,
            style: TextStyle(
              color: AppColors.textPrimary,
            ),
          ),
        ],
      ),
    );
  }
}
