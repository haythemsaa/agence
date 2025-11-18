import React from 'react';
import {View, Text, StyleSheet, ScrollView, TouchableOpacity, Image} from 'react-native';
import Icon from 'react-native-vector-icons/Ionicons';
import LinearGradient from 'react-native-linear-gradient';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';
import {useAuth} from '../../hooks/useAuth';

const ProfileScreen = ({navigation}) => {
  const {user, logout} = useAuth();

  const MenuButton = ({icon, title, subtitle, onPress, color = colors.primary}) => (
    <TouchableOpacity style={styles.menuButton} onPress={onPress}>
      <View style={[styles.menuIcon, {backgroundColor: `${color}15`}]}>
        <Icon name={icon} size={24} color={color} />
      </View>
      <View style={styles.menuContent}>
        <Text style={styles.menuTitle}>{title}</Text>
        {subtitle && <Text style={styles.menuSubtitle}>{subtitle}</Text>}
      </View>
      <Icon name="chevron-forward" size={20} color={colors.textSecondary} />
    </TouchableOpacity>
  );

  return (
    <View style={styles.container}>
      <LinearGradient colors={gradients.primary} style={styles.header}>
        <View style={styles.profileCard}>
          <View style={styles.avatarContainer}>
            <Text style={styles.avatarText}>
              {user?.name?.charAt(0).toUpperCase() || 'U'}
            </Text>
          </View>
          <View style={styles.profileInfo}>
            <Text style={styles.profileName}>{user?.name || 'Utilisateur'}</Text>
            <Text style={styles.profileEmail}>{user?.email || 'email@example.com'}</Text>
          </View>
          <TouchableOpacity onPress={() => navigation.navigate('ProfileEdit')}>
            <Icon name="create-outline" size={24} color={colors.white} />
          </TouchableOpacity>
        </View>

        <View style={styles.loyaltyCard}>
          <View style={styles.loyaltyBadge}>
            <Icon name="star" size={20} color={colors.badgeGold} />
            <Text style={styles.loyaltyLevel}>{user?.loyalty_level?.toUpperCase() || 'BRONZE'}</Text>
          </View>
          <View style={styles.loyaltyPoints}>
            <Text style={styles.pointsValue}>{user?.loyalty_points || 0}</Text>
            <Text style={styles.pointsLabel}>Points</Text>
          </View>
        </View>
      </LinearGradient>

      <ScrollView style={styles.content} showsVerticalScrollIndicator={false}>
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Mon Compte</Text>
          <MenuButton
            icon="calendar-outline"
            title="Mes Réservations"
            subtitle="Gérer mes voyages"
            onPress={() => navigation.navigate('Bookings')}
          />
          <MenuButton
            icon="heart-outline"
            title="Mes Favoris"
            subtitle="Hotels et voyages sauvegardés"
            onPress={() => navigation.navigate('Wishlist')}
            color={colors.error}
          />
          <MenuButton
            icon="share-social-outline"
            title="Parrainage"
            subtitle="Gagnez 50 TND par ami"
            onPress={() => navigation.navigate('Referrals')}
            color={colors.success}
          />
        </View>

        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Préférences</Text>
          <MenuButton
            icon="notifications-outline"
            title="Notifications"
            subtitle="Gérer les alertes"
            onPress={() => navigation.navigate('Notifications')}
          />
          <MenuButton
            icon="language-outline"
            title="Langue"
            subtitle="Français"
            onPress={() => {}}
          />
          <MenuButton
            icon="cash-outline"
            title="Devise"
            subtitle="TND - Dinar Tunisien"
            onPress={() => {}}
          />
        </View>

        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Support</Text>
          <MenuButton
            icon="help-circle-outline"
            title="Centre d'aide"
            onPress={() => {}}
          />
          <MenuButton
            icon="chatbubble-ellipses-outline"
            title="Nous contacter"
            onPress={() => {}}
          />
          <MenuButton
            icon="document-text-outline"
            title="Conditions générales"
            onPress={() => {}}
          />
        </View>

        <TouchableOpacity style={styles.logoutButton} onPress={logout}>
          <Icon name="log-out-outline" size={20} color={colors.error} />
          <Text style={styles.logoutText}>Déconnexion</Text>
        </TouchableOpacity>

        <Text style={styles.version}>Version 1.0.0</Text>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {flex: 1, backgroundColor: colors.background},
  header: {paddingTop: spacing.lg, paddingBottom: spacing.xl, paddingHorizontal: spacing.md},
  profileCard: {flexDirection: 'row', alignItems: 'center', marginBottom: spacing.lg},
  avatarContainer: {width: 64, height: 64, borderRadius: borderRadius.round, backgroundColor: colors.white, justifyContent: 'center', alignItems: 'center'},
  avatarText: {fontSize: typography.fontSize.xxxl, fontWeight: typography.fontWeight.bold, color: colors.primary},
  profileInfo: {flex: 1, marginLeft: spacing.md},
  profileName: {fontSize: typography.fontSize.xl, fontWeight: typography.fontWeight.bold, color: colors.white},
  profileEmail: {fontSize: typography.fontSize.md, color: colors.white, opacity: 0.9, marginTop: spacing.xs},
  loyaltyCard: {flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', backgroundColor: 'rgba(255,255,255,0.2)', padding: spacing.md, borderRadius: borderRadius.lg},
  loyaltyBadge: {flexDirection: 'row', alignItems: 'center'},
  loyaltyLevel: {fontSize: typography.fontSize.lg, fontWeight: typography.fontWeight.bold, color: colors.white, marginLeft: spacing.sm},
  loyaltyPoints: {alignItems: 'flex-end'},
  pointsValue: {fontSize: typography.fontSize.xxl, fontWeight: typography.fontWeight.bold, color: colors.white},
  pointsLabel: {fontSize: typography.fontSize.sm, color: colors.white, opacity: 0.9},
  content: {flex: 1},
  section: {marginTop: spacing.lg, paddingHorizontal: spacing.md},
  sectionTitle: {fontSize: typography.fontSize.lg, fontWeight: typography.fontWeight.bold, color: colors.textPrimary, marginBottom: spacing.md},
  menuButton: {flexDirection: 'row', alignItems: 'center', backgroundColor: colors.white, padding: spacing.md, borderRadius: borderRadius.lg, marginBottom: spacing.sm, ...shadows.sm},
  menuIcon: {width: 48, height: 48, borderRadius: borderRadius.md, justifyContent: 'center', alignItems: 'center', marginRight: spacing.md},
  menuContent: {flex: 1},
  menuTitle: {fontSize: typography.fontSize.md, fontWeight: typography.fontWeight.medium, color: colors.textPrimary},
  menuSubtitle: {fontSize: typography.fontSize.sm, color: colors.textSecondary, marginTop: 2},
  logoutButton: {flexDirection: 'row', alignItems: 'center', justifyContent: 'center', backgroundColor: colors.white, padding: spacing.md, borderRadius: borderRadius.lg, marginHorizontal: spacing.md, marginTop: spacing.xl, ...shadows.sm},
  logoutText: {fontSize: typography.fontSize.md, fontWeight: typography.fontWeight.bold, color: colors.error, marginLeft: spacing.sm},
  version: {textAlign: 'center', fontSize: typography.fontSize.sm, color: colors.textSecondary, marginTop: spacing.lg, marginBottom: spacing.xxl},
});

export default ProfileScreen;
