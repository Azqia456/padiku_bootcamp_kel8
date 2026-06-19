import 'package:flutter/material.dart';
import 'utils/app_colors.dart';
import 'utils/routes.dart';
import 'screens/login_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'PADIKU',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primaryColor: AppColors.riceGreen,
        colorScheme: ColorScheme.fromSeed(
          seedColor: AppColors.riceGreen,
          primary: AppColors.riceGreen,
          secondary: AppColors.riceYellow,
        ),
        useMaterial3: true,
        scaffoldBackgroundColor: AppColors.backgroundColor,
        cardColor: AppColors.cardColor,
        appBarTheme: AppBarTheme(
          backgroundColor: AppColors.riceGreen,
          foregroundColor: AppColors.riceWhite,
          elevation: 0,
        ),
      ),
      initialRoute: Routes.login,
      routes: Routes.getRoutes(),
    );
  }
}
