import 'package:flutter/material.dart';

class AppColors {
  // Primary Green Colors
  static const Color hijauUtama = Color(0xFF0A5C34);
  static const Color hijauSekunder = Color(0xFF2E7D32);
  static const Color hijauMuda = Color(0xFF63A52F);
  static const Color hijauHighlight = Color(0xFF8BC34A);
  
  // Gold Colors
  static const Color emasTua = Color(0xFFD9A21B);
  static const Color emasUtama = Color(0xFFF2C230);
  static const Color emasTerang = Color(0xFFFFD54F);
  
  // Neutral Colors
  static const Color abuTeknologi = Color(0xFF6E6E6E);
  static const Color putih = Color(0xFFFFFFFF);
  
  // Background colors
  static const Color backgroundColor = Color(0xFFFFFFFF); // Clean white background
  static const Color cardColor = Color(0xFFFFFFFF);
  static const Color surfaceColor = Color(0xFFF5F5F5);
  
  // Text colors
  static const Color textPrimary = Color(0xFF0A5C34);
  static const Color textSecondary = Color(0xFF6E6E6E);
  static const Color textTertiary = Color(0xFF9E9E9E);
  
  // Accent colors
  static const Color accentColor = hijauUtama;
  static const Color warningColor = emasTua;
  static const Color successColor = hijauUtama;
  static const Color errorColor = Color(0xFFE53935);
  
  // Gradient colors
  static const LinearGradient primaryGradient = LinearGradient(
    colors: [hijauUtama, hijauSekunder],
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
  );
  
  static const LinearGradient goldGradient = LinearGradient(
    colors: [emasTua, emasUtama],
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
  );
  
  // Legacy aliases for backward compatibility
  static const Color riceGreen = hijauUtama;
  static const Color riceDarkGreen = hijauSekunder;
  static const Color riceLightGreen = hijauMuda;
  static const Color riceYellow = emasUtama;
  static const Color riceOrange = emasTua;
  static const Color riceGold = emasTerang;
  static const Color riceWhite = putih;
  static const Color riceCream = Color(0xFFF5F5DC);
  static const Color riceBrown = Color(0xFF8D6E63);
  static const LinearGradient riceGradient = primaryGradient;
  static const LinearGradient harvestGradient = goldGradient;
}
