import React from 'react';
import {createNativeStackNavigator} from '@react-navigation/native-stack';
import TabNavigator from './TabNavigator';
import AuthNavigator from './AuthNavigator';
import HotelDetailsScreen from '../screens/Hotels/HotelDetailsScreen';
import PackageDetailsScreen from '../screens/Packages/PackageDetailsScreen';
import SearchScreen from '../screens/Search/SearchScreen';
import BookingScreen from '../screens/Booking/BookingScreen';
import PaymentScreen from '../screens/Payment/PaymentScreen';
import BookingConfirmationScreen from '../screens/Booking/BookingConfirmationScreen';
import ProfileEditScreen from '../screens/Profile/ProfileEditScreen';
import WishlistScreen from '../screens/Wishlist/WishlistScreen';
import NotificationsScreen from '../screens/Notifications/NotificationsScreen';
import {useAuth} from '../hooks/useAuth';

const Stack = createNativeStackNavigator();

const RootNavigator = () => {
  const {isAuthenticated, loading} = useAuth();

  if (loading) {
    // Show splash screen
    return null;
  }

  return (
    <Stack.Navigator
      screenOptions={{
        headerShown: false,
        animation: 'slide_from_right',
      }}>
      {!isAuthenticated ? (
        <Stack.Screen name="Auth" component={AuthNavigator} />
      ) : (
        <>
          <Stack.Screen name="Main" component={TabNavigator} />
          <Stack.Screen
            name="HotelDetails"
            component={HotelDetailsScreen}
            options={{
              headerShown: true,
              title: 'Détails de l\'hôtel',
            }}
          />
          <Stack.Screen
            name="PackageDetails"
            component={PackageDetailsScreen}
            options={{
              headerShown: true,
              title: 'Détails du voyage',
            }}
          />
          <Stack.Screen
            name="Search"
            component={SearchScreen}
            options={{
              headerShown: true,
              title: 'Rechercher',
            }}
          />
          <Stack.Screen
            name="Booking"
            component={BookingScreen}
            options={{
              headerShown: true,
              title: 'Réservation',
            }}
          />
          <Stack.Screen
            name="Payment"
            component={PaymentScreen}
            options={{
              headerShown: true,
              title: 'Paiement',
            }}
          />
          <Stack.Screen
            name="BookingConfirmation"
            component={BookingConfirmationScreen}
            options={{
              headerShown: false,
            }}
          />
          <Stack.Screen
            name="ProfileEdit"
            component={ProfileEditScreen}
            options={{
              headerShown: true,
              title: 'Modifier le profil',
            }}
          />
          <Stack.Screen
            name="Wishlist"
            component={WishlistScreen}
            options={{
              headerShown: true,
              title: 'Mes favoris',
            }}
          />
          <Stack.Screen
            name="Notifications"
            component={NotificationsScreen}
            options={{
              headerShown: true,
              title: 'Notifications',
            }}
          />
        </>
      )}
    </Stack.Navigator>
  );
};

export default RootNavigator;
