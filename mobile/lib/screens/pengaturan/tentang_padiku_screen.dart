import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class TentangPadikuScreen extends StatelessWidget {
  const TentangPadikuScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.surfaceColor,
      appBar: AppBar(
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        title: const Text('Tentang Aplikasi'),
        centerTitle: true,
      ),
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              const SizedBox(height: 8),
              Container(
                width: 96,
                height: 96,
                decoration: BoxDecoration(
                  color: AppColors.riceWhite,
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Center(
                  child: Icon(Icons.eco, color: AppColors.riceGreen, size: 48),
                ),
              ),
              const SizedBox(height: 12),
              Text('PADIKU', style: TextStyle(fontSize: 22, fontWeight: FontWeight.w800, color: AppColors.textPrimary)),
              const SizedBox(height: 6),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
                decoration: BoxDecoration(color: AppColors.riceWhite, borderRadius: BorderRadius.circular(12)),
                child: Text('Versi 2.4.0 (Stabil)', style: TextStyle(color: AppColors.textSecondary, fontWeight: FontWeight.w600, fontSize: 12)),
              ),
              const SizedBox(height: 20),

              // Misi Kami card
              Container(
                width: double.infinity,
                padding: const EdgeInsets.all(16),
                decoration: BoxDecoration(color: AppColors.riceWhite, borderRadius: BorderRadius.circular(14)),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Row(
                      children: [
                        Container(
                          padding: const EdgeInsets.all(8),
                          decoration: BoxDecoration(color: AppColors.riceGreen.withAlpha(30), borderRadius: BorderRadius.circular(10)),
                          child: Icon(Icons.flag, color: AppColors.riceGreen),
                        ),
                        const SizedBox(width: 12),
                        Text('Misi Kami', style: TextStyle(fontWeight: FontWeight.w700, color: AppColors.textPrimary)),
                      ],
                    ),
                    const SizedBox(height: 12),
                    Text(
                      'Padiku hadir untuk mendampingi setiap langkah petani Indonesia melalui teknologi digital yang cerdas dan mudah digunakan. Kami berkomitmen untuk meningkatkan produktivitas dan kesejahteraan petani di seluruh pelosok negeri.',
                      style: TextStyle(color: AppColors.textSecondary, height: 1.4),
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 20),
              // Informasi Hukum
              Container(
                width: double.infinity,
                padding: const EdgeInsets.symmetric(horizontal: 6),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text('INFORMASI HUKUM', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700, color: AppColors.textPrimary)),
                    const SizedBox(height: 8),
                    Card(
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                      child: Column(
                        children: [
                          ListTile(
                            title: const Text('Kebijakan Privasi'),
                            trailing: const Icon(Icons.chevron_right),
                            onTap: () {},
                          ),
                          const Divider(height: 1),
                          ListTile(
                            title: const Text('Syarat dan Ketentuan'),
                            trailing: const Icon(Icons.chevron_right),
                            onTap: () {},
                          ),
                          const Divider(height: 1),
                          ListTile(
                            title: const Text('Lisensi Open Source'),
                            trailing: const Icon(Icons.chevron_right),
                            onTap: () {},
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 20),
              // Image
              ClipRRect(
                borderRadius: BorderRadius.circular(12),
                child: Container(
                  height: 150,
                  width: double.infinity,
                  color: AppColors.riceWhite,
                  child: Image.asset(
                    'assets/images/about_banner.jpg',
                    fit: BoxFit.cover,
                    errorBuilder: (context, error, stack) => Container(color: Colors.grey[200]),
                  ),
                ),
              ),

              const SizedBox(height: 24),
            ],
          ),
        ),
      ),
    );
  }
}
