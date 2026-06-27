import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class InputJadwalTanamScreen extends StatefulWidget {
  const InputJadwalTanamScreen({super.key});

  @override
  State<InputJadwalTanamScreen> createState() => _InputJadwalTanamScreenState();
}

class _InputJadwalTanamScreenState extends State<InputJadwalTanamScreen> {
  // State untuk menyimpan nilai yang dipilih pengguna
  String? _selectedLahan;
  String? _selectedVarietas;
  String? _selectedMetode;
  DateTime? _selectedDate;

  // Data tiruan (Mock Data) untuk pilihan Dropdown
  final List<String> _lahanOptions = ['Sawah Blok A', 'Sawah Blok Utara', 'Lahan Belakang Rumah'];
  final List<String> _varietasOptions = ['Ciherang', 'IR64', 'Inpari 32', 'Membramo'];
  final List<String> _metodeOptions = ['Tanam Benih Langsung (Tabela)', 'Pindah Tanam (Transplanting)'];

  // Fungsi untuk memunculkan kalender (Date Picker)
  Future<void> _selectDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: DateTime.now(),
      firstDate: DateTime(2020),
      lastDate: DateTime(2030),
      builder: (context, child) {
        return Theme(
          data: Theme.of(context).copyWith(
            colorScheme: const ColorScheme.light(
              primary: AppColors.riceGreen, // Warna header kalender
              onPrimary: Colors.white, // Warna teks header
              onSurface: Colors.black87, // Warna angka kalender
            ),
          ),
          child: child!,
        );
      },
    );
    if (picked != null && picked != _selectedDate) {
      setState(() {
        _selectedDate = picked;
      });
    }
  }

  // Fungsi sederhana untuk memformat tanggal ke String
  String _formatDate(DateTime date) {
    List<String> months = [
      'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    return '${date.day} ${months[date.month - 1]} ${date.year}';
  }

  // Fungsi untuk mendapatkan teks estimasi panen
  String _getEstimasiPanen() {
    if (_selectedDate == null || _selectedVarietas == null) {
      return 'Pilih varietas dan tanggal tanam untuk melihat estimasi panen.';
    }
    // Simulasi umur panen rata-rata 115 hari (bisa disesuaikan berdasarkan varietas aslinya)
    int umurPanen = 115;
    DateTime estimasiDate = _selectedDate!.add(Duration(days: umurPanen));
    
    return 'Estimasi Panen: ${_formatDate(estimasiDate)}\n($umurPanen hari setelah tanam)';
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Input Jadwal Tanam', style: TextStyle(fontWeight: FontWeight.bold)),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        elevation: 0,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            Card(
              elevation: 4,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(16),
              ),
              child: Padding(
                padding: const EdgeInsets.all(20),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Row(
                      children: [
                        const Icon(Icons.grass_rounded, color: AppColors.riceGreen, size: 28),
                        const SizedBox(width: 8),
                        Text(
                          'Form Siklus Tanam',
                          style: TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                            color: AppColors.textPrimary ?? Colors.black87,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 24),

                    // 1. Pilihan Lahan (Dropdown)
                    DropdownButtonFormField<String>(
                      isExpanded: true,
                      value: _selectedLahan,
                      decoration: _buildInputDecoration('Pilih Lahan', Icons.landscape_rounded),
                      hint: const Text('Pilih lahan yang akan ditanami'),
                      items: _lahanOptions.map((String value) {
                        return DropdownMenuItem<String>(
                          value: value,
                          child: Text(value),
                        );
                      }).toList(),
                      onChanged: (newValue) {
                        setState(() { _selectedLahan = newValue; });
                      },
                    ),
                    const SizedBox(height: 16),

                    // 2. Jenis/Varietas Padi
                    DropdownButtonFormField<String>(
                      isExpanded: true,
                      value: _selectedVarietas,
                      decoration: _buildInputDecoration('Varietas Padi', Icons.spa_rounded),
                      hint: const Text('Pilih jenis varietas padi'),
                      items: _varietasOptions.map((String value) {
                        return DropdownMenuItem<String>(
                          value: value,
                          child: Text(value),
                        );
                      }).toList(),
                      onChanged: (newValue) {
                        setState(() { _selectedVarietas = newValue; });
                      },
                    ),
                    const SizedBox(height: 16),

                    // 3. Tanggal Mulai Tanam (Date Picker)
                    InkWell(
                      onTap: () => _selectDate(context),
                      child: IgnorePointer(
                        child: TextFormField(
                          decoration: _buildInputDecoration(
                            'Tanggal Tanam', 
                            Icons.calendar_today_rounded,
                            hint: _selectedDate == null ? 'Pilih tanggal mulai tanam' : _formatDate(_selectedDate!),
                          ).copyWith(
                            // Mengubah warna teks hint agar terlihat seperti teks yang diinput jika sudah dipilih
                            hintStyle: TextStyle(
                              color: _selectedDate == null ? Colors.grey.shade600 : Colors.black87,
                            ),
                          ),
                        ),
                      ),
                    ),
                    const SizedBox(height: 16),

                    // 4. Metode Tanam (Opsional)
                    DropdownButtonFormField<String>(
                      isExpanded: true,
                      value: _selectedMetode,
                      decoration: _buildInputDecoration('Metode Tanam (Opsional)', Icons.agriculture_rounded),
                      hint: const Text('Pilih metode tanam'),
                      items: _metodeOptions.map((String value) {
                        return DropdownMenuItem<String>(
                          value: value,
                          child: Text(value),
                        );
                      }).toList(),
                      onChanged: (newValue) {
                        setState(() { _selectedMetode = newValue; });
                      },
                    ),
                    const SizedBox(height: 24),

                    // 5. Kalkulator Estimasi (Preview)
                    Container(
                      width: double.infinity,
                      padding: const EdgeInsets.all(16),
                      decoration: BoxDecoration(
                        color: _selectedDate != null && _selectedVarietas != null 
                            ? AppColors.riceGreen.withOpacity(0.1) 
                            : Colors.grey.shade100,
                        borderRadius: BorderRadius.circular(12),
                        border: Border.all(
                          color: _selectedDate != null && _selectedVarietas != null 
                              ? AppColors.riceGreen.withOpacity(0.3) 
                              : Colors.grey.shade300,
                        ),
                      ),
                      child: Column(
                        children: [
                          Icon(
                            Icons.lightbulb_outline_rounded,
                            color: _selectedDate != null && _selectedVarietas != null 
                                ? AppColors.riceGreen 
                                : Colors.grey.shade500,
                          ),
                          const SizedBox(height: 8),
                          Text(
                            _getEstimasiPanen(),
                            textAlign: TextAlign.center,
                            style: TextStyle(
                              fontWeight: _selectedDate != null && _selectedVarietas != null 
                                  ? FontWeight.bold 
                                  : FontWeight.normal,
                              color: _selectedDate != null && _selectedVarietas != null 
                                  ? Colors.green.shade800 
                                  : Colors.grey.shade600,
                              height: 1.4,
                            ),
                          ),
                        ],
                      ),
                    ),
                    const SizedBox(height: 32),

                    // 6. Tombol Simpan
                    SizedBox(
                      width: double.infinity,
                      height: 54,
                      child: ElevatedButton(
                        onPressed: () {
                          // TODO: Proses simpan data jadwal tanam ke database
                          Navigator.pop(context);
                        },
                        style: ElevatedButton.styleFrom(
                          backgroundColor: AppColors.riceGreen,
                          foregroundColor: AppColors.riceWhite ?? Colors.white,
                          elevation: 0,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                        ),
                        child: const Text(
                          'Simpan Jadwal',
                          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // Fungsi bantuan untuk menstandarkan desain InputDecoration
  InputDecoration _buildInputDecoration(String label, IconData prefixIcon, {String? hint}) {
    return InputDecoration(
      labelText: label,
      hintText: hint,
      prefixIcon: Icon(prefixIcon, color: AppColors.riceGreen),
      labelStyle: TextStyle(color: Colors.grey.shade600, fontSize: 14),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: BorderSide(color: Colors.grey.shade300),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: BorderSide(color: Colors.grey.shade300),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.riceGreen, width: 2),
      ),
      filled: true,
      fillColor: AppColors.surfaceColor ?? Colors.grey.shade50,
      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
    );
  }
}