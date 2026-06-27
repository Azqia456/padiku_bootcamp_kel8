import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';
import '../../utils/routes.dart';

class TambahLahanScreen extends StatefulWidget {
  const TambahLahanScreen({super.key});

  @override
  State<TambahLahanScreen> createState() => _TambahLahanScreenState();
}

class _TambahLahanScreenState extends State<TambahLahanScreen> {
  // State untuk Dropdown
  String _selectedSatuan = 'Hektar';
  String? _selectedPengairan;
  String? _selectedTanah;
  String? _selectedKepemilikan;

  final List<String> _satuanOptions = ['Hektar', 'Meter Persegi (m²)'];
  final List<String> _pengairanOptions = ['Irigasi Teknis', 'Tadah Hujan', 'Sumur Bor/Pompa'];
  final List<String> _tanahOptions = ['Gembur', 'Liat/Lempung', 'Gambut', 'Berpasir'];
  final List<String> _kepemilikanOptions = ['Milik Pribadi', 'Sewa', 'Bagi Hasil'];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Tambah Lahan', style: TextStyle(fontWeight: FontWeight.bold)),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        elevation: 0,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
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
                    // ==========================================
                    // 1. IDENTITAS & LUAS LAHAN
                    // ==========================================
                    _buildSectionTitle('Identitas Lahan', Icons.info_outline),
                    const SizedBox(height: 16),
                    TextFormField(
                      decoration: _buildInputDecoration('Nama/Identitas Lahan', hint: 'Contoh: Sawah Blok Utara'),
                    ),
                    const SizedBox(height: 16),
                    Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Expanded(
                          flex: 1, // Dibagi rata 50%
                          child: TextFormField(
                            keyboardType: TextInputType.number,
                            decoration: _buildInputDecoration('Luas Lahan', hint: '0'),
                          ),
                        ),
                        const SizedBox(width: 12),
                        Expanded(
                          flex: 1, // Dibagi rata 50%
                          child: DropdownButtonFormField<String>(
                            isExpanded: true, // Mencegah error overflow pada dropdown
                            value: _selectedSatuan,
                            decoration: _buildInputDecoration('Satuan'),
                            items: _satuanOptions.map((String value) {
                              return DropdownMenuItem<String>(
                                value: value,
                                child: Text(
                                  value, 
                                  style: const TextStyle(fontSize: 14),
                                  overflow: TextOverflow.ellipsis, // Memotong teks jika terlalu panjang
                                ),
                              );
                            }).toList(),
                            onChanged: (newValue) {
                              setState(() {
                                _selectedSatuan = newValue!;
                              });
                            },
                          ),
                        ),
                      ],
                    ),
                    const Divider(height: 40, thickness: 1),

                    // ==========================================
                    // 2. PEMETAAN & LOKASI LAHAN
                    // ==========================================
                    _buildSectionTitle('Pemetaan & Lokasi', Icons.map_outlined),
                    const SizedBox(height: 16),
                    // Placeholder untuk Google Maps
                    InkWell(
                      onTap: () {
                        Navigator.pushNamed(context, Routes.petaSebaranLahan);
                      },
                      borderRadius: BorderRadius.circular(12),
                      child: Container(
                        width: double.infinity,
                        padding: const EdgeInsets.symmetric(vertical: 24),
                        decoration: BoxDecoration(
                          color: Colors.grey.shade100,
                          borderRadius: BorderRadius.circular(12),
                          border: Border.all(color: Colors.grey.shade300, style: BorderStyle.solid),
                        ),
                        child: Column(
                          children: const [
                            Icon(Icons.location_on, size: 40, color: Colors.redAccent),
                            SizedBox(height: 8),
                            Text(
                              'Pilih Titik Lokasi / Gambar Poligon di Peta',
                              style: TextStyle(fontWeight: FontWeight.w500, color: Colors.black87),
                              textAlign: TextAlign.center,
                            ),
                          ],
                        ),
                      ),
                    ),
                    const SizedBox(height: 16),
                    Row(
                      children: [
                        Expanded(
                          child: TextFormField(
                            decoration: _buildInputDecoration('Kecamatan'),
                          ),
                        ),
                        const SizedBox(width: 12),
                        Expanded(
                          child: TextFormField(
                            decoration: _buildInputDecoration('Desa/Kelurahan'),
                          ),
                        ),
                      ],
                    ),
                    const Divider(height: 40, thickness: 1),

                    // ==========================================
                    // 3. KONDISI LAHAN & KEPEMILIKAN
                    // ==========================================
                    _buildSectionTitle('Detail Tambahan', Icons.eco_outlined),
                    const SizedBox(height: 16),
                    DropdownButtonFormField<String>(
                      isExpanded: true,
                      value: _selectedPengairan,
                      decoration: _buildInputDecoration('Jenis Pengairan'),
                      hint: const Text('Pilih jenis irigasi', overflow: TextOverflow.ellipsis),
                      items: _pengairanOptions.map((String value) {
                        return DropdownMenuItem<String>(
                          value: value,
                          child: Text(value, overflow: TextOverflow.ellipsis),
                        );
                      }).toList(),
                      onChanged: (newValue) {
                        setState(() {
                          _selectedPengairan = newValue;
                        });
                      },
                    ),
                    const SizedBox(height: 16),
                    DropdownButtonFormField<String>(
                      isExpanded: true,
                      value: _selectedTanah,
                      decoration: _buildInputDecoration('Kondisi Tanah'),
                      hint: const Text('Pilih kondisi tanah', overflow: TextOverflow.ellipsis),
                      items: _tanahOptions.map((String value) {
                        return DropdownMenuItem<String>(
                          value: value,
                          child: Text(value, overflow: TextOverflow.ellipsis),
                        );
                      }).toList(),
                      onChanged: (newValue) {
                        setState(() {
                          _selectedTanah = newValue;
                        });
                      },
                    ),
                    const SizedBox(height: 16),
                    DropdownButtonFormField<String>(
                      isExpanded: true,
                      value: _selectedKepemilikan,
                      decoration: _buildInputDecoration('Status Kepemilikan'),
                      hint: const Text('Pilih status lahan', overflow: TextOverflow.ellipsis),
                      items: _kepemilikanOptions.map((String value) {
                        return DropdownMenuItem<String>(
                          value: value,
                          child: Text(value, overflow: TextOverflow.ellipsis),
                        );
                      }).toList(),
                      onChanged: (newValue) {
                        setState(() {
                          _selectedKepemilikan = newValue;
                        });
                      },
                    ),
                    const SizedBox(height: 32),

                    // ==========================================
                    // 4. TOMBOL AKSI
                    // ==========================================
                    SizedBox(
                      width: double.infinity,
                      height: 54,
                      child: ElevatedButton(
                        onPressed: () {
                          // TODO: Proses simpan data ke sistem/API
                          Navigator.pop(context);
                        },
                        style: ElevatedButton.styleFrom(
                          backgroundColor: AppColors.riceGreen,
                          foregroundColor: AppColors.riceWhite,
                          elevation: 0,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                        ),
                        child: const Text(
                          'Tambahkan Lahan',
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

  // Widget bantuan untuk membuat Judul Bagian dengan Ikon
  Widget _buildSectionTitle(String title, IconData icon) {
    return Row(
      children: [
        Icon(icon, color: AppColors.riceGreen, size: 24),
        const SizedBox(width: 8),
        Text(
          title,
          style: const TextStyle(
            fontSize: 18,
            fontWeight: FontWeight.bold,
            color: Colors.black87,
          ),
        ),
      ],
    );
  }

  // Fungsi bantuan untuk menstandarkan desain InputDecoration
  InputDecoration _buildInputDecoration(String label, {String? hint}) {
    return InputDecoration(
      labelText: label,
      hintText: hint,
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
      fillColor: Colors.grey.shade50, // Menggunakan warna abu terang standar
      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
    );
  }
}