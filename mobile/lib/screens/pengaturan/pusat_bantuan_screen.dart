import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class PusatBantuanScreen extends StatelessWidget {
  const PusatBantuanScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.surfaceColor,
      appBar: AppBar(
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        title: const Text('Pusat Bantuan'),
        centerTitle: true,
      ),
      body: SafeArea(
        bottom: false,
        child: SingleChildScrollView(
          padding: const EdgeInsets.fromLTRB(16, 16, 16, 24),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _buildSearchBox(),
              const SizedBox(height: 16),
              _buildHeroCard(),
              const SizedBox(height: 18),
              Text('Kategori Bantuan', style: TextStyle(fontSize: 14, fontWeight: FontWeight.w700, color: AppColors.textPrimary)),
              const SizedBox(height: 12),
              _buildCategoryGrid(),
              const SizedBox(height: 18),
              Text('Sering Ditanyakan', style: TextStyle(fontSize: 14, fontWeight: FontWeight.w700, color: AppColors.textPrimary)),
              const SizedBox(height: 8),
              _buildFaqAccordion(),
              const SizedBox(height: 18),
              Text('Informasi Pupuk', style: TextStyle(fontSize: 14, fontWeight: FontWeight.w700, color: AppColors.textPrimary)),
              const SizedBox(height: 8),
              _buildInfoAccordion(),
              const SizedBox(height: 18),
              _buildContactCard(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildSearchBox() {
    return Material(
      color: AppColors.riceWhite,
      borderRadius: BorderRadius.circular(12),
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
        child: Row(
          children: [
            const Icon(Icons.search, color: Colors.grey),
            const SizedBox(width: 8),
            Expanded(
              child: TextField(
                decoration: InputDecoration.collapsed(hintText: 'Cari bantuan...'),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildHeroCard() {
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: AppColors.riceGreen,
        borderRadius: BorderRadius.circular(12),
      ),
      child: Row(
        children: [
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text('Butuh bantuan hari ini?', style: TextStyle(color: AppColors.riceWhite, fontWeight: FontWeight.w700)),
                const SizedBox(height: 6),
                Text('Kami siap membantu melalui chat atau WhatsApp', style: TextStyle(color: AppColors.riceWhite.withAlpha(220), fontSize: 12)),
              ],
            ),
          ),
          const SizedBox(width: 12),
          Container(
            width: 72,
            height: 56,
            decoration: BoxDecoration(color: AppColors.riceWhite.withAlpha(24), borderRadius: BorderRadius.circular(8)),
            child: const Icon(Icons.support_agent, color: Colors.white, size: 34),
          ),
        ],
      ),
    );
  }

  Widget _buildCategoryGrid() {
    final items = [
      {'title': 'Akun Saya', 'icon': Icons.person},
      {'title': 'Panduan Tanam', 'icon': Icons.menu_book},
      {'title': 'Lapor Hama', 'icon': Icons.bug_report},
      {'title': 'Pupuk Bersubsidi', 'icon': Icons.local_shipping},
    ];
    return GridView.builder(
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      // Mengubah childAspectRatio menjadi 2.8 agar ada ruang vertikal jika teks menjadi 2 baris
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 2,
        mainAxisSpacing: 12,
        crossAxisSpacing: 12,
        childAspectRatio: 2.8,
      ),
      itemCount: items.length,
      itemBuilder: (context, index) {
        final it = items[index];
        return Material(
          color: AppColors.riceWhite,
          borderRadius: BorderRadius.circular(12),
          child: InkWell(
            borderRadius: BorderRadius.circular(12),
            onTap: () {
              if (it['title'] == 'Akun Saya') Navigator.pushNamed(context, '/pengaturan/profil');
              if (it['title'] == 'Lapor Hama') Navigator.pushNamed(context, '/lapor/hama');
            },
            child: Padding(
              padding: const EdgeInsets.symmetric(horizontal: 12),
              child: Row(
                children: [
                  Container(
                    width: 36,
                    height: 36,
                    decoration: BoxDecoration(
                      color: const Color(0xFFE8F5E9),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Icon(it['icon'] as IconData, color: AppColors.riceGreen, size: 20),
                  ),
                  const SizedBox(width: 10),
                  // Membungkus Text dengan Expanded untuk mencegah overflow
                  Expanded(
                    child: Text(
                      it['title'] as String,
                      style: TextStyle(
                        color: AppColors.textPrimary,
                        fontWeight: FontWeight.w600,
                        fontSize: 13, // Sedikit disesuaikan agar proporsional
                      ),
                      maxLines: 2, // Mengizinkan teks menjadi maksimal 2 baris
                      overflow: TextOverflow.ellipsis, // Menambahkan titik-titik jika masih terlalu panjang
                    ),
                  ),
                ],
              ),
            ),
          ),
        );
      },
    );
  }

  Widget _buildFaqAccordion() {
    final faqs = [
      {'q': 'Bagaimana cara mendaftar?', 'a': 'Anda dapat mendaftar menggunakan email atau nomor telepon...'},
      {'q': 'Bagaimana cara lapor hama?', 'a': 'Masuk ke menu Lapor, isi form dan kirim foto...'},
      {'q': 'Lupa kata sandi?', 'a': 'Gunakan fitur lupa kata sandi pada layar login.'},
    ];
    return Column(
      children: faqs.map((f) {
        return Card(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          child: ExpansionTile(
            title: Text(f['q']!, style: TextStyle(fontWeight: FontWeight.w600, color: AppColors.textPrimary)),
            children: [Padding(padding: const EdgeInsets.all(12), child: Text(f['a']!, style: TextStyle(color: AppColors.textSecondary)))],
          ),
        );
      }).toList(),
    );
  }

  Widget _buildInfoAccordion() {
    final items = [
      {'q': 'Distribusi Pupuk', 'a': 'Info distribusi...'},
      {'q': 'Jadwal Penyaluran', 'a': 'Info jadwal...'},
    ];
    return Column(
      children: items.map((f) {
        return Card(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          child: ExpansionTile(
            title: Text(f['q']!, style: TextStyle(fontWeight: FontWeight.w600, color: AppColors.textPrimary)),
            children: [Padding(padding: const EdgeInsets.all(12), child: Text(f['a']!, style: TextStyle(color: AppColors.textSecondary)))],
          ),
        );
      }).toList(),
    );
  }

  Widget _buildContactCard() {
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(color: AppColors.riceWhite, borderRadius: BorderRadius.circular(12)),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text('Hubungi Kami', style: TextStyle(fontWeight: FontWeight.w700, color: AppColors.textPrimary)),
          const SizedBox(height: 8),
          Row(
            children: [
              Expanded(
                child: ElevatedButton.icon(
                  onPressed: () {},
                  icon: const Icon(Icons.chat_bubble_outline),
                  label: const Text('Live Chat'),
                  style: ElevatedButton.styleFrom(backgroundColor: AppColors.riceGreen, foregroundColor: AppColors.riceWhite),
                ),
              ),
              const SizedBox(width: 10),
              Expanded(
                child: OutlinedButton.icon(
                  onPressed: () {},
                  icon: const Icon(Icons.phone),
                  label: const Text('WhatsApp'),
                  style: OutlinedButton.styleFrom(foregroundColor: AppColors.riceGreen, side: BorderSide(color: AppColors.riceGreen)),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }
}