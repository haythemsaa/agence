import React, {useState, useEffect} from 'react';
import {
  View,
  Text,
  StyleSheet,
  FlatList,
  TouchableOpacity,
  RefreshControl,
  ActivityIndicator,
} from 'react-native';
import Icon from 'react-native-vector-icons/Ionicons';
import LinearGradient from 'react-native-linear-gradient';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';
import {api} from '../../services/api';
import HotelCard from '../../components/Cards/HotelCard';

const HotelsScreen = ({navigation}) => {
  const [hotels, setHotels] = useState([]);
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [filters, setFilters] = useState({
    stars: null,
    minPrice: null,
    maxPrice: null,
    city: null,
  });
  const [showFilters, setShowFilters] = useState(false);

  useEffect(() => {
    loadHotels();
  }, [filters]);

  const loadHotels = async () => {
    try {
      setLoading(true);
      const response = await api.hotels.getAll(filters);
      setHotels(response.data || []);
    } catch (error) {
      console.error('Error loading hotels:', error);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  const onRefresh = () => {
    setRefreshing(true);
    loadHotels();
  };

  const toggleFilter = (filterName, value) => {
    setFilters(prev => ({
      ...prev,
      [filterName]: prev[filterName] === value ? null : value,
    }));
  };

  const clearFilters = () => {
    setFilters({
      stars: null,
      minPrice: null,
      maxPrice: null,
      city: null,
    });
  };

  const FilterChip = ({label, active, onPress}) => (
    <TouchableOpacity
      style={[styles.filterChip, active && styles.filterChipActive]}
      onPress={onPress}>
      <Text style={[styles.filterChipText, active && styles.filterChipTextActive]}>
        {label}
      </Text>
    </TouchableOpacity>
  );

  const renderHeader = () => (
    <View>
      <TouchableOpacity
        style={styles.searchBar}
        onPress={() => navigation.navigate('Search')}>
        <Icon name="search-outline" size={20} color={colors.textSecondary} />
        <Text style={styles.searchPlaceholder}>Rechercher un hôtel...</Text>
        <Icon name="options-outline" size={20} color={colors.primary} />
      </TouchableOpacity>

      <View style={styles.filterContainer}>
        <TouchableOpacity
          style={styles.filterButton}
          onPress={() => setShowFilters(!showFilters)}>
          <Icon name="funnel-outline" size={16} color={colors.white} />
          <Text style={styles.filterButtonText}>Filtres</Text>
        </TouchableOpacity>

        {Object.values(filters).some(v => v !== null) && (
          <TouchableOpacity style={styles.clearButton} onPress={clearFilters}>
            <Text style={styles.clearButtonText}>Effacer</Text>
          </TouchableOpacity>
        )}
      </View>

      {showFilters && (
        <View style={styles.filtersPanel}>
          <Text style={styles.filterTitle}>Étoiles</Text>
          <View style={styles.filterRow}>
            {[5, 4, 3, 2, 1].map(star => (
              <FilterChip
                key={star}
                label={`${star}★`}
                active={filters.stars === star}
                onPress={() => toggleFilter('stars', star)}
              />
            ))}
          </View>

          <Text style={styles.filterTitle}>Ville</Text>
          <View style={styles.filterRow}>
            {['Hammamet', 'Sousse', 'Djerba', 'Tunis'].map(city => (
              <FilterChip
                key={city}
                label={city}
                active={filters.city === city}
                onPress={() => toggleFilter('city', city)}
              />
            ))}
          </View>

          <Text style={styles.filterTitle}>Budget (TND/nuit)</Text>
          <View style={styles.filterRow}>
            {[
              {label: '< 100', max: 100},
              {label: '100-200', min: 100, max: 200},
              {label: '200-500', min: 200, max: 500},
              {label: '> 500', min: 500},
            ].map((range, idx) => (
              <FilterChip
                key={idx}
                label={range.label}
                active={
                  filters.minPrice === range.min && filters.maxPrice === range.max
                }
                onPress={() => {
                  setFilters(prev => ({
                    ...prev,
                    minPrice: range.min || null,
                    maxPrice: range.max || null,
                  }));
                }}
              />
            ))}
          </View>
        </View>
      )}

      <View style={styles.resultsHeader}>
        <Text style={styles.resultsCount}>
          {hotels.length} hôtel{hotels.length > 1 ? 's' : ''} trouvé{hotels.length > 1 ? 's' : ''}
        </Text>
        <TouchableOpacity>
          <Icon name="swap-vertical" size={20} color={colors.primary} />
        </TouchableOpacity>
      </View>
    </View>
  );

  if (loading && !refreshing) {
    return (
      <View style={styles.centerContainer}>
        <ActivityIndicator size="large" color={colors.primary} />
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <LinearGradient colors={gradients.primary} style={styles.header}>
        <View style={styles.headerContent}>
          <Text style={styles.headerTitle}>Hôtels</Text>
          <TouchableOpacity onPress={() => navigation.navigate('Wishlist')}>
            <Icon name="heart-outline" size={24} color={colors.white} />
          </TouchableOpacity>
        </View>
      </LinearGradient>

      <FlatList
        data={hotels}
        keyExtractor={item => item.id.toString()}
        renderItem={({item}) => (
          <HotelCard
            hotel={item}
            style={styles.hotelCard}
            onPress={() => navigation.navigate('HotelDetails', {id: item.id})}
          />
        )}
        ListHeaderComponent={renderHeader}
        refreshControl={
          <RefreshControl refreshing={refreshing} onRefresh={onRefresh} />
        }
        contentContainerStyle={styles.listContent}
        showsVerticalScrollIndicator={false}
      />
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
  searchBar: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.white,
    padding: spacing.md,
    marginHorizontal: spacing.md,
    marginTop: spacing.md,
    borderRadius: borderRadius.lg,
    ...shadows.sm,
  },
  searchPlaceholder: {
    flex: 1,
    marginLeft: spacing.sm,
    fontSize: typography.fontSize.md,
    color: colors.textSecondary,
  },
  filterContainer: {
    flexDirection: 'row',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.md,
  },
  filterButton: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.primary,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
    borderRadius: borderRadius.md,
    marginRight: spacing.sm,
  },
  filterButtonText: {
    color: colors.white,
    fontSize: typography.fontSize.sm,
    fontWeight: typography.fontWeight.medium,
    marginLeft: spacing.xs,
  },
  clearButton: {
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
    borderRadius: borderRadius.md,
    borderWidth: 1,
    borderColor: colors.primary,
  },
  clearButtonText: {
    color: colors.primary,
    fontSize: typography.fontSize.sm,
    fontWeight: typography.fontWeight.medium,
  },
  filtersPanel: {
    backgroundColor: colors.white,
    padding: spacing.md,
    marginHorizontal: spacing.md,
    marginBottom: spacing.md,
    borderRadius: borderRadius.lg,
    ...shadows.sm,
  },
  filterTitle: {
    fontSize: typography.fontSize.md,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginTop: spacing.sm,
    marginBottom: spacing.sm,
  },
  filterRow: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    marginBottom: spacing.sm,
  },
  filterChip: {
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
    borderRadius: borderRadius.round,
    backgroundColor: colors.lighter,
    marginRight: spacing.sm,
    marginBottom: spacing.sm,
  },
  filterChipActive: {
    backgroundColor: colors.primary,
  },
  filterChipText: {
    fontSize: typography.fontSize.sm,
    color: colors.textPrimary,
  },
  filterChipTextActive: {
    color: colors.white,
    fontWeight: typography.fontWeight.bold,
  },
  resultsHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
  },
  resultsCount: {
    fontSize: typography.fontSize.md,
    color: colors.textSecondary,
    fontWeight: typography.fontWeight.medium,
  },
  listContent: {
    paddingBottom: spacing.xl,
  },
  hotelCard: {
    marginHorizontal: spacing.md,
    marginBottom: spacing.md,
  },
});

export default HotelsScreen;
