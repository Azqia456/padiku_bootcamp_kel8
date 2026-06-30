import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class PetaSebaranLahanScreen extends StatelessWidget {
  const PetaSebaranLahanScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // AppBar tetap ada di atas
      appBar: AppBar(
        title: const Text('Peta Sebaran Lahan'),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
      ),
      // Gunakan LayoutBuilder untuk mendapatkan tinggi sisa layar secara akurat
      body: LayoutBuilder(
        builder: (context, constraints) {
          return InteractiveViewer(
            // Membatasi agar tidak bisa zoom in/out
            minScale: 1.0,
            maxScale: 1.0, 
            // Hanya izinkan pergeseran horizontal (pan)
            panEnabled: true,
            // Membatasi pergeseran vertikal agar tidak bisa naik/turun
            // Kita set false, namun untuk memastikan, kita gunakan child yang lebar
            constrained: false, 
            child: SizedBox(
              // Atur lebar lebih besar dari layar agar bisa digeser
              width: MediaQuery.of(context).size.width * 2, 
              height: constraints.maxHeight,
              child: Image.asset(
                'assets/images/peta_sawah_mobile.png',
                // BoxFit.cover memastikan gambar memenuhi tinggi layar
                fit: BoxFit.cover, 
              ),
            ),
          );
        },
      ),
    );
  }
}