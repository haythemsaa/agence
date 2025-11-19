import React, {useState, useEffect, useRef} from 'react';
import {
  View,
  Text,
  StyleSheet,
  TextInput,
  TouchableOpacity,
  FlatList,
  ActivityIndicator,
  ScrollView,
} from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import LinearGradient from 'react-native-linear-gradient';
import Icon from 'react-native-vector-icons/Ionicons';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';
import {api} from '../../services/api';
import HotelCard from '../../components/Cards/HotelCard';
import PackageCard from '../../components/Cards/PackageCard';

const RECENT_SEARCHES_KEY = '@recent_searches';
const MAX_RECENT_SEARCHES = 10;

const SearchScreen = ({navigation}) => {
  const [searchQuery, setSearchQuery] = useState('');
  const [activeTab, setActiveTab] = useState('all'); // all, hotels, packages
  const [results, setResults] = useState({hotels: [], packages: []});
  const [suggestions, setSuggestions] = useState([]);
  const [recentSearches, setRecentSearches] = useState([]);
  const [loading, setLoading] = useState(false);
  const [showSuggestions, setShowSuggestions] = useState(false);
  const searchTimeout = useRef(null);
  const inputRef = useRef(null);

  const popularSearches = [
    {text: 'Hammamet', icon: 'location', type: 'destination'},
    {text: 'Djerba', icon: 'location', type: 'destination'},
    {text: 'Omra', icon: 'moon', type: 'package'},
    {text: 'Circuit Sud', icon: 'map', type: 'package'},
    {text: 'Sousse', icon: 'location', type: 'destination'},
    {text: 'Istanbul', icon: 'airplane', type: 'destination'},
  ];

  useEffect(() => {
    loadRecentSearches();
    if (searchQuery.length > 0) {
      inputRef.current?.focus();
    }
  }, []);

  useEffect(() => {
    if (searchQuery.length >= 2) {
      setShowSuggestions(true);
      if (searchTimeout.current) {
        clearTimeout(searchTimeout.current);
      }
      searchTimeout.current = setTimeout(() => {
        performSearch();
        generateSuggestions();
      }, 300);
    } else {
      setShowSuggestions(false);
      setResults({hotels: [], packages: []});
      setSuggestions([]);
    }

    return () => {
      if (searchTimeout.current) {
        clearTimeout(searchTimeout.current);
      }
    };
  }, [searchQuery, activeTab]);

  const loadRecentSearches = async () => {
    try {
      const saved = await AsyncStorage.getItem(RECENT_SEARCHES_KEY);
      if (saved) {
        setRecentSearches(JSON.parse(saved));
      }
    } catch (error) {
      console.error('Error loading recent searches:', error);
    }
  };

  const saveRecentSearch = async query => {
    try {
      const trimmed = query.trim();
      if (!trimmed) return;

      let updated = [trimmed, ...recentSearches.filter(s => s !== trimmed)];
      updated = updated.slice(0, MAX_RECENT_SEARCHES);

      await AsyncStorage.setItem(RECENT_SEARCHES_KEY, JSON.stringify(updated));
      setRecentSearches(updated);
    } catch (error) {
      console.error('Error saving recent search:', error);
    }
  };

  const clearRecentSearches = async () => {
    try {
      await AsyncStorage.removeItem(RECENT_SEARCHES_KEY);
      setRecentSearches([]);
    } catch (error) {
      console.error('Error clearing recent searches:', error);
    }
  };

  const performSearch = async () => {
    if (searchQuery.length < 2) return;

    setLoading(true);
    try {
      const promises = [];

      if (activeTab === 'all' || activeTab === 'hotels') {
        promises.push(api.hotels.search({q: searchQuery}));
      } else {
        promises.push(Promise.resolve({data: []}));
      }

      if (activeTab === 'all' || activeTab === 'packages') {
        promises.push(api.packages.search({q: searchQuery}));
      } else {
        promises.push(Promise.resolve({data: []}));
      }

      const [hotelsRes, packagesRes] = await Promise.all(promises);

      setResults({
        hotels: hotelsRes.data || [],
        packages: packagesRes.data || [],
      });

      saveRecentSearch(searchQuery);
    } catch (error) {
      console.error('Search error:', error);
      setResults({hotels: [], packages: []});
    } finally {
      setLoading(false);
    }
  };

  const generateSuggestions = () => {
    const query = searchQuery.toLowerCase();
    const suggestionsArr = [];

    // Add matching popular searches
    popularSearches.forEach(item => {
      if (item.text.toLowerCase().includes(query)) {
        suggestionsArr.push({
          text: item.text,
          icon: item.icon,
          type: item.type,
        });
      }
    });

    // Add matching recent searches
    recentSearches.forEach(search => {
      if (
        search.toLowerCase().includes(query) &&
        !suggestionsArr.find(s => s.text === search)
      ) {
        suggestionsArr.push({
          text: search,
          icon: 'time-outline',
          type: 'recent',
        });
      }
    });

    setSuggestions(suggestionsArr.slice(0, 5));
  };

  const handleSuggestionPress = text => {
    setSearchQuery(text);
    setShowSuggestions(false);
    inputRef.current?.blur();
  };

  const handleRecentSearchPress = search => {
    setSearchQuery(search);
    setShowSuggestions(false);
  };

  const handleClearSearch = () => {
    setSearchQuery('');
    setResults({hotels: [], packages: []});
    setSuggestions([]);
    setShowSuggestions(false);
    inputRef.current?.focus();
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

  const SuggestionItem = ({item}) => (
    <TouchableOpacity
      style={styles.suggestionItem}
      onPress={() => handleSuggestionPress(item.text)}>
      <Icon name={item.icon} size={20} color={colors.textSecondary} />
      <Text style={styles.suggestionText}>{item.text}</Text>
      <Icon name="arrow-up-outline" size={16} color={colors.textSecondary} />
    </TouchableOpacity>
  );

  const PopularSearchChip = ({item}) => (
    <TouchableOpacity
      style={styles.popularChip}
      onPress={() => handleSuggestionPress(item.text)}>
      <Icon name={item.icon} size={16} color={colors.primary} />
      <Text style={styles.popularChipText}>{item.text}</Text>
    </TouchableOpacity>
  );

  const RecentSearchItem = ({search}) => (
    <TouchableOpacity
      style={styles.recentSearchItem}
      onPress={() => handleRecentSearchPress(search)}>
      <Icon name="time-outline" size={20} color={colors.textSecondary} />
      <Text style={styles.recentSearchText}>{search}</Text>
      <Icon name="arrow-up-outline" size={16} color={colors.textSecondary} />
    </TouchableOpacity>
  );

  const EmptyState = () => (
    <View style={styles.emptyState}>
      <Icon name="search-outline" size={64} color={colors.lightGray} />
      <Text style={styles.emptyStateTitle}>
        {searchQuery.length > 0 ? 'Aucun résultat' : 'Rechercher'}
      </Text>
      <Text style={styles.emptyStateText}>
        {searchQuery.length > 0
          ? 'Essayez une autre recherche'
          : 'Hotels, packages, destinations...'}
      </Text>
    </View>
  );

  const totalResults = results.hotels.length + results.packages.length;
  const showResults = searchQuery.length >= 2 && !showSuggestions;
  const showInitialContent = searchQuery.length === 0;

  return (
    <View style={styles.container}>
      {/* Header */}
      <LinearGradient colors={gradients.primary} style={styles.header}>
        <View style={styles.headerContent}>
          <TouchableOpacity
            onPress={() => navigation.goBack()}
            style={styles.backButton}>
            <Icon name="arrow-back" size={24} color={colors.white} />
          </TouchableOpacity>
          <Text style={styles.headerTitle}>Recherche</Text>
        </View>

        {/* Search Bar */}
        <View style={styles.searchBarContainer}>
          <Icon name="search-outline" size={20} color={colors.textSecondary} />
          <TextInput
            ref={inputRef}
            style={styles.searchInput}
            placeholder="Hotels, packages, destinations..."
            placeholderTextColor={colors.textSecondary}
            value={searchQuery}
            onChangeText={setSearchQuery}
            autoFocus
            returnKeyType="search"
            onSubmitEditing={() => setShowSuggestions(false)}
          />
          {searchQuery.length > 0 && (
            <TouchableOpacity onPress={handleClearSearch}>
              <Icon name="close-circle" size={20} color={colors.textSecondary} />
            </TouchableOpacity>
          )}
        </View>
      </LinearGradient>

      {/* Suggestions Overlay */}
      {showSuggestions && suggestions.length > 0 && (
        <View style={styles.suggestionsContainer}>
          <FlatList
            data={suggestions}
            keyExtractor={(item, idx) => `${item.text}-${idx}`}
            renderItem={({item}) => <SuggestionItem item={item} />}
            ItemSeparatorComponent={() => <View style={styles.separator} />}
          />
        </View>
      )}

      {/* Initial Content (Recent & Popular Searches) */}
      {showInitialContent && !showSuggestions && (
        <ScrollView style={styles.content} showsVerticalScrollIndicator={false}>
          {/* Recent Searches */}
          {recentSearches.length > 0 && (
            <View style={styles.section}>
              <View style={styles.sectionHeader}>
                <Text style={styles.sectionTitle}>Recherches récentes</Text>
                <TouchableOpacity onPress={clearRecentSearches}>
                  <Text style={styles.clearButton}>Effacer</Text>
                </TouchableOpacity>
              </View>
              {recentSearches.map((search, idx) => (
                <RecentSearchItem key={idx} search={search} />
              ))}
            </View>
          )}

          {/* Popular Searches */}
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>Recherches populaires</Text>
            <View style={styles.popularGrid}>
              {popularSearches.map((item, idx) => (
                <PopularSearchChip key={idx} item={item} />
              ))}
            </View>
          </View>
        </ScrollView>
      )}

      {/* Search Results */}
      {showResults && (
        <View style={styles.resultsContainer}>
          {/* Tabs */}
          <View style={styles.tabsContainer}>
            <ScrollView horizontal showsHorizontalScrollIndicator={false}>
              <TabButton
                label="Tous"
                value="all"
                count={totalResults}
              />
              <TabButton
                label="Hôtels"
                value="hotels"
                count={results.hotels.length}
              />
              <TabButton
                label="Packages"
                value="packages"
                count={results.packages.length}
              />
            </ScrollView>
          </View>

          {/* Loading */}
          {loading && (
            <View style={styles.loadingContainer}>
              <ActivityIndicator size="large" color={colors.primary} />
            </View>
          )}

          {/* Results List */}
          {!loading && totalResults > 0 && (
            <FlatList
              data={[
                ...(activeTab === 'all' || activeTab === 'hotels'
                  ? results.hotels.map(h => ({...h, type: 'hotel'}))
                  : []),
                ...(activeTab === 'all' || activeTab === 'packages'
                  ? results.packages.map(p => ({...p, type: 'package'}))
                  : []),
              ]}
              keyExtractor={item => `${item.type}-${item.id}`}
              renderItem={({item}) => {
                if (item.type === 'hotel') {
                  return (
                    <HotelCard
                      hotel={item}
                      style={styles.resultCard}
                      onPress={() =>
                        navigation.navigate('HotelDetails', {id: item.id})
                      }
                    />
                  );
                } else {
                  return (
                    <PackageCard
                      package={item}
                      style={styles.resultCard}
                      onPress={() =>
                        navigation.navigate('PackageDetails', {id: item.id})
                      }
                    />
                  );
                }
              }}
              contentContainerStyle={styles.resultsList}
              showsVerticalScrollIndicator={false}
            />
          )}

          {/* Empty State */}
          {!loading && totalResults === 0 && <EmptyState />}
        </View>
      )}
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
    paddingBottom: spacing.md,
    paddingHorizontal: spacing.md,
  },
  headerContent: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: spacing.md,
  },
  backButton: {
    width: 40,
    height: 40,
    borderRadius: borderRadius.round,
    backgroundColor: 'rgba(255, 255, 255, 0.2)',
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: spacing.sm,
  },
  headerTitle: {
    fontSize: typography.fontSize.xl,
    fontWeight: typography.fontWeight.bold,
    color: colors.white,
  },
  searchBarContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
    ...shadows.md,
  },
  searchInput: {
    flex: 1,
    marginLeft: spacing.sm,
    fontSize: typography.fontSize.md,
    color: colors.textPrimary,
    paddingVertical: spacing.xs,
  },
  suggestionsContainer: {
    backgroundColor: colors.white,
    marginHorizontal: spacing.md,
    marginTop: spacing.sm,
    borderRadius: borderRadius.lg,
    ...shadows.md,
    maxHeight: 300,
  },
  suggestionItem: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: spacing.md,
  },
  suggestionText: {
    flex: 1,
    marginLeft: spacing.sm,
    fontSize: typography.fontSize.md,
    color: colors.textPrimary,
  },
  separator: {
    height: 1,
    backgroundColor: colors.border,
  },
  content: {
    flex: 1,
  },
  section: {
    padding: spacing.md,
  },
  sectionHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: spacing.sm,
  },
  sectionTitle: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginBottom: spacing.sm,
  },
  clearButton: {
    fontSize: typography.fontSize.sm,
    color: colors.primary,
    fontWeight: typography.fontWeight.bold,
  },
  recentSearchItem: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: spacing.sm,
    paddingHorizontal: spacing.md,
    backgroundColor: colors.white,
    borderRadius: borderRadius.md,
    marginBottom: spacing.sm,
    ...shadows.sm,
  },
  recentSearchText: {
    flex: 1,
    marginLeft: spacing.sm,
    fontSize: typography.fontSize.md,
    color: colors.textPrimary,
  },
  popularGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
  },
  popularChip: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.lighter,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
    borderRadius: borderRadius.round,
    marginRight: spacing.sm,
    marginBottom: spacing.sm,
  },
  popularChipText: {
    fontSize: typography.fontSize.sm,
    color: colors.textPrimary,
    marginLeft: spacing.xs,
    fontWeight: typography.fontWeight.medium,
  },
  resultsContainer: {
    flex: 1,
  },
  tabsContainer: {
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
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  resultsList: {
    padding: spacing.md,
  },
  resultCard: {
    marginBottom: spacing.md,
  },
  emptyState: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: spacing.xl,
  },
  emptyStateTitle: {
    fontSize: typography.fontSize.xl,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginTop: spacing.md,
  },
  emptyStateText: {
    fontSize: typography.fontSize.md,
    color: colors.textSecondary,
    marginTop: spacing.sm,
    textAlign: 'center',
  },
});

export default SearchScreen;
