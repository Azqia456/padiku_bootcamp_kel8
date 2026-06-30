import 'dart:convert';
import 'dart:io' show Platform;
import 'package:flutter/foundation.dart' show kIsWeb;
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ApiService {
  static String get baseUrl {
    if (kIsWeb) {
      return 'http://127.0.0.1:8000/api';
    }
    if (Platform.isAndroid) {
      return 'http://10.0.2.2:8000/api';
    }
    return 'http://127.0.0.1:8000/api';
  }

  static Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('auth_token');
  }

  static Future<int?> getUserId() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getInt('user_id');
  }

  static Future<String?> getUserName() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('user_name');
  }

  static Future<Map<String, String>> getUserProfile() async {
    final prefs = await SharedPreferences.getInstance();
    return {
      'name': prefs.getString('user_name') ?? 'Profil Pengguna',
      'email': prefs.getString('user_email') ?? '-',
      'phone': prefs.getString('user_phone') ?? '-',
      'location': prefs.getString('user_location') ?? '-',
      'total_laporan': prefs.getInt('user_total_laporan')?.toString() ?? '0',
      'lahan_aktif': prefs.getDouble('user_lahan_aktif')?.toString() ?? '0',
    };
  }

  static Future<Map<String, dynamic>> login(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({'email': email, 'password': password}),
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 200 && data['success'] == true) {
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('auth_token', data['data']['token']);
        await prefs.setInt('user_id', data['data']['user']['id']);
        await prefs.setString('user_name', data['data']['user']['name'] ?? 'Profil Pengguna');
        await prefs.setString('user_email', data['data']['user']['email'] ?? '-');
        await prefs.setString('user_phone', data['data']['user']['phone'] ?? '-');
        await prefs.setString('user_location', '${data['data']['user']['district'] ?? ''}, ${data['data']['user']['address'] ?? ''}');

        if (data['data']['stats'] != null) {
          await prefs.setInt('user_total_laporan', data['data']['stats']['total_laporan'] ?? 0);
          await prefs.setDouble('user_lahan_aktif', (data['data']['stats']['lahan_aktif'] ?? 0).toDouble());
        }

        return {'success': true, 'message': data['message']};
      } else {
        return {'success': false, 'message': data['message'] ?? 'Login gagal'};
      }
    } catch (e) {
      return {'success': false, 'message': 'Koneksi bermasalah: $e'};
    }
  }

  static Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    await prefs.remove('user_id');
  }

  static Future<Map<String, dynamic>> submitPlanting(Map<String, dynamic> plantingData) async {
    try {
      final token = await getToken();
      final userId = await getUserId();
      
      if (token == null || userId == null) {
        return {'success': false, 'message': 'Anda belum login'};
      }

      // Add user_id to payload
      plantingData['user_id'] = userId;

      final response = await http.post(
        Uri.parse('$baseUrl/plantings'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode(plantingData),
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 201 || response.statusCode == 200) {
        return {'success': true, 'message': 'Jadwal Tanam berhasil disimpan'};
      } else {
        return {'success': false, 'message': data['message'] ?? 'Gagal menyimpan data'};
      }
    } catch (e) {
      return {'success': false, 'message': 'Koneksi bermasalah: $e'};
    }
  }

  static Future<Map<String, dynamic>> submitPestReport(Map<String, dynamic> reportData) async {
    try {
      final token = await getToken();
      final userId = await getUserId();
      
      if (token == null || userId == null) {
        return {'success': false, 'message': 'Anda belum login'};
      }

      // Add user_id to payload
      reportData['user_id'] = userId;

      final response = await http.post(
        Uri.parse('$baseUrl/pest-reports'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode(reportData),
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 201 || response.statusCode == 200) {
        return {'success': true, 'message': 'Laporan hama berhasil dikirim'};
      } else {
        return {'success': false, 'message': data['message'] ?? 'Gagal mengirim laporan'};
      }
    } catch (e) {
      return {'success': false, 'message': 'Koneksi bermasalah: $e'};
    }
  }
}
