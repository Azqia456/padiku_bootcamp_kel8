import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class KalenderTanamScreen extends StatefulWidget {
  const KalenderTanamScreen({super.key});

  @override
  State<KalenderTanamScreen> createState() => _KalenderTanamScreenState();
}

class _KalenderTanamScreenState extends State<KalenderTanamScreen> {
  // State untuk Filter Lahan
  String _selectedLahan = 'Sawah Blok A';
  final List<String> _lahanOptions = [
    'Sawah Blok A',
    'Sawah Blok Utara',
    'Lahan Belakang Rumah'
  ];

  // State untuk To-Do List
  final List<Map<String, dynamic>> _tasks = [
    {
      'title': 'Pemupukan Tahap 1',
      'subtitle': 'Hari ke-15 (Gunakan Urea)',
      'isDone': true,
      'icon': Icons.eco_rounded,
      'color': Colors.green,
    },
    {
      'title': 'Penyiangan Gulma',
      'subtitle': 'Hari ke-30 (Pembersihan lahan)',
      'isDone': false,
      'icon': Icons.grass_rounded,
      'color': Colors.orange,
    },
    {
      'title': 'Pengeringan Lahan',
      'subtitle': 'Menjelang Panen',
      'isDone': false,
      'icon': Icons.water_drop_outlined,
      'color': Colors.blue,
    },
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey.shade50,
      appBar: AppBar(
        title: const Text('Kalender Tanam', style: TextStyle(fontWeight: FontWeight.bold)),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite ?? Colors.white,
        elevation: 0,
      ),
      // Tombol Mengambang (FAB) untuk Catatan/Log Harian
      floatingActionButton: FloatingActionButton.extended(
        onPressed: () {
          // TODO: Navigasi ke form tambah catatan harian
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Buka form catatan harian...')),
          );
        },
        backgroundColor: AppColors.riceGreen,
        icon: const Icon(Icons.edit_note_rounded, color: Colors.white),
        label: const Text('Catatan', style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold)),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.only(bottom: 80), // Jarak untuk FAB
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // ==========================================
            // 1. FILTER LAHAN
            // ==========================================
            Container(
              color: AppColors.riceGreen,
              padding: const EdgeInsets.fromLTRB(16, 0, 16, 16),
              child: Container(
                padding: const EdgeInsets.symmetric(horizontal: 16),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black.withAlpha(25),
                      blurRadius: 8,
                      offset: const Offset(0, 4),
                    ),
                  ],
                ),
                child: DropdownButtonHideUnderline(
                  child: DropdownButton<String>(
                    isExpanded: true,
                    value: _selectedLahan,
                    icon: const Icon(Icons.arrow_drop_down, color: AppColors.riceGreen),
                    items: _lahanOptions.map((String value) {
                      return DropdownMenuItem<String>(
                        value: value,
                        child: Row(
                          children: [
                            const Icon(Icons.landscape_rounded, color: AppColors.riceGreen, size: 20),
                            const SizedBox(width: 12),
                            Text(value, style: const TextStyle(fontWeight: FontWeight.bold)),
                          ],
                        ),
                      );
                    }).toList(),
                    onChanged: (newValue) {
                      setState(() {
                        _selectedLahan = newValue!;
                      });
                    },
                  ),
                ),
              ),
            ),

            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // ==========================================
                  // 2. GARIS WAKTU FASE PERTUMBUHAN (TIMELINE)
                  // ==========================================
                  _buildSectionTitle('Fase Pertumbuhan Saat Ini'),
                  const SizedBox(height: 12),
                  _buildGrowthTimeline(),
                  const SizedBox(height: 24),

                  // ==========================================
                  // 3. TAMPILAN KALENDER BULANAN
                  // ==========================================
                  _buildSectionTitle('Jadwal Bulan Ini'),
                  const SizedBox(height: 12),
                  _buildMockCalendar(),
                  const SizedBox(height: 24),

                  // ==========================================
                  // 4. DAFTAR TUGAS / PENGINGAT (TO-DO LIST)
                  // ==========================================
                  _buildSectionTitle('Tugas Mendatang'),
                  const SizedBox(height: 12),
                  _buildToDoList(),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  // Bantuan: Judul Seksi
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

  // Bantuan: Garis Waktu Fase Pertumbuhan
  Widget _buildGrowthTimeline() {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      child: Container(
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(16),
          gradient: const LinearGradient(
            colors: [Color(0xFFE8F5E9), Color(0xFFC8E6C9)],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
        ),
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: const [
                    Text(
                      'Fase Vegetatif Maksimal',
                      style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: AppColors.riceGreen),
                    ),
                    SizedBox(height: 4),
                    Text(
                      'Hari ke-45 setelah tanam',
                      style: TextStyle(fontSize: 14, color: Colors.black54),
                    ),
                  ],
                ),
                Container(
                  padding: const EdgeInsets.all(8),
                  decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12)),
                  child: const Icon(Icons.spa_rounded, color: AppColors.riceGreen, size: 28),
                ),
              ],
            ),
            const SizedBox(height: 16),
            // Progress Bar Visual
            ClipRRect(
              borderRadius: BorderRadius.circular(8),
              child: const LinearProgressIndicator(
                value: 45 / 115, // Asumsi 115 hari panen
                minHeight: 10,
                backgroundColor: Colors.white,
                valueColor: AlwaysStoppedAnimation<Color>(AppColors.riceGreen),
              ),
            ),
            const SizedBox(height: 8),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: const [
                Text('Tanam', style: TextStyle(fontSize: 12, color: Colors.black54)),
                Text('Panen (Estimasi: 115 Hari)', style: TextStyle(fontSize: 12, color: Colors.black54)),
              ],
            ),
          ],
        ),
      ),
    );
  }

  // Bantuan: Visual Mockup Kalender
  Widget _buildMockCalendar() {
    const days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            // Header Kalender (Bulan & Tahun)
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                const Icon(Icons.chevron_left_rounded, color: Colors.black54),
                const Text('Juni 2026', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                const Icon(Icons.chevron_right_rounded, color: Colors.black54),
              ],
            ),
            const SizedBox(height: 16),
            // Header Hari
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceAround,
              children: days.map((day) => Text(day, style: TextStyle(color: Colors.grey.shade600, fontWeight: FontWeight.bold, fontSize: 13))).toList(),
            ),
            const SizedBox(height: 12),
            // Grid Tanggal
            GridView.builder(
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 7,
                mainAxisSpacing: 8,
                crossAxisSpacing: 8,
              ),
              itemCount: 30,
              itemBuilder: (context, index) {
                int day = index + 1;
                bool isToday = day == 15; // Contoh hari ini
                bool hasTask = day == 15 || day == 30; // Contoh tanggal penting

                return Container(
                  decoration: BoxDecoration(
                    color: isToday ? AppColors.riceGreen : Colors.transparent,
                    shape: BoxShape.circle,
                    border: hasTask && !isToday ? Border.all(color: Colors.orange, width: 2) : null,
                  ),
                  alignment: Alignment.center,
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text(
                        '$day',
                        style: TextStyle(
                          color: isToday ? Colors.white : Colors.black87,
                          fontWeight: isToday || hasTask ? FontWeight.bold : FontWeight.normal,
                        ),
                      ),
                      if (hasTask) // Titik penanda ada tugas
                        Container(
                          margin: const EdgeInsets.only(top: 2),
                          width: 4,
                          height: 4,
                          decoration: BoxDecoration(
                            color: isToday ? Colors.white : Colors.orange,
                            shape: BoxShape.circle,
                          ),
                        )
                    ],
                  ),
                );
              },
            ),
          ],
        ),
      ),
    );
  }

  // Bantuan: Daftar Tugas / To-Do List
  Widget _buildToDoList() {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      child: ListView.separated(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        itemCount: _tasks.length,
        separatorBuilder: (context, index) => const Divider(height: 1),
        itemBuilder: (context, index) {
          final task = _tasks[index];
          return CheckboxListTile(
            value: task['isDone'],
            onChanged: (bool? value) {
              setState(() {
                task['isDone'] = value ?? false;
              });
            },
            activeColor: AppColors.riceGreen,
            checkboxShape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(4)),
            secondary: Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: (task['color'] as Color).withOpacity(0.1),
                borderRadius: BorderRadius.circular(8),
              ),
              child: Icon(task['icon'], color: task['color'], size: 24),
            ),
            title: Text(
              task['title'],
              style: TextStyle(
                fontWeight: FontWeight.bold,
                decoration: task['isDone'] ? TextDecoration.lineThrough : null,
                color: task['isDone'] ? Colors.grey : Colors.black87,
              ),
            ),
            subtitle: Text(
              task['subtitle'],
              style: TextStyle(
                fontSize: 12,
                decoration: task['isDone'] ? TextDecoration.lineThrough : null,
              ),
            ),
          );
        },
      ),
    );
  }
}