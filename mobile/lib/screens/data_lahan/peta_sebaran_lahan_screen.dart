import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class PetaSebaranLahanScreen extends StatelessWidget {
  const PetaSebaranLahanScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Peta Sebaran Lahan'),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              Icons.map_outlined,
              size: 80,
              color: AppColors.riceGreen,
            ),
            const SizedBox(height: 16),
            Text(
              'Peta Sebaran Lahan',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
                color: AppColors.textPrimary,
              ),
            ),
            const SizedBox(height: 8),
            Text(
              'Fitur peta akan ditampilkan di sini',
              style: TextStyle(
                color: AppColors.textSecondary,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
