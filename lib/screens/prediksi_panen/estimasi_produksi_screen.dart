import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class EstimasiProduksiScreen extends StatelessWidget {
  const EstimasiProduksiScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Estimasi Produksi'),
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
                gradient: AppColors.harvestGradient,
                borderRadius: BorderRadius.circular(12),
              ),
              padding: const EdgeInsets.all(20),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Estimasi Total Produksi',
                    style: TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                      color: AppColors.riceWhite,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    '1,250 Ton',
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
                    'Rincian per Lahan',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 12),
                  _buildProductionRow('Lahan Blok A', '2.5 Ha', '12.5 Ton'),
                  _buildProductionRow('Lahan Blok B', '1.8 Ha', '9.0 Ton'),
                  _buildProductionRow('Lahan Blok C', '3.2 Ha', '16.0 Ton'),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildProductionRow(String lahan, String luas, String produksi) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Expanded(
            child: Text(
              lahan,
              style: TextStyle(
                color: AppColors.textPrimary,
              ),
            ),
          ),
          Text(
            luas,
            style: TextStyle(
              color: AppColors.textSecondary,
            ),
          ),
          Text(
            produksi,
            style: TextStyle(
              fontWeight: FontWeight.bold,
              color: AppColors.riceGreen,
            ),
          ),
        ],
      ),
    );
  }
}
