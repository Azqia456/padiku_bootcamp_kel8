import 'package:flutter/material.dart';
import '../../utils/app_colors.dart';

class InputJadwalTanamScreen extends StatefulWidget {
  const InputJadwalTanamScreen({super.key});

  @override
  State<InputJadwalTanamScreen> createState() => _InputJadwalTanamScreenState();
}

class _InputJadwalTanamScreenState extends State<InputJadwalTanamScreen> {
  final _formKey = GlobalKey<FormState>();

  final List<String> _lahanOptions = const [
    'Lahan A (1 Ha)',
    'Lahan B (0.8 Ha)',
    'Lahan C (1.2 Ha)',
  ];
  final List<String> _metodeOptions = const [
    'Tandur (manual)',
    'Jajar Legowo',
    'Tabur benih',
    'Mesin tanam',
  ];

  String? _selectedLahan;
  String? _selectedMetode;
  DateTime? _selectedTanggalTanam;

  late final TextEditingController _tanggalController;
  late final TextEditingController _varietasController;

  @override
  void initState() {
    super.initState();
    _tanggalController = TextEditingController();
    _varietasController = TextEditingController();
  }

  @override
  void dispose() {
    _tanggalController.dispose();
    _varietasController.dispose();
    super.dispose();
  }

  String _formatTanggal(DateTime date) {
    final y = date.year.toString();
    final m = date.month.toString().padLeft(2, '0');
    final d = date.day.toString().padLeft(2, '0');
    return '$y-$m-$d';
  }

  Future<void> _pickTanggalTanam() async {
    final now = DateTime.now();
    final picked = await showDatePicker(
      context: context,
      initialDate: _selectedTanggalTanam ?? now,
      firstDate: DateTime(now.year - 10),
      lastDate: DateTime(now.year + 10),
      helpText: 'Pilih Tanggal Tanam',
    );

    if (picked == null) return;

    setState(() {
      _selectedTanggalTanam = picked;
      _tanggalController.text = _formatTanggal(picked);
    });
  }

  InputDecoration _inputDecoration({
    required String label,
    required IconData icon,
    Widget? suffixIcon,
  }) {
    return InputDecoration(
      labelText: label,
      prefixIcon: Icon(icon),
      suffixIcon: suffixIcon,
      filled: true,
      fillColor: const Color(0xFFF8FBF7),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(16),
        borderSide: BorderSide(color: Colors.green.shade50),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(16),
        borderSide: BorderSide(color: Colors.green.shade100),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(16),
        borderSide: const BorderSide(color: AppColors.riceGreen, width: 1.5),
      ),
    );
  }

  void _onSimpan() {
    final isValid = _formKey.currentState?.validate() ?? false;
    if (!isValid) return;

    _formKey.currentState?.save();

    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Jadwal tanam berhasil disimpan (placeholder).'),
      ),
    );

    Navigator.pop(context);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F7F5),
      appBar: AppBar(
        title: const Text('Input Jadwal Tanam'),
        backgroundColor: AppColors.riceGreen,
        foregroundColor: AppColors.riceWhite,
        elevation: 0,
      ),
      body: SafeArea(
        child: Column(
          children: [
            Expanded(
              child: SingleChildScrollView(
                padding: const EdgeInsets.fromLTRB(16, 16, 16, 8),
                child: Form(
                  key: _formKey,
                  child: Container(
                    padding: const EdgeInsets.all(18),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(22),
                      border: Border.all(color: Colors.green.shade50),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withValues(alpha: 0.05),
                          blurRadius: 16,
                          offset: const Offset(0, 8),
                        ),
                      ],
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'Form Pengisian Jadwal Tanam',
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                            color: Colors.grey.shade900,
                          ),
                        ),
                        const SizedBox(height: 6),
                        Text(
                          'Lengkapi data berikut untuk mencatat jadwal tanam.',
                          style: TextStyle(
                            fontSize: 13,
                            color: Colors.grey.shade600,
                            height: 1.4,
                          ),
                        ),
                        const SizedBox(height: 18),

                        DropdownButtonFormField<String>(
                          initialValue: _selectedLahan,
                          items: _lahanOptions
                              .map(
                                (item) => DropdownMenuItem(
                                  value: item,
                                  child: Text(item),
                                ),
                              )
                              .toList(),
                          onChanged: (val) => _selectedLahan = val,
                          decoration: _inputDecoration(
                            label: 'Pilih Lahan',
                            icon: Icons.landscape_rounded,
                          ),
                          validator: (val) => (val == null || val.isEmpty)
                              ? 'Silakan pilih lahan'
                              : null,
                        ),
                        const SizedBox(height: 14),

                        TextFormField(
                          controller: _tanggalController,
                          readOnly: true,
                          onTap: _pickTanggalTanam,
                          decoration: _inputDecoration(
                            label: 'Tanggal Tanam',
                            icon: Icons.calendar_month_rounded,
                            suffixIcon: IconButton(
                              tooltip: 'Pilih tanggal',
                              onPressed: _pickTanggalTanam,
                              icon: const Icon(Icons.event_rounded),
                            ),
                          ),
                          validator: (val) => (val == null || val.isEmpty)
                              ? 'Silakan pilih tanggal tanam'
                              : null,
                        ),
                        const SizedBox(height: 14),

                        TextFormField(
                          controller: _varietasController,
                          textInputAction: TextInputAction.next,
                          decoration: _inputDecoration(
                            label: 'Varietas Padi',
                            icon: Icons.grass_rounded,
                          ),
                          validator: (val) =>
                              (val == null || val.trim().isEmpty)
                              ? 'Silakan isi varietas padi'
                              : null,
                        ),
                        const SizedBox(height: 14),

                        DropdownButtonFormField<String>(
                          initialValue: _selectedMetode,
                          items: _metodeOptions
                              .map(
                                (item) => DropdownMenuItem(
                                  value: item,
                                  child: Text(item),
                                ),
                              )
                              .toList(),
                          onChanged: (val) => _selectedMetode = val,
                          decoration: _inputDecoration(
                            label: 'Metode Tanam',
                            icon: Icons.construction_rounded,
                          ),
                          validator: (val) => (val == null || val.isEmpty)
                              ? 'Silakan pilih metode tanam'
                              : null,
                        ),
                        const SizedBox(height: 10),

                        if (_selectedTanggalTanam != null)
                          Padding(
                            padding: const EdgeInsets.only(top: 6),
                            child: Text(
                              'Tanggal dipilih: ${_formatTanggal(_selectedTanggalTanam!)}',
                              style: TextStyle(
                                fontSize: 12,
                                color: Colors.grey.shade600,
                              ),
                            ),
                          ),
                      ],
                    ),
                  ),
                ),
              ),
            ),
            SafeArea(
              top: false,
              child: Padding(
                padding: const EdgeInsets.fromLTRB(16, 8, 16, 16),
                child: SizedBox(
                  width: double.infinity,
                  height: 54,
                  child: ElevatedButton(
                    onPressed: _onSimpan,
                    style: ElevatedButton.styleFrom(
                      backgroundColor: AppColors.riceGreen,
                      foregroundColor: Colors.white,
                      elevation: 0,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(18),
                      ),
                    ),
                    child: const Text(
                      'SIMPAN',
                      style: TextStyle(fontWeight: FontWeight.w700),
                    ),
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
