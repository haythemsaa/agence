import React, {useState, useEffect} from 'react';
import {
  View,
  ScrollView,
  Text,
  StyleSheet,
  RefreshControl,
  TouchableOpacity,
  Image,
  Dimensions,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import Icon from 'react-native-vector-icons/Ionicons';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';
import {api} from '../../services/api';
import HotelCard from '../../components/Cards/HotelCard';
import PackageCard from '../../components/Cards/PackageCard';
import HeroCarousel from '../../components/Home/HeroCarousel';
import SearchBar from '../../components/Search/SearchBar';

const {width} = Dimensions.get('window');

const HomeScreen = ({navigation}) => {
  const [refreshing, setRefreshing] = useState(false);
  const [featuredHotels, setFeaturedHotels] = useState([]);
  const [featuredPackages, setFeaturedPackages] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    loadData();
  }, []);

  const loadData = async () => {
    try {
      setLoading(true);
      const [hotelsData, packagesData] = await Promise.all([
        api.hotels.getFeatured(),
        api.packages.getFeatured(),
      ]);

      setFeaturedHotels(hotelsData.data || []);
      setFeaturedPackages(packagesData.data || []);
    } catch (error) {
      console.error('Error loading data:', error);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  const onRefresh = () => {
    setRefreshing(true);
    loadData();
  };

  const QuickActionCard = ({icon, title, subtitle, gradient, onPress}) => (
    <TouchableOpacity onPress={onPress} style={styles.quickActionCard}>
      <LinearGradient colors={gradient} style={styles.quickActionGradient}>
        <Icon name={icon} size={32} color={colors.white} />
      </LinearGradient>
      <Text style={styles.quickActionTitle}>{title}</Text>
      <Text style={styles.quickActionSubtitle}>{subtitle}</Text>
    </TouchableOpacity>
  );

  return (
    <View style={styles.container}>
      {/* Header */}
      <LinearGradient colors={gradients.primary} style={styles.header}>
        <View style={styles.headerContent}>
          <View>
            <Text style={styles.headerGreeting}>Bonjour 👋</Text>
            <Text style={styles.headerTitle}>Où voulez-vous aller ?</Text>
          </View>
          <TouchableOpacity
            style={styles.notificationButton}
            onPress={() => navigation.navigate('Notifications')}>
            <Icon name="notifications-outline" size={24} color={colors.white} />
            <View style={styles.notificationBadge}>
              <Text style={styles.notificationBadgeText}>3</Text>
            </View>
          </TouchableOpacity>
        </View>

        {/* Search Bar */}
        <SearchBar
          onPress={() => navigation.navigate('Search')}
          placeholder="Rechercher une destination..."
        />
      </LinearGradient>

      <ScrollView
        style={styles.content}
        showsVerticalScrollIndicator={false}
        refreshControl={
          <RefreshControl refreshing={refreshing} onRefresh={onRefresh} />
        }>
        {/* Hero Carousel */}
        <HeroCarousel navigation={navigation} />

        {/* Quick Actions */}
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Services Rapides</Text>
          <View style={styles.quickActionsGrid}>
            <QuickActionCard
              icon="business-outline"
              title="Hôtels"
              subtitle="Réserver"
              gradient={gradients.primary}
              onPress={() => navigation.navigate('Hotels')}
            />
            <QuickActionCard
              icon="map-outline"
              title="Voyages"
              subtitle="Explorer"
              gradient={gradients.secondary}
              onPress={() => navigation.navigate('Packages')}
            />
            <QuickActionCard
              icon="star-outline"
              title="Omra"
              subtitle="Découvrir"
              gradient={gradients.omra}
              onPress={() => navigation.navigate('Packages', {type: 'omra'})}
            />
            <QuickActionCard
              icon="gift-outline"
              title="Cadeaux"
              subtitle="Acheter"
              gradient={gradients.luxury}
              onPress={() => navigation.navigate('Vouchers')}
            />
          </View>
        </View>

        {/* Featured Hotels */}
        <View style={styles.section}>
          <View style={styles.sectionHeader}>
            <Text style={styles.sectionTitle}>Hôtels Populaires</Text>
            <TouchableOpacity onPress={() => navigation.navigate('Hotels')}>
              <Text style={styles.seeAll}>Voir tout →</Text>
            </TouchableOpacity>
          </View>
          <ScrollView
            horizontal
            showsHorizontalScrollIndicator={false}
            contentContainerStyle={styles.horizontalScroll}>
            {featuredHotels.slice(0, 5).map((hotel, index) => (
              <HotelCard
                key={hotel.id}
                hotel={hotel}
                style={[
                  styles.hotelCard,
                  index === 0 && {marginLeft: spacing.md},
                ]}
                onPress={() =>
                  navigation.navigate('HotelDetails', {id: hotel.id})
                }
              />
            ))}
          </ScrollView>
        </View>

        {/* Featured Packages */}
        <View style={styles.section}>
          <View style={styles.sectionHeader}>
            <Text style={styles.sectionTitle}>Voyages Organisés</Text>
            <TouchableOpacity onPress={() => navigation.navigate('Packages')}>
              <Text style={styles.seeAll}>Voir tout →</Text>
            </TouchableOpacity>
          </View>
          <ScrollView
            horizontal
            showsHorizontalScrollIndicator={false}
            contentContainerStyle={styles.horizontalScroll}>
            {featuredPackages.slice(0, 5).map((pkg, index) => (
              <PackageCard
                key={pkg.id}
                package={pkg}
                style={[
                  styles.packageCard,
                  index === 0 && {marginLeft: spacing.md},
                ]}
                onPress={() =>
                  navigation.navigate('PackageDetails', {id: pkg.id})
                }
              />
            ))}
          </ScrollView>
        </View>

        {/* Trust Badges */}
        <View style={styles.trustSection}>
          <View style={styles.trustBadge}>
            <Icon name="shield-checkmark" size={32} color={colors.primary} />
            <Text style={styles.trustText}>15+ Ans</Text>
            <Text style={styles.trustSubtext}>D'expérience</Text>
          </View>
          <View style={styles.trustBadge}>
            <Icon name="people" size={32} color={colors.success} />
            <Text style={styles.trustText}>50k+</Text>
            <Text style={styles.trustSubtext}>Clients</Text>
          </View>
          <View style={styles.trustBadge}>
            <Icon name="star" size={32} color={colors.star} />
            <Text style={styles.trustText}>4.8/5</Text>
            <Text style={styles.trustSubtext}>Note</Text>
          </View>
        </View>

        <View style={{height: spacing.xl}} />
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.background,
  },
  header: {
    paddingTop: spacing.lg,
    paddingBottom: spacing.xl,
    borderBottomLeftRadius: borderRadius.xxl,
    borderBottomRightRadius: borderRadius.xxl,
  },
  headerContent: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingHorizontal: spacing.md,
    marginBottom: spacing.md,
  },
  headerGreeting: {
    fontSize: typography.fontSize.md,
    color: colors.white,
    opacity: 0.9,
  },
  headerTitle: {
    fontSize: typography.fontSize.xxl,
    fontWeight: typography.fontWeight.bold,
    color: colors.white,
    marginTop: spacing.xs,
  },
  notificationButton: {
    position: 'relative',
  },
  notificationBadge: {
    position: 'absolute',
    top: -4,
    right: -4,
    backgroundColor: colors.error,
    borderRadius: borderRadius.round,
    width: 18,
    height: 18,
    justifyContent: 'center',
    alignItems: 'center',
  },
  notificationBadgeText: {
    color: colors.white,
    fontSize: typography.fontSize.xs,
    fontWeight: typography.fontWeight.bold,
  },
  content: {
    flex: 1,
  },
  section: {
    marginTop: spacing.lg,
  },
  sectionHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingHorizontal: spacing.md,
    marginBottom: spacing.md,
  },
  sectionTitle: {
    fontSize: typography.fontSize.xl,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
  },
  seeAll: {
    fontSize: typography.fontSize.md,
    color: colors.primary,
    fontWeight: typography.fontWeight.medium,
  },
  quickActionsGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    paddingHorizontal: spacing.md,
    justifyContent: 'space-between',
  },
  quickActionCard: {
    width: (width - spacing.md * 3) / 2,
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    padding: spacing.md,
    marginBottom: spacing.md,
    alignItems: 'center',
    ...shadows.md,
  },
  quickActionGradient: {
    width: 64,
    height: 64,
    borderRadius: borderRadius.round,
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: spacing.sm,
  },
  quickActionTitle: {
    fontSize: typography.fontSize.md,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginBottom: spacing.xs,
  },
  quickActionSubtitle: {
    fontSize: typography.fontSize.sm,
    color: colors.textSecondary,
  },
  horizontalScroll: {
    paddingRight: spacing.md,
  },
  hotelCard: {
    marginRight: spacing.md,
  },
  packageCard: {
    marginRight: spacing.md,
  },
  trustSection: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.lg,
    backgroundColor: colors.white,
    marginHorizontal: spacing.md,
    marginTop: spacing.lg,
    borderRadius: borderRadius.lg,
    ...shadows.sm,
  },
  trustBadge: {
    alignItems: 'center',
  },
  trustText: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginTop: spacing.xs,
  },
  trustSubtext: {
    fontSize: typography.fontSize.sm,
    color: colors.textSecondary,
  },
});

export default HomeScreen;
