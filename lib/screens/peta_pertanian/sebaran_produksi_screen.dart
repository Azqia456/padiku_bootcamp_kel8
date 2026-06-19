import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class SebaranProduksiScreen extends StatelessWidget {
  const SebaranProduksiScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Peta Sebaran Produksi'),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              Icons.bar_chart,
              size: 80,
              color: AppColors.riceGreen,
            ),
            const SizedBox(height: 16),
            Text(
              'Peta Sebaran Produksi',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
                color: AppColors.textPrimary,
              ),
            ),
            const SizedBox(height: 8),
            Text(
              'Visualisasi produksi padi per kecamatan',
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
                    _buildLegendItem('> 5000 Ton', AppColors.riceDarkGreen),
                    _buildLegendItem('3000-5000 Ton', AppColors.riceGreen),
                    _buildLegendItem('1000-3000 Ton', AppColors.riceLightGreen),
                    _buildLegendItem('< 1000 Ton', AppColors.riceYellow),
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
