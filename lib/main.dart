import 'package:flutter/material.dart';
import 'package:device_frame/device_frame.dart';
import 'utils/app_colors.dart';
import 'utils/routes.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return Directionality(
      textDirection: TextDirection.ltr,
      child: DeviceFrame(
        device: Devices.android.samsungGalaxyS20,
        orientation: Orientation.portrait,
        screen: MaterialApp(
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
        ),
      ),
    );
  }
}
