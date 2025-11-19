import React, {useState, useEffect, useCallback} from 'react';
import {
  View,
  Text,
  StyleSheet,
  FlatList,
  TouchableOpacity,
  RefreshControl,
  Alert,
} from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import LinearGradient from 'react-native-linear-gradient';
import Icon from 'react-native-vector-icons/Ionicons';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';
import {api} from '../../services/api';
import HotelCard from '../../components/Cards/HotelCard';
import PackageCard from '../../components/Cards/PackageCard';
import {useFocusEffect} from '@react-navigation/native';

const WISHLIST_KEY = '@wishlist_items';

const WishlistScreen = ({navigation}) => {
  const [wishlistItems, setWishlistItems] = useState([]);
  const [activeTab, setActiveTab] = useState('all'); // all, hotels, packages
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);

  useFocusEffect(
    useCallback(() => {
      loadWishlist();
    }, [])
  );

  const loadWishlist = async () => {
    try {
      setLoading(true);
      const saved = await AsyncStorage.getItem(WISHLIST_KEY);
      if (saved) {
        const ids = JSON.parse(saved);
        await loadWishlistDetails(ids);
      } else {
        setWishlistItems([]);
      }
    } catch (error) {
      console.error('Error loading wishlist:', error);
      setWishlistItems([]);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  const loadWishlistDetails = async ids => {
    try {
      const items = [];

      // Load hotels
      for (const id of ids.hotels || []) {
        try {
          const response = await api.hotels.getById(id);
          if (response.data) {
            items.push({...response.data, type: 'hotel'});
          }
        } catch (error) {
          console.error(`Error loading hotel ${id}:`, error);
        }
      }

      // Load packages
      for (const id of ids.packages || []) {
        try {
          const response = await api.packages.getById(id);
          if (response.data) {
            items.push({...response.data, type: 'package'});
          }
        } catch (error) {
          console.error(`Error loading package ${id}:`, error);
        }
      }

      setWishlistItems(items);
    } catch (error) {
      console.error('Error loading wishlist details:', error);
      setWishlistItems([]);
    }
  };

  const onRefresh = () => {
    setRefreshing(true);
    loadWishlist();
  };

  const removeFromWishlist = async (id, type) => {
    try {
      const saved = await AsyncStorage.getItem(WISHLIST_KEY);
      const ids = saved ? JSON.parse(saved) : {hotels: [], packages: []};

      if (type === 'hotel') {
        ids.hotels = ids.hotels.filter(hId => hId !== id);
      } else {
        ids.packages = ids.packages.filter(pId => pId !== id);
      }

      await AsyncStorage.setItem(WISHLIST_KEY, JSON.stringify(ids));
      setWishlistItems(prev => prev.filter(item => !(item.id === id && item.type === type)));
    } catch (error) {
      console.error('Error removing from wishlist:', error);
    }
  };

  const clearAllWishlist = () => {
    Alert.alert(
      'Vider la liste',
      'Êtes-vous sûr de vouloir supprimer tous les favoris ?',
      [
        {text: 'Annuler', style: 'cancel'},
        {
          text: 'Supprimer',
          style: 'destructive',
          onPress: async () => {
            try {
              await AsyncStorage.removeItem(WISHLIST_KEY);
              setWishlistItems([]);
            } catch (error) {
              console.error('Error clearing wishlist:', error);
            }
          },
        },
      ]
    );
  };

  const TabButton = ({label, value, count}) => (
    <TouchableOpacity
      style={[styles.tabButton, activeTab === value && styles.tabButtonActive]}
      onPress={() => setActiveTab(value)}>
      <Text
        style={[
          styles.tabButtonText,
          activeTab === value && styles.tabButtonTextActive,
        ]}>
        {label}
      </Text>
      {count > 0 && (
        <View style={styles.tabBadge}>
          <Text style={styles.tabBadgeText}>{count}</Text>
        </View>
      )}
    </TouchableOpacity>
  );

  const EmptyState = () => (
    <View style={styles.emptyState}>
      <Icon name="heart-outline" size={80} color={colors.lightGray} />
      <Text style={styles.emptyStateTitle}>Aucun favori</Text>
      <Text style={styles.emptyStateText}>
        Ajoutez vos hôtels et packages préférés à vos favoris
      </Text>
      <TouchableOpacity
        style={styles.exploreButton}
        onPress={() => navigation.navigate('Home')}>
        <LinearGradient
          colors={gradients.primary}
          style={styles.exploreButtonGradient}>
          <Text style={styles.exploreButtonText}>Explorer</Text>
        </LinearGradient>
      </TouchableOpacity>
    </View>
  );

  const filteredItems = wishlistItems.filter(item => {
    if (activeTab === 'all') return true;
    if (activeTab === 'hotels') return item.type === 'hotel';
    if (activeTab === 'packages') return item.type === 'package';
    return true;
  });

  const hotelCount = wishlistItems.filter(i => i.type === 'hotel').length;
  const packageCount = wishlistItems.filter(i => i.type === 'package').length;

  return (
    <View style={styles.container}>
      {/* Header */}
      <LinearGradient colors={gradients.primary} style={styles.header}>
        <View style={styles.headerContent}>
          <Text style={styles.headerTitle}>Mes Favoris</Text>
          {wishlistItems.length > 0 && (
            <TouchableOpacity onPress={clearAllWishlist}>
              <Icon name="trash-outline" size={24} color={colors.white} />
            </TouchableOpacity>
          )}
        </View>
      </LinearGradient>

      {wishlistItems.length > 0 && (
        <View style={styles.tabsContainer}>
          <TabButton
            label="Tous"
            value="all"
            count={wishlistItems.length}
          />
          <TabButton
            label="Hôtels"
            value="hotels"
            count={hotelCount}
          />
          <TabButton
            label="Packages"
            value="packages"
            count={packageCount}
          />
        </View>
      )}

      {loading && !refreshing ? (
        <View style={styles.centerContainer}>
          <Icon name="heart" size={48} color={colors.primary} />
          <Text style={styles.loadingText}>Chargement...</Text>
        </View>
      ) : filteredItems.length === 0 ? (
        <EmptyState />
      ) : (
        <FlatList
          data={filteredItems}
          keyExtractor={item => `${item.type}-${item.id}`}
          renderItem={({item}) => {
            if (item.type === 'hotel') {
              return (
                <View style={styles.itemContainer}>
                  <HotelCard
                    hotel={item}
                    style={styles.card}
                    onPress={() =>
                      navigation.navigate('HotelDetails', {id: item.id})
                    }
                  />
                  <TouchableOpacity
                    style={styles.removeButton}
                    onPress={() => removeFromWishlist(item.id, 'hotel')}>
                    <Icon name="heart" size={24} color={colors.error} />
                  </TouchableOpacity>
                </View>
              );
            } else {
              return (
                <View style={styles.itemContainer}>
                  <PackageCard
                    package={item}
                    style={styles.card}
                    onPress={() =>
                      navigation.navigate('PackageDetails', {id: item.id})
                    }
                  />
                  <TouchableOpacity
                    style={styles.removeButton}
                    onPress={() => removeFromWishlist(item.id, 'package')}>
                    <Icon name="heart" size={24} color={colors.error} />
                  </TouchableOpacity>
                </View>
              );
            }
          }}
          refreshControl={
            <RefreshControl
              refreshing={refreshing}
              onRefresh={onRefresh}
              colors={[colors.primary]}
            />
          }
          contentContainerStyle={styles.listContent}
          showsVerticalScrollIndicator={false}
        />
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.background,
  },
  centerContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  loadingText: {
    marginTop: spacing.md,
    fontSize: typography.fontSize.md,
    color: colors.textSecondary,
  },
  header: {
    paddingTop: spacing.lg,
    paddingBottom: spacing.md,
    paddingHorizontal: spacing.md,
  },
  headerContent: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  headerTitle: {
    fontSize: typography.fontSize.xxl,
    fontWeight: typography.fontWeight.bold,
    color: colors.white,
  },
  tabsContainer: {
    flexDirection: 'row',
    backgroundColor: colors.white,
    paddingVertical: spacing.sm,
    paddingHorizontal: spacing.md,
    borderBottomWidth: 1,
    borderBottomColor: colors.border,
  },
  tabButton: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
    marginRight: spacing.sm,
    borderRadius: borderRadius.round,
    backgroundColor: colors.lighter,
  },
  tabButtonActive: {
    backgroundColor: colors.primary,
  },
  tabButtonText: {
    fontSize: typography.fontSize.md,
    color: colors.textPrimary,
    fontWeight: typography.fontWeight.medium,
  },
  tabButtonTextActive: {
    color: colors.white,
    fontWeight: typography.fontWeight.bold,
  },
  tabBadge: {
    backgroundColor: colors.white,
    borderRadius: borderRadius.round,
    paddingHorizontal: spacing.xs,
    paddingVertical: 2,
    marginLeft: spacing.xs,
    minWidth: 20,
    alignItems: 'center',
  },
  tabBadgeText: {
    fontSize: typography.fontSize.xs,
    color: colors.primary,
    fontWeight: typography.fontWeight.bold,
  },
  listContent: {
    padding: spacing.md,
  },
  itemContainer: {
    position: 'relative',
    marginBottom: spacing.md,
  },
  card: {
    marginBottom: 0,
  },
  removeButton: {
    position: 'absolute',
    top: spacing.md,
    right: spacing.md,
    width: 40,
    height: 40,
    borderRadius: borderRadius.round,
    backgroundColor: colors.white,
    justifyContent: 'center',
    alignItems: 'center',
    ...shadows.md,
  },
  emptyState: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: spacing.xl,
  },
  emptyStateTitle: {
    fontSize: typography.fontSize.xxl,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginTop: spacing.lg,
  },
  emptyStateText: {
    fontSize: typography.fontSize.md,
    color: colors.textSecondary,
    marginTop: spacing.sm,
    textAlign: 'center',
    marginBottom: spacing.xl,
  },
  exploreButton: {
    borderRadius: borderRadius.lg,
    overflow: 'hidden',
    ...shadows.md,
  },
  exploreButtonGradient: {
    paddingVertical: spacing.md,
    paddingHorizontal: spacing.xxl,
  },
  exploreButtonText: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.white,
  },
});

export default WishlistScreen;
