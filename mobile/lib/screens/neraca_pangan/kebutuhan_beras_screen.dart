import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class KebutuhanBerasScreen extends StatelessWidget {
  const KebutuhanBerasScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Kebutuhan Beras'),
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
                gradient: LinearGradient(
                  colors: [AppColors.riceOrange, AppColors.riceYellow],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
                borderRadius: BorderRadius.circular(12),
              ),
              padding: const EdgeInsets.all(20),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Total Kebutuhan Beras 2024',
                    style: TextStyle(
                      fontSize: 18,
                      color: AppColors.riceWhite,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    '12,000 Ton',
                    style: TextStyle(
                      fontSize: 36,
                      fontWeight: FontWeight.bold,
                      color: AppColors.riceWhite,
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
                    'Kebutuhan per Kategori',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 12),
                  _buildNeedRow('Konsumsi Rumah Tangga', '8,000 Ton', AppColors.riceGreen),
                  _buildNeedRow('Industri Pengolahan', '2,500 Ton', AppColors.riceYellow),
                  _buildNeedRow('Cadangan Pemerintah', '1,000 Ton', AppColors.riceOrange),
                  _buildNeedRow('Lainnya', '500 Ton', AppColors.riceGold),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildNeedRow(String category, String amount, Color color) {
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
                category,
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
