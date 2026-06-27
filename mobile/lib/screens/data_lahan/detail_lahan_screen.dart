import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class DetailLahanScreen extends StatelessWidget {
  const DetailLahanScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Detail Lahan', style: TextStyle(fontWeight: FontWeight.bold)),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        elevation: 0,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // ==========================================
            // 1. PROFIL SINGKAT LAHAN & MINI MAP
            // ==========================================
            Card(
              elevation: 4,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(16),
              ),
              clipBehavior: Clip.antiAlias,
              child: Column(
                children: [
                  // Placeholder Mini Map
                  Container(
                    height: 120,
                    width: double.infinity,
                    color: Colors.grey.shade200,
                    child: Stack(
                      alignment: Alignment.center,
                      children: [
                        Icon(Icons.map, size: 60, color: Colors.grey.shade400),
                        const Positioned(
                          child: Icon(Icons.location_on, size: 40, color: Colors.redAccent),
                        ),
                      ],
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(16),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            const Text(
                              'Sawah Blok Utara',
                              style: TextStyle(
                                fontSize: 20,
                                fontWeight: FontWeight.bold,
                                color: Colors.black87,
                              ),
                            ),
                            const SizedBox(height: 4),
                            Text(
                              'Desa Sukamakmur, Kec. Telukjambe',
                              style: TextStyle(
                                fontSize: 13,
                                color: Colors.grey.shade600,
                              ),
                            ),
                          ],
                        ),
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                          decoration: BoxDecoration(
                            color: AppColors.riceGreen.withOpacity(0.1),
                            borderRadius: BorderRadius.circular(8),
                          ),
                          child: const Text(
                            '2.5 Ha',
                            style: TextStyle(
                              fontWeight: FontWeight.bold,
                              color: AppColors.riceGreen,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 16),

            // ==========================================
            // 2. STATUS PERTANIAN SAAT INI
            // ==========================================
            _buildSectionTitle('Status Saat Ini'),
            const SizedBox(height: 12),
            Card(
              elevation: 2,
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
              child: ListTile(
                leading: Container(
                  padding: const EdgeInsets.all(10),
                  decoration: BoxDecoration(
                    color: Colors.amber.withOpacity(0.2),
                    shape: BoxShape.circle,
                  ),
                  child: const Icon(Icons.grass, color: Colors.amber, size: 24),
                ),
                title: const Text(
                  'Fase Vegetatif',
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
                ),
                subtitle: const Text('Tanaman sedang dalam masa pertumbuhan daun dan batang.'),
                trailing: const Icon(Icons.info_outline, color: AppColors.riceGreen),
              ),
            ),
            const SizedBox(height: 20),

            // ==========================================
            // 3. INFORMASI KOMODITAS
            // ==========================================
            _buildSectionTitle('Informasi Komoditas'),
            const SizedBox(height: 12),
            Card(
              elevation: 2,
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
              child: Padding(
                padding: const EdgeInsets.all(16),
                child: Column(
                  children: [
                    _buildInfoRow('Varietas Padi', 'IR64 (Ciherang)'),
                    const Divider(height: 24),
                    _buildInfoRow('Tanggal Tanam', '15 Januari 2026'),
                    const Divider(height: 24),
                    _buildInfoRow('Estimasi Panen', '15 April 2026'),
                  ],
                ),
              ),
            ),
            const SizedBox(height: 20),

            // ==========================================
            // 4. RIWAYAT AKTIVITAS (LOG)
            // ==========================================
            _buildSectionTitle('Riwayat Aktivitas'),
            const SizedBox(height: 12),
            Card(
              elevation: 2,
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
              child: Padding(
                padding: const EdgeInsets.symmetric(vertical: 8),
                child: Column(
                  children: [
                    _buildTimelineItem(
                      date: '10 Feb 2026',
                      title: 'Pemberian Pupuk Urea',
                      subtitle: 'Subsidi Tahap 1 - 50 Kg',
                      icon: Icons.eco,
                      iconColor: Colors.green,
                    ),
                    _buildTimelineItem(
                      date: '02 Feb 2026',
                      title: 'Laporan Hama Dibuat',
                      subtitle: 'Indikasi Hama Wereng Coklat',
                      icon: Icons.bug_report,
                      iconColor: Colors.orange,
                    ),
                    _buildTimelineItem(
                      date: '15 Jan 2026',
                      title: 'Mulai Tanam',
                      subtitle: 'Status lahan diubah menjadi aktif',
                      icon: Icons.flag,
                      iconColor: Colors.blue,
                      isLast: true,
                    ),
                  ],
                ),
              ),
            ),
            const SizedBox(height: 24),

            // ==========================================
            // 5. MENU TINDAKAN
            // ==========================================
            Row(
              children: [
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: () {
                      // TODO: Navigasi ke form edit
                    },
                    icon: const Icon(Icons.edit),
                    label: const Text('Edit Lahan'),
                    style: OutlinedButton.styleFrom(
                      foregroundColor: AppColors.riceGreen,
                      side: const BorderSide(color: AppColors.riceGreen),
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(10),
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: ElevatedButton.icon(
                    onPressed: () {
                      // TODO: Shortcut navigasi ke halaman lapor hama
                    },
                    icon: const Icon(Icons.bug_report),
                    label: const Text('Lapor Hama'),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.orange,
                      foregroundColor: Colors.white,
                      elevation: 0,
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(10),
                      ),
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            SizedBox(
              width: double.infinity,
              child: TextButton.icon(
                onPressed: () {
                  // TODO: Konfirmasi hapus lahan
                },
                icon: const Icon(Icons.delete_outline),
                label: const Text('Hapus Lahan dari Sistem'),
                style: TextButton.styleFrom(
                  foregroundColor: Colors.red,
                  padding: const EdgeInsets.symmetric(vertical: 14),
                ),
              ),
            ),
            const SizedBox(height: 24),
          ],
        ),
      ),
    );
  }

  // Widget Bantuan: Judul Bagian
  Widget _buildSectionTitle(String title) {
    return Text(
      title,
      style: const TextStyle(
        fontSize: 18,
        fontWeight: FontWeight.bold,
        color: Colors.black87,
      ),
    );
  }

  // Widget Bantuan: Baris Informasi
  Widget _buildInfoRow(String label, String value) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(
          label,
          style: TextStyle(
            color: Colors.grey.shade600,
            fontSize: 14,
          ),
        ),
        Text(
          value,
          style: const TextStyle(
            fontWeight: FontWeight.bold,
            color: Colors.black87,
            fontSize: 14,
          ),
        ),
      ],
    );
  }

  // Widget Bantuan: Item Riwayat (Timeline)
  Widget _buildTimelineItem({
    required String date,
    required String title,
    required String subtitle,
    required IconData icon,
    required Color iconColor,
    bool isLast = false,
  }) {
    return IntrinsicHeight(
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Column(
              children: [
                Container(
                  padding: const EdgeInsets.all(8),
                  decoration: BoxDecoration(
                    color: iconColor.withOpacity(0.1),
                    shape: BoxShape.circle,
                  ),
                  child: Icon(icon, color: iconColor, size: 20),
                ),
                if (!isLast)
                  Expanded(
                    child: Container(
                      width: 2,
                      color: Colors.grey.shade200,
                      margin: const EdgeInsets.symmetric(vertical: 4),
                    ),
                  ),
              ],
            ),
          ),
          Expanded(
            child: Padding(
              padding: const EdgeInsets.only(bottom: 24, right: 16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    date,
                    style: TextStyle(
                      fontSize: 12,
                      color: AppColors.riceGreen,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    title,
                    style: const TextStyle(
                      fontSize: 15,
                      fontWeight: FontWeight.bold,
                      color: Colors.black87,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    subtitle,
                    style: TextStyle(
                      fontSize: 13,
                      color: Colors.grey.shade600,
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
}