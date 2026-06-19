import 'package:flutter/material.dart';

class AppColors {
  // Rice/Paddy themed colors
  static const Color riceGreen = Color(0xFF4CAF50); // Green like healthy rice plants
  static const Color riceDarkGreen = Color(0xFF2E7D32); // Dark green for mature rice
  static const Color riceLightGreen = Color(0xFF81C784); // Light green for young rice
  static const Color riceYellow = Color(0xFFFFC107); // Yellow like ripening rice
  static const Color riceOrange = Color(0xFFFF9800); // Orange like golden rice
  static const Color riceGold = Color(0xFFFFD54F); // Gold color
  static const Color riceWhite = Color(0xFFFFFFFF); // White like rice grains
  static const Color riceCream = Color(0xFFF5F5DC); // Cream color
  static const Color riceBrown = Color(0xFF8D6E63); // Brown like rice husks
  
  // Background colors
  static const Color backgroundColor = Color(0xFFF5F9F5); // Light greenish background
  static const Color cardColor = Color(0xFFFFFFFF);
  static const Color surfaceColor = Color(0xFFE8F5E9);
  
  // Text colors
  static const Color textPrimary = Color(0xFF1B5E20);
  static const Color textSecondary = Color(0xFF4E342E);
  static const Color textTertiary = Color(0xFF757575);
  
  // Accent colors
  static const Color accentColor = riceGreen;
  static const Color warningColor = riceOrange;
  static const Color successColor = riceGreen;
  static const Color errorColor = Color(0xFFE53935);
  
  // Gradient colors
  static const LinearGradient riceGradient = LinearGradient(
    colors: [riceGreen, riceLightGreen],
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
  );
  
  static const LinearGradient harvestGradient = LinearGradient(
    colors: [riceYellow, riceOrange],
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
  );
}
