import React, {useState, useEffect} from 'react';
import {View, Text, StyleSheet, FlatList, TouchableOpacity, RefreshControl, ActivityIndicator} from 'react-native';
import Icon from 'react-native-vector-icons/Ionicons';
import LinearGradient from 'react-native-linear-gradient';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';
import {api} from '../../services/api';
import PackageCard from '../../components/Cards/PackageCard';

const PackagesScreen = ({navigation, route}) => {
  const [packages, setPackages] = useState([]);
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [selectedType, setSelectedType] = useState(route?.params?.type || 'all');

  const types = [
    {key: 'all', label: 'Tous', icon: 'grid-outline'},
    {key: 'circuit', label: 'Circuits', icon: 'map-outline'},
    {key: 'sejour', label: 'Séjours', icon: 'bed-outline'},
    {key: 'omra', label: 'Omra', icon: 'star-outline'},
    {key: 'international', label: 'International', icon: 'airplane-outline'},
  ];

  useEffect(() => {
    loadPackages();
  }, [selectedType]);

  const loadPackages = async () => {
    try {
      setLoading(true);
      const params = selectedType !== 'all' ? {type: selectedType} : {};
      const response = await api.packages.getAll(params);
      setPackages(response.data || []);
    } catch (error) {
      console.error('Error:', error);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  const onRefresh = () => {
    setRefreshing(true);
    loadPackages();
  };

  const TypeChip = ({type}) => {
    const isActive = selectedType === type.key;
    return (
      <TouchableOpacity
        style={[styles.typeChip, isActive && styles.typeChipActive]}
        onPress={() => setSelectedType(type.key)}>
        <Icon name={type.icon} size={18} color={isActive ? colors.white : colors.textSecondary} />
        <Text style={[styles.typeChipText, isActive && styles.typeChipTextActive]}>
          {type.label}
        </Text>
      </TouchableOpacity>
    );
  };

  if (loading && !refreshing) {
    return (
      <View style={styles.centerContainer}>
        <ActivityIndicator size="large" color={colors.primary} />
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <LinearGradient colors={gradients.secondary} style={styles.header}>
        <Text style={styles.headerTitle}>Voyages Organisés</Text>
      </LinearGradient>

      <View style={styles.typesContainer}>
        {types.map(type => (
          <TypeChip key={type.key} type={type} />
        ))}
      </View>

      <FlatList
        data={packages}
        keyExtractor={item => item.id.toString()}
        renderItem={({item}) => (
          <PackageCard
            package={item}
            style={styles.packageCard}
            onPress={() => navigation.navigate('PackageDetails', {id: item.id})}
          />
        )}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} />}
        contentContainerStyle={styles.listContent}
        showsVerticalScrollIndicator={false}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {flex: 1, backgroundColor: colors.background},
  centerContainer: {flex: 1, justifyContent: 'center', alignItems: 'center'},
  header: {paddingTop: spacing.lg, paddingBottom: spacing.md, paddingHorizontal: spacing.md},
  headerTitle: {fontSize: typography.fontSize.xxl, fontWeight: typography.fontWeight.bold, color: colors.white},
  typesContainer: {flexDirection: 'row', paddingHorizontal: spacing.md, paddingVertical: spacing.md, flexWrap: 'wrap'},
  typeChip: {flexDirection: 'row', alignItems: 'center', backgroundColor: colors.white, paddingHorizontal: spacing.md, paddingVertical: spacing.sm, borderRadius: borderRadius.round, marginRight: spacing.sm, marginBottom: spacing.sm, ...shadows.sm},
  typeChipActive: {backgroundColor: colors.secondary},
  typeChipText: {fontSize: typography.fontSize.sm, color: colors.textSecondary, marginLeft: spacing.xs},
  typeChipTextActive: {color: colors.white, fontWeight: typography.fontWeight.bold},
  listContent: {paddingBottom: spacing.xl},
  packageCard: {marginHorizontal: spacing.md, marginBottom: spacing.md},
});

export default PackagesScreen;
