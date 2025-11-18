import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  Image,
  Dimensions,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import Icon from 'react-native-vector-icons/Ionicons';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius} from '../../theme/styles';

const {width, height} = Dimensions.get('window');

const WelcomeScreen = ({navigation}) => {
  return (
    <LinearGradient colors={gradients.primary} style={styles.container}>
      {/* Logo and Title */}
      <View style={styles.header}>
        <Icon name="airplane" size={80} color={colors.white} />
        <Text style={styles.title}>VoyageLuxe</Text>
        <Text style={styles.subtitle}>Agence de Voyage Tunisie</Text>
      </View>

      {/* Features */}
      <View style={styles.features}>
        <FeatureItem
          icon="business-outline"
          title="Hôtels de Luxe"
          subtitle="Plus de 500 hôtels en Tunisie"
        />
        <FeatureItem
          icon="map-outline"
          title="Voyages Organisés"
          subtitle="Circuits, Omra et plus"
        />
        <FeatureItem
          icon="star-outline"
          title="Service Premium"
          subtitle="15+ ans d'expérience"
        />
      </View>

      {/* Buttons */}
      <View style={styles.buttons}>
        <TouchableOpacity
          style={styles.loginButton}
          onPress={() => navigation.navigate('Login')}
          activeOpacity={0.8}>
          <Text style={styles.loginButtonText}>Se Connecter</Text>
        </TouchableOpacity>

        <TouchableOpacity
          style={styles.registerButton}
          onPress={() => navigation.navigate('Register')}
          activeOpacity={0.8}>
          <Text style={styles.registerButtonText}>Créer un Compte</Text>
        </TouchableOpacity>

        <TouchableOpacity
          onPress={() => {
            /* Navigate to guest mode or home */
          }}>
          <Text style={styles.skipText}>Continuer sans compte</Text>
        </TouchableOpacity>
      </View>
    </LinearGradient>
  );
};

const FeatureItem = ({icon, title, subtitle}) => (
  <View style={styles.featureItem}>
    <View style={styles.featureIconContainer}>
      <Icon name={icon} size={28} color={colors.primary} />
    </View>
    <View style={styles.featureText}>
      <Text style={styles.featureTitle}>{title}</Text>
      <Text style={styles.featureSubtitle}>{subtitle}</Text>
    </View>
  </View>
);

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: spacing.lg,
  },
  header: {
    flex: 2,
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: spacing.xxl,
  },
  title: {
    fontSize: typography.fontSize.huge,
    fontWeight: typography.fontWeight.bold,
    color: colors.white,
    marginTop: spacing.lg,
    fontFamily: typography.fontFamily.title,
  },
  subtitle: {
    fontSize: typography.fontSize.lg,
    color: colors.white,
    opacity: 0.9,
    marginTop: spacing.sm,
  },
  features: {
    flex: 2,
    justifyContent: 'center',
  },
  featureItem: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: 'rgba(255, 255, 255, 0.15)',
    padding: spacing.md,
    borderRadius: borderRadius.lg,
    marginBottom: spacing.md,
  },
  featureIconContainer: {
    width: 56,
    height: 56,
    borderRadius: borderRadius.round,
    backgroundColor: colors.white,
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: spacing.md,
  },
  featureText: {
    flex: 1,
  },
  featureTitle: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.white,
    marginBottom: spacing.xs,
  },
  featureSubtitle: {
    fontSize: typography.fontSize.md,
    color: colors.white,
    opacity: 0.9,
  },
  buttons: {
    flex: 1,
    justifyContent: 'flex-end',
    paddingBottom: spacing.xl,
  },
  loginButton: {
    backgroundColor: colors.white,
    paddingVertical: spacing.md,
    borderRadius: borderRadius.xl,
    alignItems: 'center',
    marginBottom: spacing.md,
  },
  loginButtonText: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.primary,
  },
  registerButton: {
    backgroundColor: 'transparent',
    paddingVertical: spacing.md,
    borderRadius: borderRadius.xl,
    alignItems: 'center',
    borderWidth: 2,
    borderColor: colors.white,
    marginBottom: spacing.lg,
  },
  registerButtonText: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.white,
  },
  skipText: {
    fontSize: typography.fontSize.md,
    color: colors.white,
    textAlign: 'center',
    textDecorationLine: 'underline',
  },
});

export default WelcomeScreen;
