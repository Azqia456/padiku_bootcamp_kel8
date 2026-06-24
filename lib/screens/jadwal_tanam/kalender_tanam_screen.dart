import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class KalenderTanamScreen extends StatelessWidget {
  const KalenderTanamScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F7F5),
      appBar: AppBar(
        title: const Text('Kalender Tanam'),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        elevation: 0,
      ),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 24),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(Icons.calendar_month, size: 86, color: AppColors.riceGreen),
              const SizedBox(height: 18),
              Text(
                'Kalender Tanam',
                style: TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.bold,
                  color: Colors.grey.shade900,
                ),
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 10),
              Text(
                'Kalender tanam akan ditampilkan di sini',
                style: TextStyle(
                  fontSize: 14,
                  color: Colors.grey.shade600,
                  height: 1.4,
                ),
                textAlign: TextAlign.center,
              ),
            ],
          ),
        ),
      ),
    );
  }
}
