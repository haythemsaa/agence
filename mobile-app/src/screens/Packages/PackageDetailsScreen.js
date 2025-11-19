import React, {useState, useEffect} from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  Image,
  Dimensions,
  ActivityIndicator,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import Icon from 'react-native-vector-icons/Ionicons';
import {colors, gradients} from '../../theme/colors';
import {spacing, typography, borderRadius, shadows} from '../../theme/styles';
import {api} from '../../services/api';

const {width} = Dimensions.get('window');

const PackageDetailsScreen = ({route, navigation}) => {
  const {id} = route.params;
  const [packageData, setPackageData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [selectedImageIndex, setSelectedImageIndex] = useState(0);
  const [showFullItinerary, setShowFullItinerary] = useState(false);

  useEffect(() => {
    loadPackageDetails();
  }, [id]);

  const loadPackageDetails = async () => {
    try {
      const response = await api.packages.getById(id);
      setPackageData(response.data);
    } catch (error) {
      console.error('Error:', error);
    } finally {
      setLoading(false);
    }
  };

  const getTypeGradient = type => {
    const gradientMap = {
      circuit: gradients.luxury,
      sejour: gradients.primary,
      omra: gradients.omra,
      international: gradients.secondary,
    };
    return gradientMap[type] || gradients.primary;
  };

  const getTypeIcon = type => {
    const iconMap = {
      circuit: 'map',
      sejour: 'bed',
      omra: 'moon',
      international: 'airplane',
    };
    return iconMap[type] || 'globe';
  };

  const ServiceItem = ({icon, text, included = true}) => (
    <View style={styles.serviceItem}>
      <Icon
        name={included ? 'checkmark-circle' : 'close-circle'}
        size={20}
        color={included ? colors.success : colors.error}
      />
      <Text style={[styles.serviceText, !included && styles.serviceTextExcluded]}>
        {text}
      </Text>
    </View>
  );

  const ItineraryDay = ({day, title, description}) => (
    <View style={styles.itineraryDay}>
      <View style={styles.dayBadge}>
        <Text style={styles.dayNumber}>{day}</Text>
      </View>
      <View style={styles.dayContent}>
        <Text style={styles.dayTitle}>{title}</Text>
        <Text style={styles.dayDescription}>{description}</Text>
      </View>
    </View>
  );

  if (loading) {
    return (
      <View style={styles.centerContainer}>
        <ActivityIndicator size="large" color={colors.primary} />
      </View>
    );
  }

  if (!packageData) {
    return (
      <View style={styles.centerContainer}>
        <Icon name="alert-circle-outline" size={64} color={colors.lightGray} />
        <Text style={styles.errorText}>Package non trouvé</Text>
      </View>
    );
  }

  const typeGradient = getTypeGradient(packageData.type);
  const typeIcon = getTypeIcon(packageData.type);

  return (
    <View style={styles.container}>
      <ScrollView showsVerticalScrollIndicator={false}>
        {/* Image Gallery */}
        <View style={styles.imageContainer}>
          {packageData.images && packageData.images.length > 0 ? (
            <Image
              source={{uri: packageData.images[selectedImageIndex]}}
              style={styles.mainImage}
              resizeMode="cover"
            />
          ) : (
            <LinearGradient colors={typeGradient} style={styles.mainImage}>
              <Icon name={typeIcon} size={80} color={colors.white} />
            </LinearGradient>
          )}

          {/* Image Thumbnails */}
          {packageData.images && packageData.images.length > 1 && (
            <ScrollView
              horizontal
              style={styles.thumbnailScroll}
              showsHorizontalScrollIndicator={false}>
              {packageData.images.map((img, idx) => (
                <TouchableOpacity
                  key={idx}
                  onPress={() => setSelectedImageIndex(idx)}
                  style={[
                    styles.thumbnail,
                    selectedImageIndex === idx && styles.thumbnailActive,
                  ]}>
                  <Image source={{uri: img}} style={styles.thumbnailImage} />
                </TouchableOpacity>
              ))}
            </ScrollView>
          )}

          {/* Wishlist Button */}
          <TouchableOpacity style={styles.wishlistButton}>
            <Icon name="heart-outline" size={24} color={colors.white} />
          </TouchableOpacity>
        </View>

        <View style={styles.contentContainer}>
          {/* Header Info */}
          <View style={styles.headerInfo}>
            <View style={styles.titleContainer}>
              <Text style={styles.packageTitle}>{packageData.title}</Text>
              <View style={styles.metaRow}>
                <View style={styles.typeBadge}>
                  <Icon name={typeIcon} size={14} color={colors.white} />
                  <Text style={styles.typeText}>
                    {packageData.type_label || packageData.type}
                  </Text>
                </View>
                {packageData.is_tre && (
                  <View style={styles.treBadge}>
                    <Text style={styles.treText}>🎫 TRE</Text>
                  </View>
                )}
              </View>
            </View>
          </View>

          {/* Duration and Destinations */}
          <View style={styles.infoCards}>
            <View style={styles.infoCard}>
              <Icon name="calendar-outline" size={24} color={colors.primary} />
              <Text style={styles.infoCardValue}>{packageData.duration}</Text>
              <Text style={styles.infoCardLabel}>Durée</Text>
            </View>
            <View style={styles.infoCard}>
              <Icon name="location-outline" size={24} color={colors.secondary} />
              <Text style={styles.infoCardValue}>
                {packageData.destinations?.length || 1}
              </Text>
              <Text style={styles.infoCardLabel}>Destinations</Text>
            </View>
            <View style={styles.infoCard}>
              <Icon name="people-outline" size={24} color={colors.accent} />
              <Text style={styles.infoCardValue}>
                {packageData.max_participants || '∞'}
              </Text>
              <Text style={styles.infoCardLabel}>Max. Pers.</Text>
            </View>
          </View>

          {/* Destinations */}
          {packageData.destinations && packageData.destinations.length > 0 && (
            <View style={styles.section}>
              <Text style={styles.sectionTitle}>Destinations</Text>
              <View style={styles.destinationsContainer}>
                {packageData.destinations.map((dest, idx) => (
                  <View key={idx} style={styles.destinationChip}>
                    <Icon name="location" size={14} color={colors.primary} />
                    <Text style={styles.destinationText}>{dest}</Text>
                  </View>
                ))}
              </View>
            </View>
          )}

          {/* Description */}
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>Description</Text>
            <Text style={styles.description}>
              {packageData.description || packageData.short_description || 'Package voyage complet avec services premium.'}
            </Text>
          </View>

          {/* Included Services */}
          {packageData.included_services && packageData.included_services.length > 0 && (
            <View style={styles.section}>
              <Text style={styles.sectionTitle}>Services Inclus</Text>
              <View style={styles.servicesContainer}>
                {packageData.included_services.map((service, idx) => (
                  <ServiceItem key={idx} icon="checkmark-circle" text={service} included />
                ))}
              </View>
            </View>
          )}

          {/* Excluded Services */}
          {packageData.excluded_services && packageData.excluded_services.length > 0 && (
            <View style={styles.section}>
              <Text style={styles.sectionTitle}>Non Inclus</Text>
              <View style={styles.servicesContainer}>
                {packageData.excluded_services.map((service, idx) => (
                  <ServiceItem key={idx} icon="close-circle" text={service} included={false} />
                ))}
              </View>
            </View>
          )}

          {/* Itinerary */}
          {packageData.itinerary && packageData.itinerary.length > 0 && (
            <View style={styles.section}>
              <View style={styles.itineraryHeader}>
                <Text style={styles.sectionTitle}>Itinéraire</Text>
                <TouchableOpacity onPress={() => setShowFullItinerary(!showFullItinerary)}>
                  <Text style={styles.toggleText}>
                    {showFullItinerary ? 'Masquer' : 'Voir tout'}
                  </Text>
                </TouchableOpacity>
              </View>
              <View style={styles.itineraryContainer}>
                {(showFullItinerary ? packageData.itinerary : packageData.itinerary.slice(0, 3)).map((item, idx) => (
                  <ItineraryDay
                    key={idx}
                    day={item.day || idx + 1}
                    title={item.title}
                    description={item.description}
                  />
                ))}
              </View>
            </View>
          )}

          {/* Price Section */}
          <View style={styles.priceSection}>
            <Text style={styles.priceSectionTitle}>Tarifs</Text>
            <View style={styles.priceRow}>
              <View style={styles.priceItem}>
                <Icon name="person-outline" size={20} color={colors.primary} />
                <View style={styles.priceItemContent}>
                  <Text style={styles.priceItemLabel}>Adulte</Text>
                  <Text style={styles.priceItemValue}>
                    {packageData.price_adult} {packageData.currency}
                  </Text>
                </View>
              </View>
              {packageData.price_child && (
                <View style={styles.priceItem}>
                  <Icon name="happy-outline" size={20} color={colors.secondary} />
                  <View style={styles.priceItemContent}>
                    <Text style={styles.priceItemLabel}>Enfant</Text>
                    <Text style={styles.priceItemValue}>
                      {packageData.price_child} {packageData.currency}
                    </Text>
                  </View>
                </View>
              )}
            </View>
            {packageData.flash_sale_price && (
              <View style={styles.flashSaleBanner}>
                <Icon name="flash" size={16} color={colors.white} />
                <Text style={styles.flashSaleText}>
                  Promo Flash: {packageData.flash_sale_price} {packageData.currency}
                </Text>
              </View>
            )}
          </View>
        </View>
      </ScrollView>

      {/* Bottom Bar */}
      <View style={styles.bottomBar}>
        <View>
          <Text style={styles.bottomPriceLabel}>À partir de</Text>
          <Text style={styles.bottomPrice}>
            {packageData.flash_sale_price || packageData.price_adult} {packageData.currency}
          </Text>
        </View>
        <TouchableOpacity
          style={styles.bookButton}
          onPress={() =>
            navigation.navigate('Booking', {type: 'package', id: packageData.id})
          }>
          <LinearGradient colors={typeGradient} style={styles.bookButtonGradient}>
            <Text style={styles.bookButtonText}>Réserver</Text>
          </LinearGradient>
        </TouchableOpacity>
      </View>
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
  imageContainer: {
    position: 'relative',
  },
  mainImage: {
    width: width,
    height: 300,
    justifyContent: 'center',
    alignItems: 'center',
  },
  thumbnailScroll: {
    position: 'absolute',
    bottom: spacing.md,
    left: 0,
    right: 0,
  },
  thumbnail: {
    width: 60,
    height: 60,
    marginLeft: spacing.sm,
    borderRadius: borderRadius.md,
    overflow: 'hidden',
    borderWidth: 2,
    borderColor: 'transparent',
  },
  thumbnailActive: {
    borderColor: colors.white,
  },
  thumbnailImage: {
    width: '100%',
    height: '100%',
  },
  wishlistButton: {
    position: 'absolute',
    top: spacing.lg,
    right: spacing.md,
    width: 48,
    height: 48,
    borderRadius: borderRadius.round,
    backgroundColor: 'rgba(0,0,0,0.3)',
    justifyContent: 'center',
    alignItems: 'center',
  },
  contentContainer: {
    padding: spacing.md,
  },
  headerInfo: {
    marginBottom: spacing.md,
  },
  titleContainer: {
    flex: 1,
  },
  packageTitle: {
    fontSize: typography.fontSize.xxl,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginBottom: spacing.sm,
  },
  metaRow: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  typeBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.primary,
    paddingHorizontal: spacing.sm,
    paddingVertical: spacing.xs,
    borderRadius: borderRadius.md,
    marginRight: spacing.sm,
  },
  typeText: {
    fontSize: typography.fontSize.xs,
    color: colors.white,
    fontWeight: typography.fontWeight.bold,
    marginLeft: spacing.xs,
  },
  treBadge: {
    backgroundColor: colors.success,
    paddingHorizontal: spacing.sm,
    paddingVertical: spacing.xs,
    borderRadius: borderRadius.md,
  },
  treText: {
    fontSize: typography.fontSize.xs,
    color: colors.white,
    fontWeight: typography.fontWeight.bold,
  },
  infoCards: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: spacing.lg,
  },
  infoCard: {
    flex: 1,
    backgroundColor: colors.white,
    padding: spacing.md,
    borderRadius: borderRadius.lg,
    alignItems: 'center',
    marginHorizontal: spacing.xs,
    ...shadows.sm,
  },
  infoCardValue: {
    fontSize: typography.fontSize.xl,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginTop: spacing.xs,
  },
  infoCardLabel: {
    fontSize: typography.fontSize.xs,
    color: colors.textSecondary,
    marginTop: spacing.xs,
  },
  section: {
    marginBottom: spacing.lg,
  },
  sectionTitle: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginBottom: spacing.sm,
  },
  destinationsContainer: {
    flexDirection: 'row',
    flexWrap: 'wrap',
  },
  destinationChip: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.lighter,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
    borderRadius: borderRadius.round,
    marginRight: spacing.sm,
    marginBottom: spacing.sm,
  },
  destinationText: {
    fontSize: typography.fontSize.sm,
    color: colors.textPrimary,
    marginLeft: spacing.xs,
  },
  description: {
    fontSize: typography.fontSize.md,
    color: colors.textSecondary,
    lineHeight: typography.fontSize.md * 1.6,
  },
  servicesContainer: {
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    padding: spacing.md,
    ...shadows.sm,
  },
  serviceItem: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: spacing.sm,
  },
  serviceText: {
    fontSize: typography.fontSize.md,
    color: colors.textPrimary,
    marginLeft: spacing.sm,
    flex: 1,
  },
  serviceTextExcluded: {
    color: colors.textSecondary,
    textDecorationLine: 'line-through',
  },
  itineraryHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: spacing.sm,
  },
  toggleText: {
    fontSize: typography.fontSize.sm,
    color: colors.primary,
    fontWeight: typography.fontWeight.bold,
  },
  itineraryContainer: {
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    padding: spacing.md,
    ...shadows.sm,
  },
  itineraryDay: {
    flexDirection: 'row',
    marginBottom: spacing.md,
  },
  dayBadge: {
    width: 40,
    height: 40,
    borderRadius: borderRadius.round,
    backgroundColor: colors.primary,
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: spacing.md,
  },
  dayNumber: {
    fontSize: typography.fontSize.md,
    fontWeight: typography.fontWeight.bold,
    color: colors.white,
  },
  dayContent: {
    flex: 1,
  },
  dayTitle: {
    fontSize: typography.fontSize.md,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginBottom: spacing.xs,
  },
  dayDescription: {
    fontSize: typography.fontSize.sm,
    color: colors.textSecondary,
    lineHeight: typography.fontSize.sm * 1.5,
  },
  priceSection: {
    backgroundColor: colors.lighter,
    padding: spacing.md,
    borderRadius: borderRadius.lg,
    marginBottom: spacing.xxl,
  },
  priceSectionTitle: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.textPrimary,
    marginBottom: spacing.md,
  },
  priceRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  priceItem: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.white,
    padding: spacing.md,
    borderRadius: borderRadius.md,
    marginRight: spacing.sm,
    ...shadows.sm,
  },
  priceItemContent: {
    marginLeft: spacing.sm,
  },
  priceItemLabel: {
    fontSize: typography.fontSize.sm,
    color: colors.textSecondary,
  },
  priceItemValue: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.primary,
  },
  flashSaleBanner: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: colors.error,
    padding: spacing.sm,
    borderRadius: borderRadius.md,
    marginTop: spacing.md,
  },
  flashSaleText: {
    fontSize: typography.fontSize.md,
    fontWeight: typography.fontWeight.bold,
    color: colors.white,
    marginLeft: spacing.xs,
  },
  bottomBar: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: spacing.md,
    backgroundColor: colors.white,
    borderTopWidth: 1,
    borderTopColor: colors.border,
    ...shadows.lg,
  },
  bottomPriceLabel: {
    fontSize: typography.fontSize.sm,
    color: colors.textSecondary,
  },
  bottomPrice: {
    fontSize: typography.fontSize.xl,
    fontWeight: typography.fontWeight.bold,
    color: colors.primary,
  },
  bookButton: {
    borderRadius: borderRadius.lg,
    overflow: 'hidden',
    ...shadows.md,
  },
  bookButtonGradient: {
    paddingVertical: spacing.md,
    paddingHorizontal: spacing.xl,
  },
  bookButtonText: {
    fontSize: typography.fontSize.lg,
    fontWeight: typography.fontWeight.bold,
    color: colors.white,
  },
  errorText: {
    fontSize: typography.fontSize.lg,
    color: colors.textSecondary,
    marginTop: spacing.md,
  },
});

export default PackageDetailsScreen;
